<?php

namespace App\Controller;

use App\Application\Command\AddNewProductCommand;
use App\Application\Query\ProductsQueryInterface;
use App\Entity\Product;
use App\Form\ProductType;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function index(Request $request, ProductsQueryInterface $productsQuery)
    {
        $products = $productsQuery->getAllOrderedByCreatedAt();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('index.html.twig', ['pagination' => $pagination] );
    }

    public function add(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product = $form->getData();
            $this->commandBus->handle((new AddNewProductCommand($product)));

            return $this->redirectToRoute('index');
        }

        return $this->render('add.html.twig', ["form" => $form->createView()]);
    }
}