<?php

namespace App\Controller;

use App\Base\CookieHelper;
use App\Model\Factory\PDO;
use App\Model\Route\Route;
use App\Service\JWTHelper;
use App\Model\Manager\UserManager;
use App\Model\Manager\ChargeManager;

class ChargeController
{
    #[Route('/mes_colocs/{id}/add_depense', name: "mesColocs.addDepense", methods: ["POST"])]
    public function addDepense($id){
        // TOKEN Verif si connecter
        // Verif si la personne connecter est bien dans la bonne url => colocation
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST)){
                if(isset($_POST["paymaster"], $_POST["participant"],$_POST['amount']) && !empty($_POST["paymaster"] && !empty($_POST["participant"]) && !empty($_POST['amount']))) {                    
                    
                    $paymaster_array = json_decode($_POST['paymaster'], true);

                    foreach ($paymaster_array as $key => $value) {
                        $info_paymaster[] = htmlspecialchars(strip_tags($value));
                    }
                    

                    foreach($_POST['participant'] as $participant){
                        $participant_info = json_decode($participant,true);
                        $info_participants [] = [htmlspecialchars(strip_tags($participant_info[0])),htmlspecialchars(strip_tags($participant_info[1]))];
                    }

                    
                    $amount = $_POST['amount'];

                    $amountPerPerson = -($amount/(count($info_participants)+1));

                    $name="Loyer";
                    $type="depense";
                    $category="Loyer";

                    $connection = new ChargeManager(new PDO());
                    $info_paymaster[] = $amount - abs($amountPerPerson);
                    
                    if($connection->addCharge($id,$info_paymaster,$info_participants,$amount,$name,$type,$category)){
                        $connection->updateAcount($id,$info_paymaster,$info_participants,$amountPerPerson);
                    }
                    echo json_encode([
                        'status' => 'sucess',
                        'message' => 'charge bien crée',
            
                    ]);
                    exit;
                }
            }
        }

        echo json_encode([
            'status' => 'error',
            
            'message' => 'Pas de charge crée'
        ]);

        exit;
    }

    #[Route('/mes_colocs/{id}/add_remboursement',name:"mesColocas.addRemboursement",methods:['POST'])]
    public function addRemboursement($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST)){
                if(isset($_POST["paymaster"],$_POST["beneficiary"],$_POST['amount']) && !empty($_POST["paymaster"] && !empty($_POST["beneficiary"]) && !empty($_POST['amount']))) {
                    
                    $paymaster_array = json_decode($_POST['paymaster'], true);
                    $beneficiary_array = json_decode($_POST['beneficiary'],true);

                    foreach ($paymaster_array as $key => $value) {
                        $info_paymaster[] = htmlspecialchars(strip_tags($value));
                    }                    
                    foreach ($beneficiary_array as $key => $value) {
                        $info_beneficiary[] = htmlspecialchars(strip_tags($value));
                    }                    

                    $amount = htmlspecialchars(strip_tags($_POST['amount']));        
                    
                    $connection = new ChargeManager(new PDO());
                    $connection->updateAcountRemboursement($id,$info_paymaster,$info_beneficiary,$amount);
                    
                    
                }
            }
        }
    }
}
