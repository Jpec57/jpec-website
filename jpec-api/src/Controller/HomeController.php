<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }

        /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        return $this->json([
            'message' => 'You are connected',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
}
