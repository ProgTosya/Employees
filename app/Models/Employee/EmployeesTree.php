<?php

namespace App\Models\Employee;

class EmployeesTree
{
    static function makeTree(){
        $result = [];
        $main_employee = [];
        $main_employee[0] = [new getEmployee()];

        $amount_employees = rand(50000, 75000);

        $one_persent = $amount_employees / 100;

        $counter_employees = [];
        $counter_employees[1] = round($one_persent);
        $counter_employees[2] = round($one_persent * 5);
        $counter_employees[3] = round($one_persent * 24);
        $counter_employees[4] = round($one_persent * 70) - 1;




        foreach ($counter_employees as $lvl => $count) {
            $main_employee[$lvl] = [];
            for ($i=0; $i < $count; $i++) {
                $employee = new getEmployee($lvl);
                $boss_key = rand(0, count($main_employee[$lvl-1]) - 1);
                $boss_id = $main_employee[$lvl-1][$boss_key]->getId();
                $employee->setBossId($boss_id);
                $main_employee[$lvl-1][$boss_key]->setSubId($employee->getId());
                $main_employee[$lvl][] = $employee;
            }
        }

        foreach($main_employee as $lvl) {
            foreach($lvl as $employee) {
                $result[] = $employee;
            }
        }

        shuffle($result);

        return $result;
    }
}
