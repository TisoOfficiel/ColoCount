<?php

namespace App\Model\Manager;

use App\Base\BaseManager;
use App\Model\Entity\Charge;
use App\Model\Entity\Charge_user;
use App\Model\Entity\Colocation;
use App\Model\Entity\Colocation_user;
use App\Model\Entity\User;
use JetBrains\PhpStorm\ArrayShape;

class ColocationManager extends BaseManager
{

    public function getAllMyColocs($user_id):?array
    {
        $sql = "SELECT c.* FROM colocation c INNER JOIN colocation_user cu ON cu.colocation_id = c.colocation_id INNER JOIN users u ON cu.user_id = u.user_id WHERE u.user_id = :id";
        

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $user_id,\PDO::PARAM_STR);

        $query->execute();

        $colocs = [];

        while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
            $colocs[] = new Colocation($data);
        };

        return $colocs;
        
    }


    public function addColoc($name,$description,$created_at,$updated_at,$user_id):void
    {
        $sql = "INSERT INTO `colocation` (`colocation_name`,`description`,`created_at`,`updated_at`) VALUES (:name, :description,:created_at,:updated_at)";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':name', $name, \PDO::PARAM_STR);
        $query->bindValue(':description', $description, \PDO::PARAM_STR);
        $query->bindValue(':created_at', $created_at, \PDO::PARAM_STR);
        $query->bindValue(':updated_at', $updated_at, \PDO::PARAM_STR);

        $query->execute();

        $id = $this->pdo->lastInsertId();

        $sql = "INSERT INTO `colocation_user`(`colocation_id`,`user_id`,`amount`,`role`) VALUES (:colocation_id, :user_id,:amount,:role)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':colocation_id', $id, \PDO::PARAM_STR);
        $query->bindValue(':user_id', $user_id, \PDO::PARAM_STR);
        $query->bindValue(':amount', 0, \PDO::PARAM_STR);
        $query->bindValue(':role', 'admin', \PDO::PARAM_STR);

        $query->execute();

    }

    public function getAllUser($id): ?Array
    {
        $sql = "SELECT c.*,u.*,cu.* FROM colocation as c
        INNER JOIN colocation_user as cu on c.colocation_id = cu.colocation_id 
        INNER JOIN users as u on u.user_id = cu.user_id 
        WHERE c.colocation_id =:id";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id,\PDO::PARAM_STR);
        $query->execute();
        $infoColoc = [];
        while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
            $infoColoc[] = [new Colocation($data),new User($data),new Colocation_user($data)];
        }
        return $infoColoc;
    }

    public function getOneColocs($id):?Array
    {
        // $sql = "SELECT DISTINCT cu.*, c.description,c.colocation_name,ch.*,colocation_user.* FROM charge_user AS cu 
        // INNER JOIN colocation as c on cu.colocation_id = c.colocation_id 
        // INNER JOIN charge as ch on ch.charge_id = cu.charge_id
        // INNER JOIN colocation_user on colocation_user.user_id = cu.user_id
        // WHERE cu.colocation_id=:id";

        

        // $query->execute();

        // if(!$query->fetch(\PDO::FETCH_ASSOC)){
        //     return 0;
        // }elseif($query->fetch(\PDO::FETCH_ASSOC)){
        //     while ($data =  $query->fetch(\PDO::FETCH_ASSOC)){
        //         var_dump($data);
        //     }
        // }
        // die;
        $sql = "SELECT c.colocation_id,c.colocation_name,c.description,u.username,u.user_id ,u.username ,ch.charge_id ,ch.name,ch.charge_amount,ch.type,ch.category ,chu.charge_username,chu.role_charge,cu.amount,cu.role FROM colocation AS c LEFT JOIN colocation_user AS cu ON c.colocation_id = cu.colocation_id LEFT JOIN users AS u ON cu.user_id = u.user_id LEFT JOIN charge_user AS chu ON u.user_id = chu.user_id LEFT JOIN charge AS ch ON ch.charge_id = chu.charge_id where cu.colocation_id=1 and c.colocation_id =:id";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id,\PDO::PARAM_STR);

        $query->execute();
       
        // $tete = $query->fetch(\PDO::FETCH_ASSOC);
        // if(empty($tete)){
        //     echo"test";
        // }else{
        //     echo "machine";
        // }

        $infoColoc = [];
        $id_coloc = 0;
        $id_charge = 0;
        
        
        while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
            // DE BASE
            if($id_coloc != $data['colocation_id'] && $id_charge!=['charge_id']){
                // echo"tout différent";
                // echo "<br>";
                // echo "ID COLOC INCREMENT: ". $id_coloc . " || ID COLOC BDD :" .$data['colocation_id'];
                // echo "<br>";
                // echo "ID CHARGE INCREMENT: ". $id_coloc . " || ID CHARGE BDD :" .$data['charge_id'];
                $infoColoc[] = [new Colocation($data),new User($data),new Colocation_user($data),new Charge($data),new Charge_user($data)];
               
            }elseif($id_coloc != $data['colocation_id'] && $id_charge == $data['charge_id']){
                // echo"ID CHARGE similaire a l'ancienne valeur";
                // echo " ". ;
                // echo " ".$id_charge;
               
                $infoColoc[] = [new Colocation($data),new User($data),new Colocation_user($data),"",new Charge_user($data)];
                
            }elseif($id_coloc == $data['colocation_id'] && $id_charge != $data['charge_id'] && $data['charge_id']!=NULL){
                
                // echo"ID COLOC ÉGALE MAIS PAS CHARGE";
                // echo "<br>";
                // echo "ID COLOC INCREMENT: ". $id_coloc . " || ID COLOC BDD :" .$data['colocation_id'];
                // echo "<br>";
                // echo "ID CHARGE INCREMENT: ". $id_coloc . " || ID CHARGE BDD :" .$data['charge_id'];


                $infoColoc[] = ["",new User($data),new Colocation_user($data),new Charge($data),new Charge_user($data)];
  
            }elseif($id_coloc == $data['colocation_id'] && $id_charge == $data['charge_id']&& $data['charge_id']!=NULL){

              
                // echo"TOUT EGALE";
                // echo "<br>";
                // echo "ID COLOC INCREMENT: ". $id_coloc . " || ID COLOC BDD :" .$data['colocation_id'];
                // echo "<br>";
                // echo "ID CHARGE INCREMENT: ". $id_coloc . " || ID CHARGE BDD :" .$data['charge_id'];
                $infoColoc[] = ["",new User($data),new Colocation_user($data),"",new Charge_user($data)];
                
            }
            $id_coloc = $data['colocation_id'];
            $id_charge = $data['charge_id'];
            
        };
        return $infoColoc;
    }



}