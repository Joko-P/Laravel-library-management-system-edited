<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->foreignId('book_id')->constrained()->restrictOnDelete();
            $table->timestamp('issue_date')->nullable();
            $table->timestamp('return_date')->nullable();
            $table->string('issue_status')->nullable();
            $table->integer('fines')->default(0);
            $table->timestamp('return_day')->nullable();
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
        Schema::dropIfExists('book_issues');
    }
}
