<?php

namespace App\Base;

use App\Model\Traits\Hydrator;

abstract class BaseEntity
{
    use Hydrator;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }


}