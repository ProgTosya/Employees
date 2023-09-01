<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','sur_name','father_name','rank','pay','work_to','image','rank_level','employee_id','boss_id','subordinates'
    ];
}
