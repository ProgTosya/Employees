<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesTreeController extends Controller
{
    public function index(Request $request)
    {
        $boss = Employees::all()->where('rank_level', 0)->first();
        return $boss;
        return response()->json([
            'success' => true,
            'message' => 'Main boss',
            $boss,
        ], 200);
    }

    public function getEmployee($id) {
        if ($id !== "undefined"){
            $employee = DB::table('employees')
                ->where('boss_id','=', $id)
                ->where('employee_id', '!=', $id)
                ->get();
            return $employee;
        }
    }

    public function getDragEmployee($boss, $dragEmployee) {
        $bossEmployee = DB::table('employees')
            ->where('employee_id', '=', $boss)
            ->first();

        $employee = DB::table('employees')
            ->where('employee_id', '=', $dragEmployee)
            ->first();
        $subs = DB::table('employees')
            ->where('employee_id', $boss)
            ->first(['subordinates']);
        $subs = json_decode($subs->subordinates);
        $subs[] = $employee->employee_id;
        DB::table('employees')
            ->where('employee_id', $boss)
            ->update(['subordinates' => json_encode($subs)]);

        DB::table('employees')
            ->where('employee_id', '=', $dragEmployee)
            ->update(['boss_id' => $bossEmployee->employee_id]);
        return redirect()->route('tree.index');
    }

    public function getBossSubs($boss, $employee) {

        $subs_old = DB::table('employees')
            ->where('employee_id', $boss)
            ->first(['subordinates']);
        $subs_old = json_decode($subs_old->subordinates);
        $filtered = array_search($employee,$subs_old);
        unset($subs_old[$filtered]);
        DB::table('employees')
            ->where('employee_id', $boss)
            ->update(['subordinates' => json_encode(array_values($subs_old))]);
        DB::table('employees')
            ->where('employee_id','=', $employee)
            ->update(['boss_id' => 0]);
        return DB::table('employees')
            ->where('boss_id', $boss)
            ->get();
    }
}
