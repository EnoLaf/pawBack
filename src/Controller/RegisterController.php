<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Utils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\Messagerie;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function userAdd(EntityManagerInterface $em, UserRepository $repo,
    Request $request, UserPasswordHasherInterface $hash, Messagerie $messagerie):Response
    {   
        $msg = "";
        //Instancier un objet User
        $user = new User();
        //instancier un objet formulaire
        $form = $this->createForm(UserType::class, $user);
        //récupérer les données
        $form->handleRequest($request);
        //test si le formulaire est submit
        if($form->isSubmitted()){
            //récupération du password
            $pass = Utils::cleanInputStatic($request->request->all('user')['password']['first']);
            //hashage du password
            $hash = $hash->hashPassword($user, $pass);
            //nettoyage des inputs
            $lastName = Utils::cleanInputStatic($request->request->all('user')['lastName']);
            $firstName = Utils::cleanInputStatic($request->request->all('user')['firstName']);
            $email = Utils::cleanInputStatic($request->request->all('user')['email']);
            //set des attributs nettoyé
            $user->setPassword($hash);
            $user->setLastName($lastName);
            $user->setFirstName($firstName);
            $user->setEmail($email);
            $user->setRoles(["ROLE_USER"]);
            $user->setActivate(false);

            //récupération d'un compte utilisateur
            $recup = $repo->findOneBy(['email'=>$user->getEmail()]);
            //tester si le compte existe
            if($recup){
                $msg = "Le compte : ".$user->getEmail()." existe déja";
            }else{
                //persister les données
                $em->persist($user);
                //ajoute en BDD
                $em->flush();
            }
            //récupération des ID de messagerie
            $login=$this->getParameter('login');
            $mdp=$this->getParameter('mdp');

            //variable pour le mail
            $objet = 'Activation de votre compte';
            $content = '<p>Bienvenue chez PAW '.mb_convert_encoding($user->getFirstName(), 'ISO-8859-1', 'UTF-8').'!<br>Pour activer votre compte veuillez cliquer ci-dessous:</p>'.
            '<a href="https://127.0.0.1:8001/register/activate/'.$user->getId().'">Activer mon compte</a>';

            //on stocke la fonction dans une variable
            $statut = $messagerie->sendEmail($login, $mdp, $email, $objet, $content);

            $msg = "Le compte : ".$user->getEmail()." a été ajouté en BDD";
            
        }
        return $this->render('register/index.html.twig', [
            'msg'=> $msg,
            'form'=> $form->createView(),
        ]);
    }

    #[Route('/register/activate/{id}', name: 'app_register_activate')]
    public function userActivate(EntityManagerInterface $em, UserRepository $userRepository, int $id):Response{  
        //récupérer user par son id 
        $user = $userRepository->find($id);

        //passer actiavate à 1
        $user->setActivate(true);
        
        if($user){
            //persister les données
            $em->persist($user);
            //ajoute en BDD
            $em->flush();
            //rediriger ver la connexion
            return $this->redirectToRoute('app_login');
        }else{  //sinon le compte n'existe pas
            //rediriger ver la connexion
            return $this->redirectToRoute('app_register');
        }

        return $this->render('register/index2.html.twig', [
        ]);
    }
    
}
