<?php

namespace App\Controller;

use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AbstractType;
/**
 * @Route("/books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("/", name="app_books_index", methods={"GET", "POST"})
     */
    public function index(BooksRepository $booksRepository): Response
    {
        return $this->render('books/index.html.twig', [
            'books' => $booksRepository->findAll(),
        ]);
    }
    /**
     * Create a new book.
     * 
     * @Route("/new", name="app_books_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BooksRepository $booksRepository): Response
    {
        $book = new Books();
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booksRepository->add($book);
            $booksRepository = $this->getDoctrine()->getManager();
            $booksRepository->persist($book);
            $booksRepository->flush();
            
            return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('books/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
   *
   * @Route("/{id}",methods={"GET"} ,name="app_books_show")
   */
  public function showAction(Books $books)
  {
    $deleteForm = $this->createDeleteForm($books);

    return $this->render('books/show.html.twig', array(
      'books' => $books,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
     * @Route("/{id}/edit", name="app_books_edit", methods={"GET", "POST"})
     */
  public function editAction(Request $request, Books $books)
  {
    $deleteForm = $this->createDeleteForm($books);
    $editForm = $this->createForm(BooksType::class, $books);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('app_books_edit', array('id' => $books->getId()));
    }

    return $this->render('books/edit.html.twig', array(
      'books' => $books,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
 * @Route("/books/{id}", name="app_books_delete")
 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $books = $em->getRepository('App\Entity\Books')->find($id);
    $em->remove($books);
    $em->flush();
    
    $this->addFlash(
        'error',
        'Books deleted'
    );
    
    return $this->redirectToRoute('app_books_index');
}


  /**
   *
   * @param Books $books The book entity
   *
   * @return Form The form
   */
  private function createDeleteForm(Books $books): Form
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('app_books_delete', array('id' => $books->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }

  
}
