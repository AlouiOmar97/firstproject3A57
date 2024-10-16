<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AddEditBookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/list', name: 'app_book_list')]
    public function bookList(BookRepository $bookRepository){
        $books= $bookRepository->findAll();
        //dd($books);
        return $this->render('book/list.html.twig',[
            'books' => $books
        ]);
    }

    #[Route('/book/details/{id}', name: 'app_book_details')]
    public function bookDetails($id, ManagerRegistry $doctrine){
        $bookRepository= $doctrine->getRepository(Book::class);
        $book= $bookRepository->find($id);
        return $this->render('book/details.html.twig',[
            'book' => $book
        ]);
    }
    
    #[Route('/book/new', name: "app_book_new")]
    public function newBook(Request $request, ManagerRegistry $doctrine){
        $book= new Book();
        $em= $doctrine->getManager();
        $form= $this->createForm(AddEditBookType::class, $book);
        //$form->add('Add',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/form.html.twig',[
            'title' => 'Add Book',
            'form' => $form
        ]);

    }


    #[Route('/book/edit/{id}', name: "app_book_edit")]
    public function editBook($id, Request $request, ManagerRegistry $doctrine){
        $bookRepository= $doctrine->getRepository(Book::class);
        $book= $bookRepository->find($id);
        $em= $doctrine->getManager();
        $form= $this->createForm(AddEditBookType::class, $book);
        //$form->add('Add',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/form.html.twig',[
            'title' => 'Update Book',
            'form' => $form
        ]);

    }

    #[Route('/book/delete/{id}', name: 'app_book_delete')]
    public function deleteBook($id, EntityManagerInterface $em, BookRepository $bookRepository){
        $book = $bookRepository->find($id);
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("app_book_list");
    }
}
