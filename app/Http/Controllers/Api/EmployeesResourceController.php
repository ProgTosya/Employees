<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $collection = Employees::query();

        $allowedFilterFields = (new Employees())->getFillable();
        $allowedSortFields = ['id', ...$allowedFilterFields];
        $allowedSortDirections = ['asc', 'desc'];
        $sortBy = $request->query('sortby', 'id');
        $sortDir = strtolower($request->query('sortdir', 'asc'));
        if(!in_array($sortBy, $allowedSortFields)) $sortBy = $allowedSortFields[0];
        if(!in_array($sortDir, $allowedSortDirections)) $sortBy = $allowedSortDirections[0];
        $collection->orderBy($sortBy, $sortDir);

        foreach ($allowedSortFields as $key){
            if ($paramFilter = $request->query('_'.$key)){
                $paramFilter = preg_replace("#([%_?+])#", "\\$1", $paramFilter);
                $collection->where($key, 'LIKE', '%'.$paramFilter.'%');
            }
        }

        $limit = $request->query('limit');
        $limit = min($limit, 20);
        $collection->limit($limit);

        $offset = intval($request->query('offset', 0));
        $offset = max($offset, 0);
        $collection->offset($offset);

        return response()->json($collection->get());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee_id = DB::table('employees')
                ->max('employee_id') + 1;
        $rank_lvl = DB::table('employees')
                ->where('employee_id', $request->boss_id)
                ->get('rank_level')
                ->value('rank_level') + 1;
        $this->getValidate($request);
        $file_name = time().'.'.$request->image->extension();
        $request->image->move(public_path('/storage/avatar/'), 'avatar'.$file_name);
        $file_path = '/storage/avatar/avatar'.$file_name;
        $employee = Employees::create([
            'name' => $request->name,
            'sur_name' => $request->sur_name,
            'father_name' => $request->father_name,
            'rank' => $request->rank,
            'pay' => $request->pay,
            'work_to' => $request->work_to,
            'image' => $file_path,
            'rank_level' => $rank_lvl,
            'boss_id' => $request->boss_id,
            'employee_id' => $employee_id,
            'subordinates'  => json_encode([]),
        ]);
        $subs = DB::table('employees')
            ->where('employee_id', $request->boss_id)
            ->first(['subordinates']);
        $subs = json_decode($subs->subordinates);
        $subs[] = $employee_id;
        DB::table('employees')
            ->where('employee_id', $request->boss_id)
            ->update(['subordinates' => json_encode($subs)]);
        return response()->json([
            'success' => true,
            'message' => 'Post created',
            'employee' => $employee,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employees::find($id);
        view('components.editEmployee');
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employees::find($id);
        if ($employee){
            $rank_lvl = DB::table('employees')
                ->where('employee_id', $request->boss_id)
                ->get('rank_level')
                ->value('rank_level') + 1;

        $subs = DB::table('employees')
            ->where('employee_id', $request->boss_id)
            ->first(['subordinates']);
        $subs = json_decode($subs->subordinates);
        $subs[] = $employee->employee_id;
        DB::table('employees')
            ->where('employee_id', $request->boss_id)
            ->update(['subordinates' => json_encode($subs)]);

        $subs_old = DB::table('employees')
            ->where('employee_id', $request->old_boss)
            ->first(['subordinates']);
        $subs_old = json_decode($subs_old->subordinates);
        $filtered = array_search($employee->employee_id,$subs_old);
        unset($subs_old[$filtered]);
        DB::table('employees')
            ->where('employee_id', $request->old_boss)
            ->update(['subordinates' => json_encode(array_values($subs_old))]);

        $employee->name = $request->input('name');
        $employee->sur_name = $request->input('sur_name');
        $employee->father_name = $request->input('father_name');
        $employee->rank = $request->input('rank');
        $employee->pay = $request->input('pay');
        $employee->work_to = $request->input('work_to');
        $employee->boss_id = $request->input('boss_id');
        $employee->rank_level = $rank_lvl;
        if($request->file('image')) {
            $file_name = time().'.'.$request->image->extension();
            $request->image->move(public_path('/storage/avatar/'), 'avatar'.$file_name);
            $file_path = '/storage/avatar/avatar'.$file_name;
            $employee->image = $file_path;
        }
        $employee->save();
        return response()->json([
            'success' => true,
            'message' => 'Post updated',
            'data' => $employee
        ], 202);} else {
            return response()->json([
                'success' => false,
                'message' => 'not found',], 204);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employees::find($id);
        if ($employee){
        $employee->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post deleted'
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'not found',], 204);
    }
    }

    private function getValidate(Request $request, $id = null): void
    {
        $data = [
            'name' => 'required|string|max:255',
            'sur_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
            'pay' => 'required|integer',
            'work_to' => 'required|date',
            'boss_id' => 'required|integer',
        ];
        $this->validate($request, $data);
    }
    public function mainBoss($boss){
        $old_boss = DB::table('employees')
            ->where('rank_level', '=', 0)
            ->first();
        $new_boss = DB::table('employees')
            ->where('employee_id', '=', $boss)
            ->first();
        $first_boss = json_decode($old_boss->subordinates);
        $twelve_boss = json_decode($new_boss->subordinates);

        foreach ($first_boss as $key => $value){
            if ($value != $new_boss->employee_id){
                DB::table('employees')
                    ->where('employee_id', '=', $value)
                    ->update(['boss_id' => $new_boss->employee_id]);
            } else {
                unset($first_boss[$key]);
            }
        }

        foreach ($twelve_boss as $value){
            DB::table('employees')
                ->where('employee_id', '=', $value)
                ->update(['boss_id' => $old_boss->employee_id]);
        }

        DB::table('employees')
            ->where('employee_id', '=', $old_boss->employee_id)
            ->update(['boss_id' => $new_boss->boss_id, 'rank_level' => $new_boss->rank_level, 'subordinates' => json_encode(array_values($twelve_boss))]);

        DB::table('employees')
            ->where('employee_id', '=', $new_boss->employee_id)
            ->update(['boss_id' => 0,'rank_level' => 0, 'subordinates' => json_encode(array_values($first_boss))]);

            return response()->json([
                'success' => true,
                'message' => 'Boss update',
                'old boss' => $old_boss,
                'new boss' => $new_boss,
            ], 200);
    }
}
