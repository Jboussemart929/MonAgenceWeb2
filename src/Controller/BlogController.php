<?php

namespace App\Controller;


use App\Entity\Annonce;
use App\Entity\Category;
use App\Controller\BlogController;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(AnnonceRepository $repo)
    {
        $annonces = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('blog/home.html.twig');
}

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Annonce $annonce = null, Request $request, EntityManagerInterface  $manager) {

        if(!$annonce)  { 
            $annonce = new Annonce();
        }
       

        $form = $this->createFormBuilder($annonce)
                     ->add('title')
                     ->add('content')
                     ->add('category', EntityType::class, [
                        'class' =>Category::class,
                        'choice_label' => 'titre' 
                     ])
                     ->add('image')->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           
            $annonce->setCreatedAt(new \DateTime());

            $manager->persist($annonce);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $annonce->getId()]);
            }
 

        return $this->render('blog/create.html.twig', [
            'formAnnonce' => $form->createView(),
            'editMode' => $annonce->getId() !== null
        ]);
    }

     /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Annonce $annonce) {

      
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
}
}

     
