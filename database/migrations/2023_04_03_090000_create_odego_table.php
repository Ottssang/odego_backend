<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student')) {
            Schema::create('student', function (Blueprint $table) {
                $table->string('student_id', 7)->primary();
                $table->string('class_id', 10)->default('-1')->comment('초기값: -1');
                $table->string('name', 10)->nullable();
                $table->string('contact', 16)->nullable();
            });
        }
        if (!Schema::hasTable('professor')) {
            Schema::create('professor', function (Blueprint $table) {
                $table->integer('professor_id')->primary();
                $table->string('professor_name', 5)->nullable();
                $table->string('class_id', 10);
                $table->foreign('class_id')->references('class_id')->on('class');
            });
        }
        if (!Schema::hasTable('class')) {
            Schema::create('class', function (Blueprint $table) {
                $table->string('class_id', 10)->primary();
                $table->integer('persons')->nullable();
            });
        }
        if (!Schema::hasTable('reason')) {
            Schema::create('reason', function (Blueprint $table) {
                $table->integer('reason_id')->primary();
                $table->string('reason_title', 20)->nullable();
                $table->string('reason_content', 200)->nullable();
                $table->date('reason_date')->nullable();
                $table->string('student_id', 7);
                $table->boolean('authorized')->nullable()->default(null);
                $table->string('class_id', 10);
                $table->foreign('student_id')->references('student_id')->on('student');
            });
        }
        if (!Schema::hasTable('selfpaced')) {
            Schema::create('selfpaced', function (Blueprint $table) {
                $table->integer('selfpaced_id')->primary();
                $table->string('class_id', 10);
                $table->date('selfpaced_date')->nullable();
                $table->foreign('class_id')->references('class_id')->on('class');
            });
        }
        if (!Schema::hasTable('student_account')) {
            Schema::create('student_account', function (Blueprint $table) {
                $table->string('student_id', 20)->primary()->comment('googleId');
                $table->string('student_pw', 20)->nullable();
                $table->string('student_id3', 7);
                $table->foreign('student_id3')->references('student_id')->on('student');
            });
        }
        if (!Schema::hasTable('professor_account')) {
            Schema::create('professor_account', function (Blueprint $table) {
                $table->string('pro_id', 20)->primary();
                $table->string('pro_pw', 20)->nullable();
                $table->integer('professor_id2');
                $table->string('pro_mail', 30)->nullable();
                $table->foreign('professor_id2')->references('professor_id')->on('professor');
            });
        }
        if (!Schema::hasTable('notice')) {
            Schema::create('notice', function (Blueprint $table) {
                $table->integer('notice_id')->primary();
                $table->string('notice_title', 20)->nullable();
                $table->string('notice_content', 200)->nullable();
                $table->date('notice_date')->nullable();
                $table->integer('professor_id');
                $table->string('class_id', 10);
                $table->foreign('professor_id')->references('professor_id')->on('professor');
                $table->foreign('class_id')->references('class_id')->on('class');
            });
        }
        if (!Schema::hasTable('classroom')) {
            Schema::create('classroom', function (Blueprint $table) {
                $table->integer('building_id')->unsigned();
                $table->integer('classroom_id')->unsigned();
                $table->string('class_id', 10);
                $table->primary(['building_id', 'classroom_id']);
                $table->foreign('class_id')->references('class_id')->on('class')->onDelete('cascade');
            });
        }
        if (!Schema::hasTable('sign_up')) {
            Schema::create('sign_up', function (Blueprint $table) {
                $table->string('student_id', 7);
                $table->string('name', 10)->nullable();
                $table->string('contact', 16)->nullable();
                $table->string('class_id', 10)->nullable();
                $table->foreign('class_id')->references('class_id')->on('class')->onDelete('cascade');
                $table->primary(['student_id', 'class_id']);
            });
        }
        if (!Schema::hasTable('notice_read')) {
            Schema::create('notice_read', function (Blueprint $table) {
                $table->integer('notice_id')->unsigned();
                $table->string('student_id', 7);
                $table->foreign('notice_id')->references('notice_id')->on('notice')->onDelete('cascade');
                $table->foreign('student_id')->references('student_id')->on('student')->onDelete('cascade');
                $table->primary(['notice_id', 'student_id']);
            });
        }
        if (!Schema::hasTable('attendance')) {
            Schema::create('attendance', function (Blueprint $table) {
                $table->string('student_id', 7);
                $table->integer('selfpaced_id')->unsigned();
                $table->foreign('student_id')->references('student_id')->on('student')->onDelete('cascade');
                $table->foreign('selfpaced_id')->references('selfpaced_id')->on('selfpaced')->onDelete('cascade');
                $table->primary(['student_id', 'selfpaced_id']);
            });
        }
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
        Schema::dropIfExists('professor');
        Schema::dropIfExists('class');
        Schema::dropIfExists('reason');
        Schema::dropIfExists('selfpaced');
        Schema::dropIfExists('student_account');
        Schema::dropIfExists('professor_account');
        Schema::dropIfExists('notice');
        Schema::dropIfExists('classroom');
        Schema::dropIfExists('sign_up');
        Schema::dropIfExists('notice_read');
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('notice_read');
        Schema::dropIfExists('sign_up');
        Schema::dropIfExists('classroom');
    }
};