<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AddAuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    public $authors = array( 

        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100), 
        
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ), 
        
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300), 
        
        ); 
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showAuthor/{name}', name: 'app_show_author')]
    public function showAuthor($name){
        return $this->render('author/show.html.twig',[
            'name' => $name
        ]);
    }

    #[Route('/author/list', name: 'app_authors_list')]
    public function listAuthors(AuthorRepository $authorRepository){
        $authorsDB= $authorRepository->findByUser('William Shakespeare');
         //dd($authorsDB);
        return $this->render('author/list.html.twig',[
            'authors' => $authorsDB
        ]);
    }


    #[Route('/author/details/{id}', name: 'app_author_details')]
    public function authorDetails($id, AuthorRepository $authorRepository){
        $author= $authorRepository->find($id);
        //$author=$authorRepository->findByNbBooks(250);
        return $this->render('author/details.html.twig',[
            'author'=> $author
        ]);

    }

    #[Route('/author/add', name: 'app_author_add')]
    public function addAuthor(Request $request,EntityManagerInterface $em){
        $author= new Author();
        $form= $this->createForm(AddAuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //dd($author);
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_authors_list');
        }
        return $this->render('author/form.html.twig',[
            'title'=> 'Add Author',
            'author' => $author,
            'form' => $form
        ]);
    }

    #[Route('/author/search', name: 'app_author_search')]
    public function searchAuthor(BookRepository $authorRepository) {
        $author= $authorRepository->findByUserBookDQL('Tah');
        dd($author);
    }

    #[Route('/author/edit/{id}', name: 'app_author_edit')]
    public function editAuthor($id, AuthorRepository $authorRepository, ManagerRegistry $doctrine, Request $request){
        $author= $authorRepository->find($id);
        $em= $doctrine->getManager();
        $form= $this->createForm(AddAuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_authors_list');
        }
        return $this->render('author/form.html.twig',[
            'title'=> 'Update Author',
            'author'=> $author,
            'form' => $form
        ]);
    }

    #[Route('/author/new/{username}', name: 'app_author_new')]
    public function newAuthor($username,EntityManagerInterface $em){
        $author=new Author();
        $author->setUsername($username);
        $author->setEmail('victor@gmail.com');
        $author->setPicture('/images/Victor-Hugo.jpg');
        $author->setNbBooks(250);
        $em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('author/delete/{id}', name: 'app_author_delete')]
    public function deleteAuthor($id, EntityManagerInterface $em, AuthorRepository $authorRepository){
        $author =$authorRepository->find($id);
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_authors_list');
        //return new Response('Author deleted');
    }

    #[Route('/author/update/{id}', name: 'app_author_update')]
    public function updateAuthor($id, EntityManagerInterface $em, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);
        $author->setUsername('username updated 2');
        $author->setEmail('email updated');
        $em->persist($author);
        $em->flush();
        dd($author);
    }

}
