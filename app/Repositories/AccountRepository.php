<?php

namespace App\Repositories;

use App\Interfaces\AccountRepositoryInterface;
use App\Models\Account;

class AccountRepository implements AccountRepositoryInterface {

    public function getAllAccounts()  {
        return Account::all();
    }

    public function getAccountById($accountId)  {
        return Account::find($accountId);
    }

    public function createAccount($accountDetails)  {
        return Account::create($accountDetails);
    }

    public function updateAccount($accountId,$accountDetails) {
        return Account::whereId($accountId)->update($accountDetails);
    }

    public function deleteAccount($accountId)  {
        return Account::destroy($accountId);
    }

}