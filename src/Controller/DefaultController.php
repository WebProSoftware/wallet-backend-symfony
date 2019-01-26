<?php

namespace App\Controller;

use App\Document\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\BrowserKit\Response;
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
        $user->setFirstname("Matt");
        $user->setLastname("Matt");
        $user->setPassword(md5("123456"));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($user);
        $dm->flush();
        return new JsonResponse(array('Status' => 'OK', 'UserId' => $user->getId()));
    }
}
