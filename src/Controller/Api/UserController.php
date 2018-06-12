<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Validator\Constraints\Date;
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
                $model->setRole(json_encode([ "role_id" => 1 ]));
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

        $user = $repositoryUser->findOneBy(['token' => $token]);
        if($user) {

        }
    }

    public function update(Request $request) {

    }

    public function delete(Request $request) {

    }
}
