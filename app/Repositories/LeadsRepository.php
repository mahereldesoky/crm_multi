<?php

namespace App\Repositories;

use App\Interfaces\LeadsRepositoryInterface;
use App\Models\Leads;

class LeadsRepository implements LeadsRepositoryInterface {
    public function getAllLeads(){
       return Leads::all();
    }
    public function createLeads(array $leadsDetails){
        return Leads::create($leadsDetails);
    }
    public function updateLead($leadId,array $leadsDetails){
        return Leads::whereId($leadId)->update($leadsDetails);
    }
    public function getLeadById($leadId){
        return Leads::findOrFail($leadId);
    }
    public function deleteLead($leadId){
        return Leads::destroy($leadId);
    }
}