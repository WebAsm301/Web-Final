<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Form\CustomersType;
use App\Repository\CustomersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AbstractType;
/**
 * @Route("/customers")
 */
class CustomersController extends AbstractController
{
    /**
     * @Route("/", name="app_customers_index", methods={"GET", "POST"})
     */
    public function index(CustomersRepository $customersRepository): Response
    {
        return $this->render('customers/index.html.twig', [
            'customers' => $customersRepository->findAll(),
        ]);
    }
    /**
     * Create a new customer.
     * 
     * @Route("/new", name="app_customers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CustomersRepository $customersRepository): Response
    {
        $customer = new Customers();
        $form = $this->createForm(Customers::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customersRepository->add($customer);
            $customersRepository = $this->getDoctrine()->getManager();
            $customersRepository->persist($customer);
            $customersRepository->flush();
            
            return $this->redirectToRoute('app_customers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customers/new.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    /**
   *
   * @Route("/{id}",methods={"GET"} ,name="app_customers_show")
   */
  public function showAction(Customers $customers)
  {
    $deleteForm = $this->createDeleteForm($customers);

    return $this->render('customers/show.html.twig', array(
      'customers' => $customers,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
     * @Route("/{id}/edit", name="app_customers_edit", methods={"GET", "POST"})
     */
  public function editAction(Request $request, Customers $customers)
  {
    $deleteForm = $this->createDeleteForm($customers);
    $editForm = $this->createForm(CustomersType::class, $customers);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('app_customers_edit', array('id' => $customers->getId()));
    }

    return $this->render('customers/edit.html.twig', array(
      'customers' => $customers,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
 * @Route("/customers/{id}", name="app_customers_delete")
 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $customers = $em->getRepository('App\Entity\Customers')->find($id);
    $em->remove($customers);
    $em->flush();
    
    $this->addFlash(
        'error',
        'Customers deleted'
    );
    
    return $this->redirectToRoute('app_customers_index');
}


  /**
   *
   * @param Customers $customers The customer entity
   *
   * @return Form The form
   */
  private function createDeleteForm(Customers $customers): Form
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('app_customers_delete', array('id' => $customers->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }
}
