<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AbstractType;
/**
 * @Route("/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="app_products_index", methods={"GET", "POST"})
     */
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }
    /**
     * Create a new product.
     * 
     * @Route("/new", name="app_products_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductsRepository $productsRepository): Response
    {
        $product = new Products();
        $form = $this->createForm('App\Form\ProductsType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productsRepository->add($product);
            $productsRepository = $this->getDoctrine()->getManager();
            $productsRepository->persist($product);
            $productsRepository->flush();
            
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('products/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
   *
   * @Route("/{id}",methods={"GET"} ,name="app_products_show")
   */
  public function showAction(Products $products)
  {
    $deleteForm = $this->createDeleteForm($products);

    return $this->render('products/show.html.twig', array(
      'products' => $products,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
     * @Route("/{id}/edit", name="app_products_edit", methods={"GET", "POST"})
     */
  public function editAction(Request $request, Products $products)
  {
    $deleteForm = $this->createDeleteForm($products);
    $editForm = $this->createForm(ProductsType::class, $products);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('app_products_edit', array('id' => $products->getId()));
    }

    return $this->render('products/edit.html.twig', array(
      'products' => $products,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
 * @Route("/products/{id}", name="app_products_delete")
 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $products = $em->getRepository('App\Entity\Products')->find($id);
    $em->remove($products);
    $em->flush();
    
    $this->addFlash(
        'error',
        'Products deleted'
    );
    
    return $this->redirectToRoute('app_products_index');
}


  /**
   *
   * @param Products $products The product entity
   *
   * @return Form The form
   */
  private function createDeleteForm(Products $products): Form
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('app_products_delete', array('id' => $products->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }

  
}
