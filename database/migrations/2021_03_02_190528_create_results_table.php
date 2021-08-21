<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->uuid('result_code')->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('exam_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->integer('position')->nullable();
            $table->string('exam_category')->nullable();
            $table->string('exam_name')->nullable();
            $table->integer('total_question')->nullable();
            $table->integer('total_answered')->nullable();
            $table->integer('correct_answer')->nullable();    
            $table->integer('wrong_answer')->nullable(); 
            $table->decimal('negative_mark')->nullable(); 
            $table->decimal('total_mark')->nullable();
            $table->string('exam_duration')->nullable();  
            $table->json('exam_meta_data')->nullable();
            $table->boolean('is_published')->default(false);
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
        Schema::dropIfExists('results');
    }
}
