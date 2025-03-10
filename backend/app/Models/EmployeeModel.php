<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;  // This trait helps with the automatic creation of factory classes for seeding and testing.

    // Specify the table name (if it's different from the default 'employees')
    protected $table = 'employees';  // Laravel uses 'employees' as default, but specify it if different.

    // Define the attributes that are mass assignable
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'address',
        'email',
        'position',
        'contact_number',
    ];

    // Define any relationships here (e.g., if an employee belongs to a department, etc.)
    // public function department()
    // {
    //     return $this->belongsTo(Department::class);
    // }

    // Optionally, if you need to customize timestamps (Laravel uses `created_at` and `updated_at` by default)
    public $timestamps = true;

    //
}