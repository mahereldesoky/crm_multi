<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositryInterface {

    public function getAllCustomers()  {
        return Customer::all();
    }

    public function getCustomerById($customerId)  {
        return Customer::find($customerId);
    }

    public function createCustomer($customerDetails)  {
        return Customer::create($customerDetails);
    }

    public function updateCustomer($customerId,$customerDetails) {
        return Customer::whereId($customerId)->update($customerDetails);
    }

    public function deleteCustomer($customerId)  {
        return Customer::destroy($customerId);
    }

}