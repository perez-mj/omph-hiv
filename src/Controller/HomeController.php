<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): RedirectResponse
    {
        // Check if user is authenticated
        if (!$this->getUser()) {
            // User is not logged in, redirect to login page
            return $this->redirectToRoute('app_login');
        }
        
        // User is logged in, redirect to admin dashboard
        return $this->redirectToRoute('admin_dashboard');
    }
}