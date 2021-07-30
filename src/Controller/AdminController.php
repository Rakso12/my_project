<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController - current not used.
 * @package App\Controller
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dash", name="admin_dashboard")
     */
    public function dashBoard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


}
