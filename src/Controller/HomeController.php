<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * Montre la page qui dit bonjour.
     *
     * @Route("/hello", name="hello_only")
     * @Route("/hello/{age}", name="hello_age")
     * @Route("/hello/{prenom}/{age}", name="hello_name_age")
     * @return void
     */
    public function hello($prenom = 'toi', $age = 0){
        // return new Response ('Bonjour ' . $prenom . ($age == 0 ? '' : ', vous avez ' . $age . ' ans !'));
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => 'Magali',
                'age' => 95    
            ]
        );
    }
    /**
     * Undocumented function
     *
     * @Route("/", name="homepage")
     * @return void
     */
    public function home(AdRepository $adRepo, UserRepository $userRepo){
        return $this->render('home.html.twig', [ 
                'ads' => $adRepo->findBestAds(3),
                'users' => $userRepo->findBestUsers()
            ]
        );
    }

}