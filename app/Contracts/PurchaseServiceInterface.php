<?php

namespace App\Contracts;

interface PurchaseServiceInterface
{
    public function proceed(): string;
}
