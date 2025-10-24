<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/listeAuthour', name: 'app_listeAuthor')]
    public function listeAuthors(): Response
    {
        $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        $nbAuthors = count($authors);

        $totalBooks = array_sum(array_column($authors, 'nb_books'));

        return $this->render('author/list.html.twig', [
            'A' => $authors,
            'nbAuthors' => $nbAuthors,
            'totalBooks' => $totalBooks,
        ]);
    }

    #[Route('/author/{id}', name: 'app_author_details')]
    public function authorDetails(int $id): Response
    {
        
        $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        $author = null;
        foreach ($authors as $a) {
            if ($a['id'] == $id) {
                $author = $a;
                break;
            }
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/show', name: 'app_showauthor')]
    function show(AuthorRepository $repoAuthor):Response
    {
        $listAuthors = $repoAuthor->findAll();
        return $this->render('author/affiche.html.twig', [
            'authors' => $listAuthors]);
    }

    
    #[Route('/addstatique', name: 'app_addstatique')]
    function AddStatique(EntityManagerInterface $entityManager):Response
    {
        $auther1 = new Author();
        $auther1->setUsername('auteur1');
        $auther1->setEmail('auteur1@gmail.com');

        $entityManager->persist($auther1);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_showauthor');
    }


    #[Route('/add_author', name: 'app_add_author')]
    public function addAuthor(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('app_show_author');
        }

        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_author')]
    public function editAuthor(Request $request, EntityManagerInterface $entityManager, AuthorRepository $authorRepository, int $id): Response
    {
        $author = $authorRepository->find($id);
        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_show_author');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_author')]
    public function deleteAuthor(EntityManagerInterface $entityManager, AuthorRepository $authorRepository, int $id): Response
    {
        $author = $authorRepository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute('app_show_author');
    }

}
