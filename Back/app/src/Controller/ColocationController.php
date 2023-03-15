<?php

namespace App\Controller;

use App\Model\Factory\PDO;
use App\Model\Manager\ColocationManager;
use App\Model\Route\Route;
use App\Service\JWTHelper;
class ColocationController
{
    #[Route('/mes_colocs', name: "mesColocs.showColocs", methods: ["GET"])]
    public function showColocs(){
        $cred = str_replace("Bearer ", "", getallheaders()['Authorization'] ?? getallheaders()['authorization'] ?? "");
        $token = JWTHelper::decodeJWT($cred);
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if($token){
                $user_id = $token->id;
                $connexionColocation = new ColocationManager(new PDO());
                $colocs = $connexionColocation->getAllMyColocs($user_id);
                if($colocs){
                    $tableauColocs = [];
        
                    foreach ($colocs as $coloc){
                        $colocsArray = [
                            "id"=> $coloc->getColocation_Id(),
                            "name"=> $coloc->getColocation_Name(),
                            "description"=>$coloc->getDescription(),
                            "created_at" => $coloc->getCreated_At(),
                        ];
                        
                        $tableauColocs[] = $colocsArray;
                    }
                    
                    echo json_encode(
                        [
                            "status" =>"sucess",
                            $tableauColocs,
                            "colocs"=>true,
                        ]);
                    exit;
                }

                    echo json_encode([
                        'status' => 'success',
                        'message' => "Vous n'avez aucune colocation",
                        'colocs' =>false,
                    ]);
                    exit;
            }
                echo json_encode([
                    'status' => 'error',
                    'message' => "Une erreur est survenue",
                ]);
                exit;
        }
    }

    #[Route('/add_coloc', name:'add_coloc', methods:['POST'])]
    public function addColocs(){

        $cred = str_replace("Bearer ", "", getallheaders()['Authorization'] ?? getallheaders()['authorization'] ?? "");
        $token = JWTHelper::decodeJWT($cred);

       
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if (!empty($_POST)) {
                if($token){
                    if (isset($_POST["titre"], $_POST["description"]) && !empty($_POST['titre']) && !empty($_POST['description'])) {

                        $titre = htmlspecialchars(strip_tags($_POST['titre']));
                        $description = htmlspecialchars(strip_tags($_POST['description']));
    
                        $connectionPdo = new ColocationManager(new PDO());
                        
                        $created_at = date('Y-m-d H:i:s');
                        $updated_at = $created_at;
                        
                        $user_id = $token->id;

                        $connectionPdo->addColoc($titre, $description,$created_at,$updated_at,$user_id);
    
                        echo json_encode([
                            "status" => "success",
                            "message" => "Ajout de la colocation réalisé",
                        ]);

                        exit;
                    }
                }else{
                    echo json_encode([
                        "status" => "error",
                        "message" => "Un problème est survenue",
                    ]);  
                    exit;
                }
            }

        }

        echo json_encode([
            'status' => 'error',
            'message' => 'L\'ajout de la colocation n\'a pas était faite'
        ]);
        exit;
    }

    #[Route('/mes_colocs/{id}',name:'mes_colocs.showOneColoc',methods:['GET'])]
    public function showOneColoc($id){

        $cred = str_replace("Bearer ", "", getallheaders()['Authorization'] ?? getallheaders()['authorization'] ?? "");
        $token = JWTHelper::decodeJWT($cred);

        // if($token){
            
            if($_SERVER['REQUEST_METHOD'] == 'GET') {
                
                $connexionColocation = new ColocationManager(new PDO());
                
                $infoColoc = $connexionColocation->getOneColocs($id);
               
                $userAll =[];
                $Transaction = [];
                $charge_id = 0;
               
                if(count($infoColoc)==0){
                    $connexionColocation = new ColocationManager(new PDO());
                    $infoColoc = $connexionColocation->getAllUser($id);
                    if(count($infoColoc) == 0){
                        echo json_encode([
                            "status"=>"error",
                            "message"=>"aucune info",
                        ]);
                        exit;
                    };

                    
                    for ($i = 0; $i < count($infoColoc); $i++) {
                        $userInfo = [
                            'user_id'=>$infoColoc[$i][1]->getUser_Id(),
                            'user_username'=>$infoColoc[$i][1]->getUsername(),
                            'user_amount'=>$infoColoc[$i][2]->getAmount(),
                            'user_role'=>$infoColoc[$i][2]->getRole(),
                        ];
                        $userAll[] = $userInfo;
                    };
                    
                    $allInfoColoc=[
                        "colocation_info"=>$colocationInfo = [
                            'colocation_id'=>$infoColoc[0][0]->getColocation_ID(),
                            'colocation_name'=>$infoColoc[0][0]->getColocation_Name(),
                            'colocation_description'=>$infoColoc[0][0]->getDescription(),
                        ],
                        "user_info"=>$userAll,
                    ];
                    echo json_encode([
                        "status"=>"sucess",
                        "message"=>"Pas de dépense ",
                        "InfoColoc"=>$allInfoColoc,
                        "depense"=>false,
                    ]);
                    exit;
                }

              
                for ($j = 0; $j < count($infoColoc); $j++) {
                    
                    if($infoColoc[$j][4] == ""){
                        continue;
                    }

                    if ($infoColoc[$j][4]->getRole_Charge() == 'paymaster' || $infoColoc[$j][4]->getRole_Charge() == 'paymaster_participant'){
                        $paymaster_id = $infoColoc[$j][4]->getUser_Id();
                        $paymaster_name = $infoColoc[$j][4]->getCharge_username();
                        $paymasterArray[]=[ "paymaster_id"=>$paymaster_id, "paymaster_name"=>$paymaster_name];
                    }
    
                    if($infoColoc[$j][4]->getRole_Charge() == 'participant'){
                        $charge_id = $infoColoc[$j][4]->getCharge_Id();
                        $participant_id = $infoColoc[$j][4]->getUser_Id();
                        $participant_name = $infoColoc[$j][4]->getCharge_username();
                            
                            // if($old_charge_id != $charge_id){
                            //     echo "match";
                            //     echo $participant_name;
                            // }
                            // if($charge_id != $old_charge_id){
                            //     echo "charge id = " . $charge_id;
                            //     echo"<br>";
                            //     echo "old charge id = " . $old_charge_id;
                            // }
    
                            // echo "charge id = " . $charge_id;
                            // echo"<br>";
                            // echo "old charge id = " . $old_charge_id;
                            // $participant = [];
                            // $participant[]=$participant_name;
    
                            $participant[] = [$charge_id,$participant_id,$participant_name];
                            // $old_charge_id = $charge_id;
                    }

                        $charge_id = $infoColoc[$j][3]->getCharge_Id();
                        $charge_name = $infoColoc[$j][3]->getName();
                        $charge_amount = $infoColoc[$j][3]->getCharge_Amount();
                        $charge_type = $infoColoc[$j][3]->getType();
                        $charge_category = $infoColoc[$j][3]->getCategory();
                        $chargeArray[]=[ "charge_id"=>$charge_id, "charge_name"=>$charge_name,"charge_amount"=>$charge_amount,"charge_type"=>$charge_type,"charge_cartegory"=>$charge_category];
                    
                }
                
                for ($i=0; $i < count($participant); $i++) { 
                    
                    $current_id =  $participant[$i][0];
                    $next_item = next($participant);
                    if ($next_item !== false) {
                        $next_id = $next_item[0];
                        if ($current_id != $next_id) {
                            if(!empty($ParticipantMultiple)){
                                $ParticipantMultiple [] = ["participant_id"=>$participant[$i][1],"participant_name"=>$participant[$i][2]];
                                $ParticipantPersCharge [] = $ParticipantMultiple;
                                $ParticipantMultiple=[];
                                continue;
                            }
                            
                            // $ParticipantPersCharge [] = [$participant[$i]];
                            $ParticipantPersCharge [] = ["participant_id"=>$participant[$i][1],"participant_name"=>$participant[$i][2]];
                        }else{
                            // $ParticipantMultiple [] = [$participant[$i]];
                            $ParticipantMultiple [] = ["participant_id"=>$participant[$i][1],"participant_name"=>$participant[$i][2]];
                        }
                    
                    }else{
                        if($current_id == $participant[$i][0]){
                            // $ParticipantMultiple [] = [$participant[$i]];
                            $ParticipantMultiple [] = ["participant_id"=>$participant[$i][1],"participant_name"=>$participant[$i][2]];
                            $ParticipantPersCharge [] = $ParticipantMultiple;
                        }else{
                            // $ParticipantPersCharge [] = [$participant[$i]];
                            $ParticipantPersCharge [] = ["participant_id"=>$participant[$i][1],"participant_name"=>$participant[$i][2]];
                        }
    
                    }
                }

                
                
                $keys = array ();
                
                // Get Position
                foreach ( $chargeArray as $key => $value ) {
                    $keys [$value ['charge_id']] = $key;
                }
                
                // Remove Duplicate
                foreach ( $chargeArray as $key => $value ) {
                    if (! in_array ( $key, $keys )) {
                        unset ( $chargeArray [$key] );
                    }
                }
                
                $i = 0;
                foreach ( $chargeArray as $key => $value ) {
                    $chargeArray[$i] = $value;
                    unset($chargeArray[$key]);
         
                    $i++;
                }
                
                
                $chargeAll = [];
                for ($i=0; $i < count($chargeArray); $i++) { 
                    $chargeAll [] = [$chargeArray[$i],$paymasterArray[$i],$ParticipantPersCharge[$i]];
                }
                
                
                // echo "<pre>";
                // var_dump($infoColoc);
                for ($i = 0; $i < count($infoColoc); $i++) {
                        
                        
                        $userInfo = [
                            'user_id'=>$infoColoc[$i][1]->getUser_Id(),
                            'user_username'=>$infoColoc[$i][1]->getUsername(),
                            'user_amount'=>$infoColoc[$i][2]->getAmount(),
                            'user_role'=>$infoColoc[$i][2]->getRole(),
                        ];
                        $userAll[] = $userInfo;
                        
                        // Charge 
                        
                        // die;
                        // CHARGE if empty 
                        // echo "<pre>";
                        // var_dump($infoColoc);
                        // echo "</pre>";
                        // die;
                        
                        // var_dump($pamasterArray);
                        // if($infoColoc[$i][3]==""){
                        //     continue;
                        // }else{
                            // echo "<pre>";
                            //     echo "i : " . $i;
                            //     echo "<br>";
                            //         var_dump($infoColoc[$i][4]);
                            //         // var_dump($paymaster_name = $infoColoc[$i][4]->getCharge_username());
                            // echo "</pre>";
    
                            // if( $infoColoc[$i][4]->getRole_Charge() == 'paymaster' || $infoColoc[$i][4]->getRole_Charge() == 'paymaster_participant'){
                            //     echo "<pre>";
                            //     var_dump($paymaster_id = $infoColoc[$i][4]->getCharge_Id());
                            //     var_dump($paymaster_name = $infoColoc[$i][4]->getCharge_username());
                            //     echo "</pre>";
                            // }else{
                            //     $paymaster_id = 0;
                            //     $paymaster_name = "test";
                            //     echo "<pre>";
                            //     var_dump($paymaster_id = $infoColoc[$i][4]->getCharge_Id());
                            //     var_dump($paymaster_name = $infoColoc[$i][4]->getCharge_username());
                            //     echo "</pre>";
                            // }
                            // for($j = $i; $j<count($infoColoc);$j++){
                            //     $charge_id = $infoColoc[$j][4]->getCharge_id();
                            //     $charge_user_id = $infoColoc[$j][4]->getUser_Id();
                            //     $charge_username = $infoColoc[$j][4]->getCharge_Username();
                            //     $charge_role = $infoColoc[$j][4]->getRole_Charge();
                            //     echo "<pre>";
                            //         var_dump($charge_id);
                            //         var_dump($charge_user_id);
                            //         var_dump($charge_username);
                            //         var_dump($charge_role);
                            //         // var_dump($infoColoc[$j][4]);
                            //     echo "</pre>";
                            // };
                            // $chargeInfo = [
                            //     'charge_id'=>$infoColoc[$i][3]->getCharge_Id(),
                            //     'charge_name'=>$infoColoc[$i][3]->getName(),
                            //     'charge_amount'=>$infoColoc[$i][3]->getCharge_Amount(),
                            //     'charge_type'=>$infoColoc[$i][3]->getType(),
                            //     'charge_category'=>$infoColoc[$i][3]->getCategory(),
                            //     'charge_paymaster_id'=>$paymaster_id,
                            //     'charge_paymaster_name'=>$paymaster_name,
                            // ];
                            // $chargeAll[] = $chargeInfo;
                        // }
    
                };

                // echo "</pre>";
                // die;
                
                // echo "<pre>";
                // var_dump($infoColoc);
                // var_dump($infoColoc[0][3]);
                // var_dump($infoColoc[2][4]);
                // var_dump($chargeAll);
                // var_dump($paymasterArray);
                // echo "</pre>";
                // die;
                // for ($i = 0; $i < count($infoColoc); $i++) {
                //     $chargeinfo = [
                //         'charge_id'=>$infoColoc[$i][1]->getUser_Id(),
                //         'user_username'=>$infoColoc[$i][1]->getUsername(),
                //         // 'user_amount'=>$infoColoc[0][2]->getAmount(),
                //         'user_role'=>$infoColoc[$i][2]->getRole(),
                //     ];
                //     $userAll[] = $userInfo;
                // };
                $keys = array ();
                
                // Get Position
                foreach ( $userAll as $key => $value ) {
                    $keys [$value ['user_id']] = $key;
                }
                

                // Remove Duplicate
                foreach ( $userAll as $key => $value ) {
                    if (! in_array ( $key, $keys )) {
                        unset ( $userAll [$key] );
                    }
                }    

                $userAllCopie = $userAll;
                
                $user_max_amount = 0;
                $user_min_amount = 0;
                // foreach($userAll as $key => $user){
                        
                //     if($user["user_amount"] < $user_min_amount){
                //         $user_min_amount = $user["user_amount"];
                //         $user_min = $user;
                //         $user_min_key = $key;
                //     }
                //     if($user["user_amount"] > $user_max_amount){
                //         $user_max_amount = $user["user_amount"];
                //         $user_max = $user;
                //         $user_max_key = $key;
                //     }
                // }

                $finish = false;
                $i = 0;

                while(!$finish){
                    // $i++;
                    // if($i > 0){                    
                        // var_dump($userArray);
                        foreach($userAll as $key => $user){
                            
                            // echo "boucle";
                            // echo "<br>";
                            // echo "key : ". $key;
                            // echo "montant" .$user['user_amount'];
                            // echo "<br>";
                            // echo "min: " .$user_min_amount;
                            // echo "max: " .$user_max_amount;
                            // echo "<br>";

                            // if($key == 1)
                            if($user["user_amount"] <= $user_min_amount){
                                // echo"tt";
                                $user_min_amount = $user["user_amount"];
                                $user_min = $user;
                                $user_min_key = $key;
                            }

                            if($user["user_amount"] >= $user_max_amount){
                                // echo"toto";
                                // echo "<br>";
                                $user_max_amount = $user["user_amount"];
                                $user_max = $user;
                                $user_max_key = $key;
                            }

                        }
                        // echo"machine";
                        // echo $user_min_amount;
                        // echo $user_max_amount;
                        // echo "est";
                        // echo "<pre>";
                        //     var_dump($userAll);
                        // echo "</pre>";
                        
                    // }

                    
                    
                    // echo $user_min_amount;
                    // echo $user_max_amount;

                    // echo $user_min_amount;
                    // echo "\n";
                    // echo $user_max_amount;
                    // echo "<br>";
                    // echo "<br>";
                
                    
                    if((round($user_max_amount) == 0 && round($user_min_amount) == 0)){
                        $finish = true;
                        break;
                    };
                    // die;

                    // die;
                    if(abs($user_min_amount) == $user_max_amount){
                        // echo "egale";
                        // echo $user_min_amount;
                        // echo $user_max_amount;

                        $userAll[$user_min_key]['user_amount'] = 0;
                        $userAll[$user_max_key]['user_amount'] = 0;
                        // echo"test";
                        $Transaction [] = [$user_min['user_username'],round($user_max_amount,2),$user_max['user_username']];
                        
                    }elseif(abs($user_min_amount) > $user_max_amount){
                        $total = $user_min_amount + $user_max_amount;
                        
                        
                        $userAll[$user_min_key]['user_amount'] = $total;
                        
                        
                        $userAll[$user_max_key]['user_amount'] = 0;
                        $Transaction [] = [ $user_min['user_username'],round($user_max_amount,2),$user_max['user_username']];
                        
                    }elseif(abs($user_min_amount) < $user_max_amount){
                        
                        $total = $user_max_amount + $user_min_amount;
                        // $user_min['user_amount'] = 0 ;
                        // $user_max['user_amount'] = $total;
                        // echo $userAll[$user_min_key['user_amount']];
                        
                        
                        
                        $userAll[$user_min_key]["user_amount"] = 0;
                        $userAll[$user_max_key]['user_amount']= $total;

                        $Transaction []=[$user_min['user_username'],round(abs($user_min_amount), 2),$user_max['user_username']];
                    }

                   
                    $user_max_amount = 0;
                    $user_min_amount = 0;
                    
                    
                }
                
                $userAll = $userAllCopie;

                // $userAll
                // echo"<pre>";
                //     var_dump($Transaction);
                //     // $userArray = $user
                //         // var_dump($userAll);
                //         // var_dump($user_min);
                //         // var_dump($user_max);
                // echo "</pre>";
                    // if($userAll){
                    // }

                // die;
                
                // die;
                // for($i) ($infoColoc as $coloc){
                //     $colocsArray = [
                //         "id"=> $coloc->getId(),
                //         "name"=> $coloc->getName(),
                //         "description"=>$coloc->getDescription(),
                //         "created_at" => $coloc->getCreated_At(),
                //     ];
                    
                //     $tableauColocs[] = $colocsArray;
                // }
                // echo "<pre>";

                    $allInfoColoc=[
                            "colocation_info"=>$colocationInfo = [
                                'colocation_id'=>$infoColoc[0][0]->getColocation_ID(),
                                'colocation_name'=>$infoColoc[0][0]->getColocation_Name(),
                                'colocation_description'=>$infoColoc[0][0]->getDescription(),
                            ],
                            "user_info"=>$userAll,
                            "charge_info"=>$chargeAll,
                            "equilibre_info"=>$Transaction,
                            // $charge = [
                            //     'charge_id'=>$infoColoc[0][3]->getCharge_Id(),
                            //     'charge_name'=>$infoColoc[0][3]->getName(),
                            //     'charge_amount'=>$infoColoc[0][3]->getCharge_amount(),
                            //     'charge_type'=>$infoColoc[0][3]->getType(),
                            //     'charge_category'=>$infoColoc[0][3]->getCategory(),
                            //     'charge_paymaster'=>$infoColoc[0][4]->getRole_Charge(),
                            // ]                        
                    ];
                    echo json_encode([
                        "status"=>"sucess",
                        "InfoColoc"=>$allInfoColoc,
                    ]);
                    exit;
                    // var_dump($allInfoColoc);
                    // var_dump($infoColoc);
                // echo "</pre>";
    
            }

            
        // }else{
        //     json_encode([
        //         "status"=>"error",
        //         "message"=>"une erreur est survenue"
        //     ]);
        // }
    }

}