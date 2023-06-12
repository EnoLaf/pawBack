<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Service\ApiRegister;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Utils;
use App\Service\Messagerie;
use Doctrine\ORM\EntityManagerInterface;


class ApiController extends AbstractController
{    
    #[Route('/api/verif', name:'app_api_verif')]
    public function verifConnexion(Request $request, UserPasswordHasherInterface $hash,
    UserRepository $user, ApiRegister $apiRegister){
        $mail = $request->query->get('email');
        $password = $request->query->get('password');
        if($apiRegister->authentification($hash, $user, $mail, $password)){
            return $this->json(['connexion'=>'true'], 200, ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET']);
        }else{
            return $this->json(['connexion'=>'false'], 401, ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET']);
        }
    }

    #[Route('/api/login', name:'app_api_login', methods: 'POST')]
    public function getToken(Request $request, UserRepository $userRepository,
        UserPasswordHasherInterface $hash, ApiRegister $apiRegister,
        SerializerInterface $serialize){
        //récupérer le json
        $json = $request->getContent();
        //test si on n'à pas de json
        if(!$json){
            //renvoyer un json
            return $this->json(['erreur'=>'Le Json est vide ou n\'existe pas'], 400, 
            ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET'],[]);
        }
        //transformer le json en tableau
        $data = $serialize->decode($json, 'json');
       
        //récupération du mail et du password
        $mail = $data['email'];
        $password = $data['password']; 

        //test si le paramétre mail ou password n'est pas saisi
        if(!$mail OR !$password){
            return $this->json(['Error'=>'informations absentes'], 400,['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*'] );
        }
        //test si le compte est authentifié
        if($apiRegister->authentification($hash,$userRepository,$mail,$password)){
            //récupération de la clé de chiffrement
            $secretKey = $this->getParameter('token');
            //génération du token
            $token = $apiRegister->genToken($mail, $secretKey, $userRepository);
            //Retourne le JWT
            return $this->json(['Token_JWT'=>$token], 200, ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*']);
        }
        //test si le compte n'est pas authentifié (erreur mail ou password)
        else{
            return $this->json(['Error'=>'Informations de connexion incorrectes'], 400, ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*']);
        }
    }

    #[Route('/api/testToken',  name:'app_api_testToken')]
    public function testToken(Request $request, ApiRegister $apiRegister){
        $jwt=substr($request->server->get('HTTP_AUTHORIZATION'),7);
        $secretKey=$this->getParameter('token');
        if($apiRegister->verifyToken($jwt, $secretKey)===true){
            return $this->json(['authentification'=>'OK'], 200, ['Content-Type'=>'application/json',
                'Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=> 'GET']);
        }else{
            return $this->json(['erreur'=>'Erreur authentification'], 401, ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET']);
        }
    }

    #[ROUTE('api/register', name:"app_api_register", methods: 'POST')]
    public function addUser(Request $request, SerializerInterface $serialize,
    UserRepository $userRepository, EntityManagerInterface $em, 
    Messagerie $messagerie):Response{
        // récupérer le json
        $json = $request ->getContent();
        // test si on n'à pas de json
        if(!$json){
            // renvoyer un json
            return $this->json(['erreur'=>'Le Json est vide ou n\'existe pas'], 400, 
            ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET'],[]);
        }
        // transformer le json en tableau
        $data = $serialize->decode($json, 'json');
        // nettoyer les données 
        $firstName  = Utils::cleanInput($data['firstName']);
        $lastName   = Utils::cleanInput($data['lastName']);
        $email      = Utils::cleanInput($data['email']);
        $password   = Utils::cleanInput($data['password']);
        //hasher password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        //setter les valeurs dans un nouvel objet
        $user = new User;
        $user->setPassword($hashedPassword);
        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        $user->setEmail($email);
        $user->setRoles(["ROLE_USER"]);
        $user->setActivate(false);
        // vérifier si le user existe déjà en BDD
        $recup = $userRepository->findOneBy(['email'=>$data['email']]);
        // si le mail est déjà utilisé
        if ($recup) {
            //? Renvoyer une erreur
            return $this->json(
                ['Error' => 'Un compte existe déjà avec l\'adresse suivante : '.$data['email'].'.'], 206,
                ['Content-Type'=>'application/json',
                'Access-Control-Allow-Origin' =>'*',
                'Access-Control-Allow-Method' => 'GET'],[]);
        }else{
            // persister les données
            $em->persist($user);
            // ajoute en BDD
            $em->flush();
        }
        // récupération des ID de messagerie
        $login=$this->getParameter('login');
        $mdp=$this->getParameter('mdp');

        // variable pour le mail
        $objet = 'Activation de votre compte';
        $content = '<p>Bienvenue chez PAW '.mb_convert_encoding($user->getFirstName(), 'ISO-8859-1', 'UTF-8').'!<br>Pour activer votre compte veuillez cliquer ci-dessous:</p>'.
        '<a href="https://127.0.0.1:8000/register/activate/'.$user->getId().'">Activer mon compte</a>';

        // on stocke la fonction dans une variable
        $statut = $messagerie->sendEmail($login, $mdp, $email, $objet, $content);

        return $this->json(['authentification'=>'OK'], 200, 
            ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET']);
    }

    #[ROUTE('api/animal/add', name:"app_api_animal_add", methods: 'POST')]
    public function addAnimal(Request $request, SerializerInterface $serialize,
    UserRepository $userRepository, EntityManagerInterface $em, 
    Messagerie $messagerie):Response{
        // récupérer le json
        $json = $request ->getContent();
        // test si on n'à pas de json
        if(!$json){
            // renvoyer un json
            return $this->json(['erreur'=>'Le Json est vide ou n\'existe pas'], 400, 
            ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET'],[]);
        }
        // transformer le json en tableau
        $data = $serialize->decode($json, 'json');
        // nettoyer les données 
        $specie = $data['specie'];
        $breed  = Utils::cleanInput($data['breed']);
        $name   = Utils::cleanInput($data['name']);
        $dob    = $data['dob'];
        $gender = $data['gender'];
        $color  = Utils::cleanInput($data['color']);
        $idChip = Utils::cleanInput($data['idChip']);
        $weight = Utils::cleanInput($data['weight']);
        $medicalHistory = Utils::cleanInput($data['medicalHistory']);
        $sterelisation = $data['sterelisation'];
        // setter les valeur dans un nouvel objet
        $animal = new Animal;
        $animal->setSpecie($specie);
        $animal->setBreed($breed);
        $animal->setName($name);
        $animal->setDob(new \DateTimeImmutable(($dob)));
        $animal->setColor($color);
        if($idChip==''){
            $animal->setIdChip(null);
        } else {
            $animal->setIdChip($idChip);
        };
        $animal->setWeight($weight);
        $animal->setMedicalHistory($medicalHistory);
        $animal->setSterelisation($sterelisation);
        $animal->setOwner($this->getUser());
        
    }

}
?>