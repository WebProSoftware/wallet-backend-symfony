<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Entity\UserDetails;
use App\Entity\UserRole;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function authenticate(Request $request) {
        if($request->getMethod()  == "POST" ) {
            $email = $request->get('username');
            $pass = $request->get('password');

            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            $response = new Response();
            if($user && ($user->getPassword() == md5($pass . $user->getSalt()) )) {
                $user->setLastAccess(new \DateTime());

                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();

                if($user->getBlocked()) {
                    $response->setContent(json_encode([
                        'status' => 'fail',
                        'msg' => 'Konto zostało zablokowane przez Administratora'
                    ]));
                }
                else if($user->getActive()) {
                    $response->setContent(json_encode([
                        'id' => $user->getId(),
                        'email' => $user->getEmail(),
                        'token' => $user->getToken(),
                        'status'=> 'success',
                    ]));
                }
                else {
                    $response->setContent(json_encode([
                        'status' => 'fail',
                        'msg' => 'Konto jest dezaktywowane w celu ponownej aktywacji skontaktuje sie z biurem obslugi'
                    ]));
                }
            }
            else {
                $response->setContent(json_encode([
                    'status' => 'fail',
                    'msg' => 'Nieprawidłowy login lub hasło'
                ]));
            }

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request) {
        if($request->getMethod()  == "POST" ) {
            $em = $this->getDoctrine()->getManager();

            $response = new Response();
            $repositoryUser = $this->getDoctrine()->getRepository(User::class);
            $repositoryRole = $this->getDoctrine()->getRepository(UserRole::class);

            $role = $repositoryRole->findOneBy(['name' => "ROLE_USER"]);
            if(!$role) {
                exit('Role error');
            }

            $data = $request->get('data');
            $email = $data['email'];
            $pass = $data['password'];

            if(!$repositoryUser->findOneBy(['email' => $email])) {
                $now = new \DateTime();

                $model = new User();
                $model->setActive(true);
                $model->setCreatedAt($now);
                $model->setUpdatedAt($now);
                $model->setEmail($email);
                $model->addUserRole($role);
                $model->setSalt(md5($now->getTimestamp()));
                $model->setPassword(md5($pass . $model->getSalt()));
                $model->setToken(sha1($model->getPassword()));

                $em->persist($model);
                $em->flush();

                $result = [
                    "status" => "success",
                    "msg" => "Zarejestrowano nowego użytkownika, możesz sie juz zalogować",
                ];
            }
            else {
                $result = [
                    "status" => "fail",
                    "msg" => "Podany email istnieje",
                ];
            }

            $response->setContent(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
    
    public function read(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);

        $auth = $request->headers->get('authorization');
        $token = str_replace("Bearer ","",$auth);

        $response = new Response();
        $user = $repositoryUser->findOneBy(['token' => $token]);
        if($user) {

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(2);
            $normalizer->setIgnoredAttributes([
                'password',
                'salt',
                'token',
                'active',
                'blocked'
            ]);
            // Add Circular reference handler
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);
            $result = $serializer->serialize($user, 'json');

            $response->setContent($result);
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }

    public function update(Request $request , $id) {
        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);

        $userForm = $request->get('data');
        $error = false;
        $result = [];


        $response = new Response();
        $user = $repositoryUser->findOneBy(['id' => $id]);
        $validEmail = $repositoryUser->findOneBy(['email' => $userForm['email']]);
        

        if($validEmail) {
            if( ($validEmail->getId() != $user->getId()) ) {
                $error = true;
                $result = [
                    'status' => "fail",
                    'msg' => "W bazie danych istnieje juz taki email",
                ];
            }
        }

        if($user && !$error) {

            if($user->getUserDetails()) $userDetails = $user->getUserDetails();
            else $userDetails = new UserDetails();

            $userDetails->setFirstName($userForm['firstName']);
            $userDetails->setLastName($userForm['lastName']);

            if($user->getUserAdress()) $userAddress = $user->getUserAdress();
            else $userAddress = new UserAddress();

            $userAddress->setCity($userForm['city']);
            $userAddress->setStreet($userForm['street']);
            $userAddress->setNumberLocal($userForm['numberLocal']);
            $userAddress->setPostCode($userForm['postCode']);

            $user->setEmail($userForm['email']);
            $user->setUpdatedAt(new \DateTime());
            $user->setUserAdress($userAddress);
            $user->setUserDetails($userDetails);

            $em->persist($user);
            $em->flush();

            $result = [
                "status" => "success",
                "msg" => "Zapisano zmiany."
            ];

        }
        $response->setContent(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function delete(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);

        $response = new Response();
        $result = [];

        $user = $repositoryUser->findOneBy(['id' => $id]);
        if($user) {
            $user->setActive(false);
            $em->persist($user);
            $em->flush();

            $result = [
                "status" => "success",
                "msg" => "usniety",
            ];
        }

        $response->setContent(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
