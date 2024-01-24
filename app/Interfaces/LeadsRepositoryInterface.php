<?php

namespace App\Interfaces;

interface LeadsRepositoryInterface {
    public function getAllLeads();
    public function createLeads(array $leadsDetails);
    public function updateLead($leadId,array $leadsDetails);
    public function getLeadById($leadId);
    public function deleteLead($leadId);
}