<?php

namespace App\Model\Manager;

use App\Base\BaseManager;
use App\Model\Entity\Charge;
use App\Model\Entity\Charge_user;

class ChargeManager extends BaseManager
{

    public function addCharge($id,$paymaster,$participants,$amount,$name,$type){
    

        $sql = "INSERT INTO `charge` (`name`,`charge_amount`,`type`) VALUES (:name,:charge_amount,:type)";

        $query = $this->pdo->prepare($sql);

        $query->bindValue(':name',$name, \PDO::PARAM_STR);
        $query->bindValue(':charge_amount',$amount, \PDO::PARAM_STR);
        $query->bindValue(':type',$type, \PDO::PARAM_STR);

        $query->execute();

        $charge_id = $this->pdo->lastInsertId();
        
        $sql = "INSERT INTO `charge_user`(`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES (?,?,?,?,?)";
        $query = $this->pdo->prepare($sql);
        foreach ($participants as $key => $participant) {
            
            $query->bindValue(1, $participant[1]);
            $query->bindValue(2, $participant[0]);
            $query->bindValue(3, $charge_id);
            $query->bindValue(4, $id);
            $query->bindValue(5,'participant');
            $query->execute();
        }
        
        $sql = "INSERT INTO `charge_user`(`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES (:user_id,:charge_username,:charge_id,:colocation_id,:role_charge)";
        
        $query = $this->pdo->prepare($sql);

        $query->bindValue(':user_id',$paymaster[1], \PDO::PARAM_STR);
        $query->bindValue(':charge_username',$paymaster[0], \PDO::PARAM_STR);
        $query->bindValue(':charge_id',$charge_id, \PDO::PARAM_STR);
        $query->bindValue(':colocation_id',$id, \PDO::PARAM_STR);
        $query->bindValue(':role_charge',"paymaster", \PDO::PARAM_STR);

        $query->execute();
        
        return true;
    }

    public function updateAccount($id,$paymaster,$participants,$amountperPerson){
       
        $sql = "UPDATE colocation_user SET `amount` = (SELECT `amount` FROM colocation_user WHERE user_id = :user_id AND colocation_id = :colocation_id) + :amount
        WHERE colocation_id = :colocation_id and user_id = :user_id ;";
        // $sql = "UPDATE colocation_user set `amount` = :amount where `user_id` = :user_id and `colocation_id` = :colocation_id";
        
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':amount', $paymaster[2],\PDO::PARAM_STR);
        $query->bindValue(':user_id', $paymaster[1],\PDO::PARAM_STR);
        $query->bindValue(':colocation_id', $id,\PDO::PARAM_STR);

        $query->execute();
    
        $query = $this->pdo->prepare($sql);
        
        foreach ($participants as $key => $participant) {
            $query->bindValue(":amount", $amountperPerson);
            $query->bindValue(":user_id", $participant[1]);
            $query->bindValue(":colocation_id", $id);
            $query->execute();
        }

    }
    public function updateAccountRemboursement($id,$userId,$amount){
       

        // $sql = "UPDATE colocation_user SET `amount` = :amount WHERE colocation_id = :colocation_id and user_id = :user_id ;";
        $sql = "UPDATE colocation_user SET `amount` = (SELECT `amount` FROM colocation_user WHERE user_id = :user_id AND colocation_id = :colocation_id) + :amount
        WHERE colocation_id = :colocation_id and user_id = :user_id ;";
        
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':amount', $amount,\PDO::PARAM_STR);
        $query->bindValue(':user_id', $userId,\PDO::PARAM_STR);
        $query->bindValue(':colocation_id', $id,\PDO::PARAM_STR);

        $query->execute();
        
        // $query = $this->pdo->prepare($sql);
        
        
        // $query->bindValue(":amount", -$amount);
        // $query->bindValue(":user_id", $beneficiary[1]);
        // $query->bindValue(":colocation_id", $id);
        
        // $query->execute();

        //return amount of beneficiary
        // $sql = "SELECT `amount` FROM colocation_user WHERE user_id = :user_id AND colocation_id = :colocation_id";
        // $query = $this->pdo->prepare($sql);
        // $query->bindValue(":user_id", $beneficiary[1]);
        // $query->bindValue(":colocation_id", $id);
        // $query->execute();
        // $amount = $query->fetch();
        // return $amount;

    }

    public function getChargeInfo($id,$charge_id){
        $sql = "SELECT DISTINCT c.name, c.charge_amount, cu.charge_username, cu.role_charge
        FROM charge as c
        INNER JOIN charge_user as cu
        ON c.charge_id = cu.charge_id AND cu.charge_id =:charge_id and cu.colocation_id = :id";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':charge_id',$charge_id,\PDO::PARAM_STR);
        $query->bindValue(':id', $id,\PDO::PARAM_STR);

        $query->execute();
        $infoCharge = [];
        while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
            $infoCharge[] = [new Charge($data),new Charge_user($data)];
        }


         return $infoCharge;

    }
}