<?php

namespace App\Model\Entity;

use App\Base\BaseEntity;

final class Charge_user extends BaseEntity
{
    private int $id;
    private int $user_id;
    private string $charge_username;
    private int $charge_id;
    private string $role_charge;


/**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $user_id
     * @return Charge_user
     */
    public function setId(int $id): Charge_user
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
     * @return Charge_user
     */
    public function setUser_Id(int $user_id): Charge_user
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharge_Username(): string
    {
        return $this->charge_username;
    }

    /**
     * @param string $charge_username
     * @return Charge_user
     */
    public function setCharge_Username(string $charge_username): Charge_user
    {
        $this->charge_username = $charge_username;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCharge_Id(): int
    {
        return $this->charge_id;
    }

    /**
     * @param int $charge_id
     * @return Charge_user
     */
    public function setCharge_Id(int $charge_id): Charge_user
    {
        $this->charge_id = $charge_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole_Charge(): string
    {
        return $this->role_charge;
    }

    /**
     * @param string $role_charge
     */
    public function setRole_Charge(string $role_charge): void
    {
        $this->role_charge = $role_charge;
    }

}

