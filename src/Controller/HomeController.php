<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        $counter =  $session->get('counter', 0);
        $counter++;

        $session->set('counter', $counter);
        return $this->render('home/index.html.twig');
    }

    #[Route('/mock-response', methods: ['POST'])]
    public function mockResponse(Request $request): Response
    {
        $name = $request->request->get('name', 'Test Item');
        return new Response(
            "<div class='notification is-success'>Created: {$name}</div>"
        );
    }

}
