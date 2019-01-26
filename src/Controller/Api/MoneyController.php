<?php

namespace App\Controller\Api;

use App\Document\Money;
use App\Document\MoneyCategory;
use App\Document\MoneyDetails;
use App\Document\MoneyType;
use App\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MoneyController extends Controller {

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $repositoryMoney = $this->getDoctrine()->getRepository(Money::class);

        $auth = $request->headers->get('authorization');
        $token = str_replace("Bearer ","",$auth);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $user = $repositoryUser->findOneBy(['token' => $token]);

        // valid auth
        if(!$user) {
            $response->setContent(json_encode([
                'status' => "fail",
                'msg' => "Brak autoryzacji"
            ]));
            return $response;
        }
        
        if(!$user->getMonies()) {
            $response->setContent(json_encode([
                'status' => "success",
                'msg' => "Brak wpisów"
            ]));
            return $response;
        }

        $money = $repositoryMoney->findBy(['User' => $user]);
        if(!$money) {
            $response->setContent(json_encode([
                'status' => 'success',
                'msg' => 'Brak wpisów',
            ]));
            return $response;
        }

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setIgnoredAttributes([
            'User',
        ]);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $result = $serializer->serialize($money, 'json');

        $response->setContent($result);

        return $response;
    }

    public function create(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $repositoryMoneyCategory = $this->getDoctrine()->getRepository(MoneyCategory::class);

        $response = new Response();
        $auth = $request->headers->get('authorization');
        $token = str_replace("Bearer ","",$auth);

        $user = $repositoryUser->findOneBy(['token' => $token]);
        // valid auth
        if(!$user) {
            $response->setContent(json_encode([
                'status' => "fail",
                'msg' => "Brak autoryzacji"
            ]));
            return $response;
        }
        $moneyForm = $request->get('data');

        $modelMoneyCategory = $repositoryMoneyCategory->findOneBy(['id' => $moneyForm['category']]);
        if(!$modelMoneyCategory) {
            $response->setContent(json_encode([
                'status' => "fail",
                'msg' => "Brak kategori w bazie danych"
            ]));
            return $response;
        }


        if($modelMoneyCategory->getMoneyType()->getShortName() == "W"){
            if( (int) $moneyForm['amountTotal'] > 0) {
                $moneyForm['amountTotal'] =  (- $moneyForm['amountTotal']);
            }
        }
        else {
            if( (int) $moneyForm['amountTotal'] < 0) {
                $moneyForm['amountTotal'] =  abs($moneyForm['amountTotal']);
            }
        }

        $modelMoneyDetails = new MoneyDetails();
        $modelMoneyDetails->setTitle(isset($moneyForm["title"]) ? $moneyForm['title'] : "");

        $modelMoney = new Money();
        $modelMoney->setAmountTotal($moneyForm['amountTotal']);
        $modelMoney->setCreatedAt(new \DateTime($moneyForm['data']));
        $modelMoney->setMoneyDetails($modelMoneyDetails);
        $modelMoney->setMoneyCategory($modelMoneyCategory);
        $modelMoney->setUser($user);

        $em->persist($modelMoney);
        $em->flush();

        $response->setContent(json_encode([
            'status' => 'success',
            'msg' => "Dodano nowy wpis"
        ]));

        return $response;
    }

    public function delete($id) {
        $em = $this->getDoctrine()->getManager();
        $repositoryMoney = $this->getDoctrine()->getRepository(Money::class);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $money = $repositoryMoney->findOneBy(['id' => $id]);
        if($money) {
            $em->remove($money);
            $em->flush();

            $response->setContent(json_encode([
                'status' => 'success',
                'msg' => "Usunięto wpis"
            ]));
        }

        return $response;
    }

    /**
     * @return Response
     */
    public function categories() {
        $em = $this->getDoctrine()->getManager();
        $repositoryMoneyCategory = $this->getDoctrine()->getRepository(MoneyCategory::class);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setIgnoredAttributes([
            'user',
        ]);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $result = $serializer->serialize($repositoryMoneyCategory->findAll(), 'json');
        $response->setContent($result);
        return $response;
    }

    public function moneyStat(Request $request) {

        $repositoryUser = $this->get('doctrine_mongodb')->getRepository(User::class);
        $repositoryMoney = $this->get('doctrine_mongodb')->getRepository(Money::class);

        $auth = $request->headers->get('authorization');
        $token = str_replace("Bearer ","",$auth);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $user = $repositoryUser->findOneBy(['token' => $token]);

        // valid auth
        if(!$user) {
            $response->setContent(json_encode([
                'status' => "fail",
                'msg' => "Brak autoryzacji"
            ]));
            return $response;
        }

        if(!$user->getMonies()) {
            $response->setContent(json_encode([
                'status' => "success",
                'msg' => "Brak wpisów"
            ]));
            return $response;
        }

        $money = $repositoryMoney->findBy(['User' => $user]);

        $wydatki    = 0;
        $przychody  = 0;
        $bilans     = 0;
        $paliwo     = 0;

        foreach ($money as $item) {
            $bilans += $item->getAmountTotal();
            if($item->getMoneyCategory()->getMoneyType()->getShortName() == "W") {
                $wydatki += $item->getAmountTotal();
            } else {
                $przychody += $item->getAmountTotal();
            }

            if($item->getMoneyCategory()->getDistance()) {
                $paliwo += $item->getAmountTotal();
            }
        }
        $response->setContent(json_encode([
            'wydatki' => $wydatki,
            'przychody' => $przychody,
            'bilans' => $bilans,
            'paliwo' => $paliwo
        ]));
        return $response;

    }

}