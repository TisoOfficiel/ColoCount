<?php

namespace App\Model\Entity;

use App\Base\BaseEntity;

class Colocation_user extends BaseEntity
{
    private int $id;
    private int $colocation_id;
    private int $user_id;
    private float $amount;
    private string $role;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $colocation_id
     * @return Colocation_user
     */
    public function setId(int $id): Colocation_user
    {
        $this->id = $id;
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
     * @return Colocation_user
     */
    public function setColocation_Id(int $colocation_id): Colocation_user
    {
        $this->colocation_id = $colocation_id;
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
     * @return Colocation_user
     */
    public function setUser_Id(int $user_id): Colocation_user
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Colocation_user
     */
    public function setAmount(float $amount): Colocation_user
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return Colocation_user
     */
    public function setRole(string $role): Colocation_user
    {
        $this->role = $role;
        return $this;
    }


}