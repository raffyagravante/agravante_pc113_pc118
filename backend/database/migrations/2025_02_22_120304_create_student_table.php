<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->integer('age');
            $table->string('gender', 50);
            $table->string('address', 255);
            $table->string('email', 255);
            $table->string('course', 255);
            $table->string('contact_number', 20);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
