<?php

namespace App\Model\Entity;

use App\Base\BaseEntity;

final class Charge_colocation extends BaseEntity
{
    private int $charge_id;
    private int $colocation_id;

    /**
     * @return int
     */
    public function getCharge_Id(): int
    {
        return $this->charge_id;
    }

    /**
     * @param int $charge_id
     * @return Charge_colocation
     */
    public function setCharge_Id(int $charge_id): Charge_colocation
    {
        $this->charge_id = $charge_id;
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
    public function setColocation_Id(int $colocation_id): Charge_colocation
    {
        $this->colocation_id = $colocation_id;
        return $this;
    }

}

