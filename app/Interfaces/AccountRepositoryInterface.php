<?php
namespace App\Interfaces;


interface AccountRepositoryInterface {

    public function getAllAccounts();
    public function getAccountById($accountId);
    public function createAccount(array $accountDetails);
    public function updateAccount($accountId,array $accountDetails);
    public function deleteAccount($accountId);

}

 