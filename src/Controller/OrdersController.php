<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AbstractType;
/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="app_orders_index", methods={"GET", "POST"})
     */
    public function index(OrdersRepository $ordersRepository): Response
    {
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }
    /**
     * Create a new order.
     * 
     * @Route("/new", name="app_orders_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OrdersRepository $ordersRepository): Response
    {
        $order = new Orders();
        $form = $this->createForm('App\Form\OrdersType', $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersRepository->add($order);
            $ordersRepository = $this->getDoctrine()->getManager();
            $ordersRepository->persist($order);
            $ordersRepository->flush();
            
            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
   *
   * @Route("/{id}",methods={"GET"} ,name="app_orders_show")
   */
  public function showAction(Orders $orders)
  {
    $deleteForm = $this->createDeleteForm($orders);

    return $this->render('orders/show.html.twig', array(
      'orders' => $orders,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
     * @Route("/{id}/edit", name="app_orders_edit", methods={"GET", "POST"})
     */
  public function editAction(Request $request, Orders $orders)
  {
    $deleteForm = $this->createDeleteForm($orders);
    $editForm = $this->createForm(OrdersType::class, $orders);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('app_orders_edit', array('id' => $orders->getId()));
    }

    return $this->render('orders/edit.html.twig', array(
      'orders' => $orders,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   *
   * @Route("/orders/{id}", name="app_orders_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $orders = $em->getRepository('App\Entity\Orders')->find($id);
    $em->remove($orders);
    $em->flush();
    
    $this->addFlash(
        'error',
        'Orders deleted'
    );

    return $this->redirectToRoute('app_orders_index');
  }

  /**
   *
   * @param Orders $orders The order entity
   *
   * @return Form The form
   */
  private function createDeleteForm(Orders $orders): Form
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('app_orders_delete', array('id' => $orders->getId())))
      ->setMethod('DELETE')
      ->getForm();
      
  }
}