<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Form\SuppliersType;
use App\Repository\SuppliersRepository;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/suppliers")
 */
class SuppliersController extends AbstractController
{
    
    /**
     * @Route("/", name="app_suppliers_index", methods={"GET"})
     */
    public function index(SuppliersRepository $suppliersRepository): Response
    {
        return $this->render('suppliers/index.html.twig', [
            'suppliers' => $suppliersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_suppliers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SuppliersRepository $suppliersRepository): Response
    {
        $supplier = new Suppliers();
        $form = $this->createForm('App\Form\SuppliersType', $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suppliersRepository->add($supplier);
            $suppliersRepository = $this->getDoctrine()->getManager();
            $suppliersRepository->persist($supplier);
            $suppliersRepository->flush();
            
            return $this->redirectToRoute('app_suppliers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suppliers/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/{id}", name="app_suppliers_show", methods={"GET"})
     */
    public function showAction(Suppliers $suppliers)
    {
        $deleteForm = $this->createDeleteForm($suppliers);
    
        return $this->render('suppliers/show.html.twig', array(
          'suppliers' => $suppliers,
          'delete_form' => $deleteForm->createView(),
        ));
      }

    /**
     * @Route("/{id}/edit", name="app_suppliers_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Suppliers $suppliers)
    {
        $deleteForm = $this->createDeleteForm($suppliers);
        $editForm = $this->createForm(SuppliersType::class, $suppliers);
        $editForm->handleRequest($request);
    
        if ($editForm->isSubmitted() && $editForm->isValid()) {
          $this->getDoctrine()->getManager()->flush();
    
          return $this->redirectToRoute('app_suppliers_edit', array('id' => $suppliers->getId()));
        }
    
        return $this->render('suppliers/edit.html.twig', array(
          'suppliers' => $suppliers,
          'edit_form' => $editForm->createView(),
          'delete_form' => $deleteForm->createView(),
        ));
      }
    
    /**
 * @Route("/suppliers/{id}", name="app_suppliers_delete")
 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $suppliers = $em->getRepository('App\Entity\Suppliers')->find($id);
    $em->remove($suppliers);
    $em->flush();
    
    $this->addFlash(
        'error',
        'Products deleted'
    );
    
    return $this->redirectToRoute('app_suppliers_index');

  }

    private function createDeleteForm(Suppliers $suppliers): Form
    {
      return $this->createFormBuilder()
        ->setAction($this->generateUrl('app_suppliers_delete', array('id' => $suppliers->getId())))
        ->setMethod('DELETE')
        ->getForm();
    }
}