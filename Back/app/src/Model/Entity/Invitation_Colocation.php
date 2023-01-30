<?php

namespace App\Model\Entity;

use App\Base\BaseEntity;

final class Invitation_colocation extends BaseEntity
{
    private int $id;
    private int $user_id;
    private int $colocation_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Invitation_colocation
     */
    public function setId(int $id): Invitation_colocation
    {
        $this->id = $id;
        return $this;
    }

     /**
     * @return int
     */
    public function getUser_Id(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return Charge_colocation
     */
    public function setUser_Id(int $user_id): Invitation_colocation
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getColocation_Id(): int
    {
        return $this->colocation_id;
    }

    /**
     * @param int $colocation_id
     * @return Charge_colocation
     */
    public function setColocation_Id(int $colocation_id): Invitation_colocation
    {
        $this->colocation_id = $colocation_id;
        return $this;
    }

}

