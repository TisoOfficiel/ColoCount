<?php

namespace App\Model\Entity;

use App\Base\BaseEntity;

final class Charge extends BaseEntity
{
    private ?int $charge_id;
    private string $name;
    private float $charge_amount;
    private string $type;
    private string $created_at;
    private string $updated_at;
    private string $deleted_at;

    /**
     * @return int
     */
    public function getCharge_Id(): int
    {
        return $this->charge_id;
    }

    /**
     * @param int $id
     * @return Charge
     */
    public function setCharge_Id(int $charge_id): Charge
    {
        $this->charge_id = $charge_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Charge
     */
    public function setName(string $name): Charge
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getCharge_Amount(): float
    {
        return $this->charge_amount;
    }

    /**
     * @param float $amount
     * @return Charge
     */
    public function setCharge_Amount(float $charge_amount): Charge
    {
        $this->charge_amount = $charge_amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Charge
     */
    public function setType(string $type): Charge
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return Charge
     */
    public function setCreatedAt(string $created_at): Charge
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return Charge
     */
    public function setUpdatedAt(string $updated_at): Charge
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeletedAt(): string
    {
        return $this->deleted_at;
    }

    /**
     * @param string $deleted_at
     * @return Charge
     */
    public function setDeletedAt(string $deleted_at): Charge
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }
}

