<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/", name="search_form")
     */
    public function index()
    {
        return $this->render('search.html.twig');
    }

    /**
     * @Route("/search", name="search_json")
     */
    public function search(Request $request)
    {
        //$request->get('startDate');
        //$request->get('endDate');

        return $this->json([
        	$request->get('companySymbol')
        ]);
    }
}
