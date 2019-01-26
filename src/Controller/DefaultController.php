<?php

namespace App\Controller;

use App\Document\MoneyCategory;
use App\Document\MoneyType;
use App\Document\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return JsonResponse::create(['Api wallet'], JsonResponse::HTTP_OK);
    }


    /**
     * @Route("/mongoTest")
     * @Method("GET")
     */
    public function mongoTest() {
        $user = new User();
        $user->setEmail("admin@admim.com");
        $user->setPassword(md5("123456"));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($user);
        $dm->flush();
        return new JsonResponse(array('Status' => 'OK', 'UserId' => $user->getId()));
    }

    /**
     * @Route("/createType")
     * @Method("GET")
     */
    public function setMoneyType() {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $moneyTypeP = new MoneyType();
        $moneyTypeP->setName("PRZYCHODY");
        $moneyTypeP->setShortName("P");

        $moneyTypeW = new MoneyType();
        $moneyTypeW->setName("WYDATKI");
        $moneyTypeW->setShortName("W");

        $dm->persist($moneyTypeP);
        $dm->persist($moneyTypeW);
        $dm->flush();

        return new JsonResponse(array(
            "status" => 'ok',
            'add1' => $moneyTypeP->getId(),
            'add2' => $moneyTypeW->getId()
        ));

    }


    /**
     * @Route("/createCategory")
     * @Method("GET")
     */
    public function setMoneyCategory() {
        $dm = $this->get('doctrine_mongodb')->getManager();

        $repositoryUser = $this->get('doctrine_mongodb')->getRepository(MoneyType::class);
        $przychody = $repositoryUser->findOneBy(['short_name' => 'P']);
        $wydatki = $repositoryUser->findOneBy(['short_name' => 'W']);

        $wyplata = new MoneyCategory();
        $wyplata->setName("Wyplata");
        $wyplata->setDistance(false);
        $wyplata->setMoneyType($przychody);
        $wyplata->setDescription("");


        $jedzienie = new MoneyCategory();
        $jedzienie->setName("Jedzienie");
        $jedzienie->setDistance(false);
        $jedzienie->setMoneyType($wydatki);
        $jedzienie->setDescription("");

        $paliwo = new MoneyCategory();
        $paliwo->setName("Paliwo");
        $paliwo->setDistance(true);
        $paliwo->setMoneyType($wydatki);
        $paliwo->setDescription("");

        $rachunki = new MoneyCategory();
        $rachunki->setName("Rachunki");
        $rachunki->setDistance(false);
        $rachunki->setMoneyType($wydatki);
        $rachunki->setDescription("");

        $dm->persist($wyplata);
        $dm->persist($jedzienie);
        $dm->persist($paliwo);
        $dm->persist($rachunki);

        $dm->flush();

        return new JsonResponse(array(
            "status" => 'ok',
        ));
    }
}
