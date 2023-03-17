<?php

namespace App\Controller;

use App\Base\CookieHelper;
use App\Model\Factory\PDO;
use App\Model\Route\Route;
use App\Service\JWTHelper;
use App\Model\Manager\UserManager;
use App\Model\Manager\ColocationManager;

class UserController
{   
    #[Route('/login', name: "login", methods: ["POST"])]
    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST)){
                if(isset($_POST["username"], $_POST["password"]) && !empty($_POST["username"] && !empty($_POST["password"]))) {
                    $username = htmlspecialchars(strip_tags($_POST['username']));
                    $password = htmlspecialchars(strip_tags($_POST['password']));
                    
                    $connectioPDO = new UserManager(new PDO());
                    $user = $connectioPDO->login($username,$password);
                    
                    if($user){
                        $jwt = JWTHelper::buildJWT($user);

                        CookieHelper::setCookie($jwt);
                        
                        echo json_encode([
                            'status' => 'success',
                            "id" => $user->getUser_Id(),
                            'username' => $user->getUsername(),
                            'token' => $jwt
                        ]);
                        exit;
                    }
                }
            }
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Pas de connexion',
        ]);

        exit;
    }

    #[Route('/register',name:'register.register', methods: ["POST"])]
    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if (!empty($_POST)) {

                if (isset($_POST["username"], $_POST["email"], $_POST['password'],$_POST['confirm_password']) && !empty($_POST['confirm_password']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                    
                    // Hash password
                    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                    $confirm_password = $_POST['confirm_password'];
                    
                    //Comparaison password and confirm password
                    if(!password_verify($confirm_password,$password)){
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Pas de d\'inscription'
                        ]);
                        exit;
                    }

                    $username = htmlspecialchars(strip_tags($_POST['username']));
                    $email = htmlspecialchars(strip_tags($_POST['email']));

                    $connectionPdo = new UserManager(new PDO());

                    $user = $connectionPdo->register($username, $email, $password);

                    if($user){
                        $jwt = JWTHelper::buildJWT($user);

                        CookieHelper::setCookie($jwt);

                        echo json_encode([
                            'status' => 'success',
                            "id" => $user->getUser_Id(),
                            'username' => $user->getUsername(),
                            'token' => $jwt
                        ]);
                        exit;
                    }

                }
            }

        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Pas de d\'inscription'
        ]);
        exit;
    }

    #[ROUTE('/mes_colocs/{id}/remove_user/{user_id_remove}',name:'remove_user.remove',methods:["GET"])]
    public function remove($id,$user_id_remove){
        $cred = str_replace("Bearer ", "", getallheaders()['Authorization'] ?? getallheaders()['authorization'] ?? "");
        $token = JWTHelper::decodeJWT($cred);
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if($token){
                    $user_id = $token->id;
                    $connectioPDO = new UserManager(new PDO());
                    $response = $connectioPDO->removeUser($id,$user_id,$user_id_remove);
                    
                    if($response == 0){
                        echo json_encode([
                            'status' => 'sucess',
                            'message' => 'L\'utilisateur expulsé',
                        ]);
                
                        exit;
                    }elseif($response == 1){
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Vous ne pouvez pas expulsé un utilisateur qui n\'à pas tout remboursé',
                        ]);
                
                        exit;
                    }elseif($response == 2){
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Vous n\'êtes pas admin dans cette colocation',
                        ]);
                
                        exit;
                    }else{
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Une erreur est survenue',
                        ]);
                
                        exit;
                    }

            }else{
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Vous êtes pas connecté',
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => 'Une erreur est survenue',
            ]);
            exit;
        }
    }

    #[ROUTE('/mes_colocs/edit/mon_compte',name:"mes_colocs/mon_compte.editUser",methods:["POST"])]
    public function editUser(){
            $cred = str_replace("Bearer ", "", getallheaders()['Authorization'] ?? getallheaders()['authorization'] ?? "");
            $token = JWTHelper::decodeJWT($cred);
            if($token){
                $id = $token->id;
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
                    if (isset($_POST["username"], $_POST["old_password"], $_POST['password'],$_POST['confirm_password'])) {
                        
                        if(!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['old_password']) && !empty($_POST['username'])){
                       
                            // TOUT MODIF
                            $username = htmlspecialchars(strip_tags($_POST['username']));
                            $password = htmlspecialchars(strip_tags($_POST['password']));
                            $confirm_password = htmlspecialchars(strip_tags($_POST['confirm_password']));
                            $old_password = htmlspecialchars(strip_tags($_POST['old_password']));
                           
                            if($confirm_password != $password){
                                echo json_encode([
                                    'status' => 'error',
                                    'message' => 'Pas de modification'
                                ]);
                                exit;
                            }
   
                            $connectionPdo = new UserManager(new PDO());
                            $user = $connectionPdo->getUserById($id);
                
                            if($user){
                                if(!password_verify($old_password,$user->getPassword())){
                                    echo json_encode([
                                        'status' => 'error',
                                        'message' => 'Pas le bon mot de passe',
                                    ]);
                                    exit;
                                }

                                
                                $password = password_hash($password,PASSWORD_DEFAULT);

                                $connectionPdo = new UserManager(new PDO());    
                                $user = $connectionPdo->updateUserAll($id,$username, $password);
                                
                                $jwt = JWTHelper::buildJWT($user);
    
                                CookieHelper::setCookie($jwt);
        
                                echo json_encode([
                                    'status' => 'success',
                                    'message' => 'Modication effectué',
                                    "id" => $user->getUser_Id(),
                                    'username' => $user->getUsername(),
                                    'token' => $jwt
                                ]);
                                exit;
                            }
                                echo json_encode([
                                    'status' => 'error',
                                    'message' => 'Une erreur est survenue',
                                ]);
                                exit;

                        }elseif(!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['old_password']) && empty($_POST['username'])){
                            $password = htmlspecialchars(strip_tags($_POST['password']));
                            $confirm_password = htmlspecialchars(strip_tags($_POST['confirm_password']));
                            $old_password = htmlspecialchars(strip_tags($_POST['old_password']));
                           
                            if($confirm_password != $password){
                                echo json_encode([
                                    'status' => 'error',
                                    'message' => 'Pas de modification'
                                ]);
                                exit;
                            }
   
                            $connectionPdo = new UserManager(new PDO());
                            $user = $connectionPdo->getUserById($id);
                
                            if($user){
                                if(!password_verify($old_password,$user->getPassword())){
                                    echo json_encode([
                                        'status' => 'error',
                                        'message' => 'Pas le bon mot de passe',
                                    ]);
                                    exit;
                                }

                                
                                $password = password_hash($password,PASSWORD_DEFAULT);

                                $connectionPdo = new UserManager(new PDO());    
                                $user = $connectionPdo->updateUserPassword($id, $password);
                                
                                $jwt = JWTHelper::buildJWT($user);
    
                                CookieHelper::setCookie($jwt);
        
                                echo json_encode([
                                    'status' => 'success',
                                    'message' => 'Modication effectué',
                                    "id" => $user->getUser_Id(),
                                    'username' => $user->getUsername(),
                                    'token' => $jwt
                                ]);
                                exit;
                            }
                                echo json_encode([
                                    'status' => 'error',
                                    'message' => 'Une erreur est survenue',
                                ]);
                                exit;
                            
                        }elseif(empty($_POST['password']) && empty($_POST['confirm_password']) && empty($_POST['old_password']) && !empty($_POST['username'])){
                            $username = htmlspecialchars(strip_tags($_POST['username']));
                            $connectionPdo = new UserManager(new PDO());
                            $user = $connectionPdo->getUserById($id);

                            if($user){
                        
                                $connectionPdo = new UserManager(new PDO());    
                                $user = $connectionPdo->updateUserUsername($id,$username);
                                
                                $jwt = JWTHelper::buildJWT($user);
    
                                CookieHelper::setCookie($jwt);
        
                                echo json_encode([
                                    'status' => 'success',
                                    'message' => 'Modication effectué',
                                    "id" => $user->getUser_Id(),
                                    'username' => $user->getUsername(),
                                    'token' => $jwt
                                ]);
                                exit;
                            }
                                echo json_encode([
                                    'status' => 'error',
                                    'message' => 'Une erreur est survenue',
                                ]);
                                exit;

                        }echo json_encode([
                            'status' => 'error',
                            'message' => 'Une erreur est survenue',
                        ]);
                        exit;
                    }
                }    
            echo json_encode([
                'status' => 'error',
                'message' => 'Pas de d\'inscription'
            ]);
            exit;
    }

    #[ROUTE('/mes_colocs/{id}/invite_user',name:'mes_colocs.inviteUser',methods:["POST"])]
    public function inviteUser($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST)) {

                if (isset($_POST["email"]) && !empty($_POST['email'])) {
                    $user_email = htmlspecialchars(strip_tags($_POST['email']));
                    $colocation_id = htmlspecialchars(strip_tags($id));
        
                    $connectionPdo = new UserManager(new PDO());
                    
                    $user = $connectionPdo->getUserByEmail($user_email);
                    if($user){
                        $connectionPdo->addInvitation($colocation_id,$user->getUser_Id());
                    }
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Invitation bien envoyé',
                    ]);
                    exit;
                }
            
            }
            echo json_encode([
                'status' => 'error',
                'message' => 'Pas d\'insvitation envoyé',
            ]);
            exit;
        }

    }
    #[ROUTE('/mes_colocs/invitation_statuts/{id}',name:'mes_colocs.inviteUser',methods:["POST"])]
    public function invitationStatus($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST)) {

                if (isset($_POST["invitation"]) && !empty($_POST['invitation']) && ($_POST['invitation'] == "accepte" || $_POST['invitation'] == "refuse")) {
                    $invitation = htmlspecialchars(strip_tags($_POST['invitation']));

                    $connectionPdo = new ColocationManager(new PDO());
                    
                    $resultat = $connectionPdo->getInvitationById($id);
                  
                    if($resultat[0] == false){
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Pas d\'insvitation reçut',
                        ]);
                        exit;
                    }
                    $colocation_id = $resultat[0]["colocation_id"];
                    $user_id = $resultat[0]["user_id"];
                    $connectionPdo->updateInvitation($id);

                    if($invitation == "accepte"){

                        $connectionPdo->joinColoc($colocation_id,$user_id);
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Invitation accepté',
                        ]);
                        exit;
                    }else{
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Invitation refusé',
                        ]);
    
                        exit;
                    }
                    
                }
            }
            echo json_encode([
                'status' => 'error',
                'message' => 'Pas d\'insvitation reçut',
            ]);
            exit;
        }

    }
}
