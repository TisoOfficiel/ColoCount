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
                
                if(isset($_POST["paymaster"],$_POST['title'], $_POST["participant"],$_POST['amount']) && !empty($_POST['title'] &&  $_POST["paymaster"] && !empty($_POST["participant"]) && !empty($_POST['amount']))) {                    
                    
                    $name = htmlspecialchars(strip_tags($_POST['title']));
                    $paymaster_array = json_decode($_POST['paymaster'], true);
                    
                    foreach ($paymaster_array[0] as $key => $value) {
                        $info_paymaster[] = htmlspecialchars(strip_tags($value));
                    }
                   
                    $participant_info = json_decode($_POST["participant"],true); 
                 
                    foreach($participant_info as $participant){
                        if($info_paymaster[1] != $participant['id']){
                            $info_participants [] = [htmlspecialchars(strip_tags($participant['username'])),htmlspecialchars(strip_tags($participant['id']))];
                        }
                    }
                   
                    $amount = round($_POST['amount'],2);  

                    $amountPerPerson = -round(($amount/(count($info_participants)+1)),2);

                    $type="depense";
                    $category="facture";

                    $connection = new ChargeManager(new PDO());
                    $info_paymaster[] = $amount - abs($amountPerPerson);
                    
                    if($connection->addCharge($id,$info_paymaster,$info_participants,$amount,$name,$type,$category)){
                        $connection->updateAccount($id,$info_paymaster,$info_participants,$amountPerPerson);
                    }
                
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'charge bien cree',
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
                    
                    $paymaster_id = htmlspecialchars(strip_tags($_POST['paymaster']));
                    $beneficiary_id = htmlspecialchars(strip_tags($_POST['beneficiary']));
                    $amount = htmlspecialchars(strip_tags($_POST['amount']));                
                    

                   
                    $connection = new ChargeManager(new PDO());
                    $connection->updateAccountRemboursement($id,$paymaster_id,$amount);
                    
                    $connection = new UserManager(new PDO());
                    $amountBeneficiary = $connection->getColocUserAmountByIds($id,$beneficiary_id);

                    $verificationAmount = $amountBeneficiary - $amount;

                  
                    if(round($verificationAmount) == 0 && $verificationAmount !=0){
                        $amount = -$amountBeneficiary;
                    }

                    else{
                        $amount = -$amount;
                    }

                    $connection = new ChargeManager(new PDO());
                    $connection->updateAccountRemboursement($id,$beneficiary_id,$amount);

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Remboursment bien effectuer',
                    ]);
                    exit;
                }
            }
        }
    }
}
