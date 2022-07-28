<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use HasFactory;

    protected $fillable = [
        "break",
        "from",
        "till",
        "month",
        "salary_per_hour",
        "user_id",
        "times_updated"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
