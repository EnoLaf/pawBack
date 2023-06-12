<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Utils;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'app_animal')]
    public function index(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    #[Route('/animal/create', name: 'app_animal_create')]
    public function createAnimal(EntityManagerInterface $em, AnimalRepository $repo, Request $request):Response
    {   
        $msg = "";
        //Instancier un objet Animal
        $animal = new Animal();
        //instancier un objet formulaire
        $form = $this->createForm(AnimalType::class, $animal);
        //récupérer les données
        $form->handleRequest($request);
        //test si le formulaire est submit
        if($form->isSubmitted()){
            //nettoyage et set des inputs
            $animal->setBreed(Utils::cleanInputStatic($request->request->all('animal')['breed']));
            $animal->setDob(new \DateTimeImmutable($request->request->all('animal')['dob']) );
            $animal->setName(Utils::cleanInputStatic($request->request->all('animal')['name']));
            $animal->setGender(Utils::cleanInputStatic($request->request->all('animal')['gender']));
            $animal->setColor(Utils::cleanInputStatic($request->request->all('animal')['color']));
            if(Utils::cleanInputStatic($request->request->all('animal')['idChip'])==''){
                $animal->setIdChip(null);
            }else{
                $animal->setIdChip(Utils::cleanInputStatic(Utils::cleanInputStatic($request->request->all('animal')['idChip'])));
            }
            $animal->setSterelisation($request->request->all('animal')['sterelisation']);
            $animal->setMedicalHistory(Utils::cleanInputStatic($request->request->all('animal')['medicalHistory']));
            $animal->setActivate(true);
            $animal->setOwner($this->getUser());
            //récupération d'un animal
            $recup = $repo->findOneBy(['name'=>$animal->getName()]);
            //tester si l'animal existe
            if($recup){
                $msg = "L'animal : ".$animal->getName()." existe déja";
            }else{
                //persister les données
                $em->persist($animal);
                //ajoute en BDD
                $em->flush();
            }

            $msg = "L'animal : ".$animal->getName()." a été ajouté en BDD";
            
        }
        return $this->render('animal/index.html.twig', [
            'msg'=> $msg,
            'form'=> $form->createView(),
        ]);
    }

    #[Route('/animal/read', name: 'app_animal_read')]
    public function readAnimal(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    #[Route('/animal/update', name: 'app_animal_update')]
    public function updateAnimal(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    #[Route('/animal/desactivate', name: 'app_animal_desactivate')]
    public function desactivateAnimal(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }
}
