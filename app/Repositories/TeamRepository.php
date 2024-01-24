<?php
namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\department;
use App\Models\Team;

class TeamRepository implements TeamRepositoryInterface {
    public function getAllTeam() {
        return Team::all();
    }

    public function getTeamById($teamId)  {
        return Team::find($teamId);
    }

    public function createTeam(array $teamtDetails)  {
        return Team::create($teamtDetails);
    }

    public function updateTeam($teamId , array $teamDetails)  {
        return Team::whereId($teamId)->update($teamDetails);
    }

    public function deleteTeam($teamId)  {
        return Team::destroy($teamId);
    }
}