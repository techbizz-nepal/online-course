<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('title', 300);
            $table->float('price');
            $table->string('image', 1500);
            $table->string('description', 1500)->nullable();
            $table->string('course_code', 20)->nullable();
            $table->string('department', 155)->nullable();
            $table->string('study_area', 155)->nullable();
            $table->string('campus', 155)->nullable();
            $table->string('course_length', 25)->nullable();
            $table->text('prerequisites')->nullable();
            $table->integer('display_order')->default(0);
            $table->text('fee_details')->nullable();
            $table->text('course_duration')->nullable();
            $table->text('additional_details')->nullable();
            $table->string('detail_image', 1500);
            $table->string('slug', 500)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
