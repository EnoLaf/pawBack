<?php
namespace App\Service;
use App\Repository\UserRepository;
use App\Service\Utils;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiRegister{
    public function authentification(UserPasswordHasherInterface $hash,
    UserRepository $repo, $mail, $password){
        $password=Utils::cleanInputStatic($password);
        $mail=Utils::cleanInputStatic($mail);
        $user = $repo->findOneBy(['email'=>$mail]);

        if($user){
            if($hash->isPasswordValid($user, $password)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //fonction pour générer le token JWT
    public function genToken($mail,$secretKey,$repo){
        //construction du JWT
        require_once('../vendor/autoload.php');
        //Variables pour le token
        $issuedAt   = new \DateTimeImmutable();
        $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();
        $serverName = "your.domain.name";
        $username   = $repo->findOneBy(['email'=>$mail])->getfirstName();
        //Contenu du token
        $data = [
            'iat'  => $issuedAt->getTimestamp(),         // Timestamp génération du token
            'iss'  => $serverName,                       // Serveur
            'nbf'  => $issuedAt->getTimestamp(),         // Timestamp empécher date antérieure
            'exp'  => $expire,                           // Timestamp expiration du token
            'userName' => $username,                     // Nom utilisateur
        ];
        //retourne le JWT token encode
        $token = JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );
        return $token;
    }
    
    //fonction pour véfifier si le token JWT est valide
    public function verifyToken($jwt, $secretKey){
        require_once('../vendor/autoload.php');
        try {
        //Décodage du token
        $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
        return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
?>