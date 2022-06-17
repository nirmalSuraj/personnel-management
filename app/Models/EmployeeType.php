<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    use HasFactory;


    // protected $table = "employee_types";

    protected $fillable = ["type"];

    public function user_details()
    {
        return $this->hasMany(UserDetails::class);
    }
}
