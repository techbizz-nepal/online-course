<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('usi', 10)->nullable();
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('surname');
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('flat_unit')->nullable();
            $table->string('street')->nullable();
            $table->string('locality')->nullable();
            $table->string('state')->nullable();
            $table->string('post_code')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('relation')->nullable();
            $table->string('emergency_home_phone')->nullable();
            $table->string('emergency_work_phone')->nullable();
            $table->string('emergency_mobile')->nullable();
            $table->string('key')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('pdf')->nullable();
            $table->integer('display_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->json('extra')->nullable();
            $table->json('survey')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
