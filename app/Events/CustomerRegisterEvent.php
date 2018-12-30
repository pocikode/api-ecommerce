<?php

namespace App\Events;

use App\Models\Customer;

class CustomerRegisterEvent extends Event
{
    public $customer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}
