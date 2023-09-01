<?php

namespace Database\Seeders;

use App\Models\Employee\EmployeesTree;
use App\Models\Employees;
use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = EmployeesTree::makeTree();
        foreach($data as $employee) {
            Employees::create([
                'name' => $employee->getName(),
                'sur_name' => $employee->getSurName(),
                'father_name' => $employee->getFatcherName(),
                'rank' => $employee->getRank(),
                'pay' => $employee->getPay(),
                'work_to' => $employee->getWorkToDate(),
                'rank_level' => $employee->getRankLvl(),
                'employee_id' => $employee->getId(),
                'boss_id' => $employee->getBossId(),
                'subordinates' => json_encode($employee->getSubordinates()),
                'image' => '/asset/avatar/avatar'.rand(1,10).'.jpg',
            ]);
        }
    }
}
