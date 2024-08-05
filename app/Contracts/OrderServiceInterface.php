<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderServiceInterface
{
    public function addOrder($data = []): Order;
}
