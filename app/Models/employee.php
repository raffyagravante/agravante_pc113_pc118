<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'role',
        'department'
    ];

    public $timestamps = false; 
    
}


    Employee::create([
        'name' => 'RAFFY',
        'role' => 'Developer',
        'department' => 'Engineering',
    ]);
    