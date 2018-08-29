<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = $this->get('simpleshop.products.query')->getAllOrderedByCreatedAt();
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
        $productModelFactory = $this->get('simpleshop.form.product.model.factory');
        $product = $productModelFactory->getProductModel();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('add.html.twig', ["form" => $form->createView()]);
    }
}