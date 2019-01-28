<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/person/add", name="person")
     */
    public function index()
    {
        $em = $this->get('doctrine')->getManager();
        $person1 = new Person();
        $person1->setName('personne1');
        $em->persist($person1);
        $movie1 = new Movie();
        $movie1->setTitle('Film1')
            ->setDescription('Blablabla')
            ->setDirector($person1)
            ->addActor($person1);
        $em->persist($movie1);


        //dump($movie1); die();


        $em->flush();


        return $this->render('person/index.html.twig');
    }
}
