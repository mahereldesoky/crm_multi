<?php

namespace App\Repositories;

use App\Models\department;
use App\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface {

    public function getAllDepartments()  {
        return department::all();
    }

    public function getDepartmentById($departmentId)  {
        return department::find($departmentId);
    }

    public function createDepartment($departmentDetails)  {
        return department::create($departmentDetails);
    }

    public function updateDepartment($departmentId , array $departmentDetails)  {
        return department::whereId($departmentId)->update($departmentDetails);
    }

    public function deleteDepartment($departmentId)  {
        return department::destroy($departmentId);
    }
    
}