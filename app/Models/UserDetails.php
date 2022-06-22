<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'national_insurance',
        'kids',
        'week_hours',
        'relationship',
        'salary_per_hour',
        'employee_type_id',
        'user_id',
        'perform_hours'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }
}
