<?php
namespace App\Interfaces;

interface TeamRepositoryInterface {
    public function getAllTeam();
    public function getTeamById($teamId);
    public function deleteTeam($teamId);
    public function createTeam(array $teamDetails);
    public function updateTeam($teamtId, array $teamDetails);
}