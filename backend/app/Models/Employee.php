<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;  

    
    protected $table = 'employees';  

    
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

    
    public $timestamps = true;

    
}