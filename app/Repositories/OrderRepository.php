<?php

namespace App\Repositories;

class OrderRepository {

    private array $orderModels;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

}