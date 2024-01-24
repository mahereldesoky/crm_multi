<?php
namespace App\Interfaces;


interface CustomerRepositryInterface {

    public function getAllCustomers();
    public function getCustomerById($customerId);
    public function createCustomer(array $customerDetails);
    public function updateCustomer($customerId,array $customerDetails);
    public function deleteCustomer($customerId);

}

 