<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSupplierController extends AbstractController
{
    /**
     * @Route("/api/supplier", name="app_api_supplier")
     */
    public function index(): Response
    {
        return $this->render('api_supplier/index.html.twig', [
            'controller_name' => 'ApiSupplierController',
        ]);
    }
}
