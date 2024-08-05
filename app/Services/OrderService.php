<?php

namespace App\Services;

use App\Models\Order;
use App\Contracts\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    public function addOrder($data = []): Order
    {
        $order = new Order();

        return $order;
    }
}
