<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->uuid('exam_code')->unique();

            $table->foreignId('batch_id')
                    ->constrained()
                    ->onDelete('cascade');

            $table->foreignId('exam_category_id')
                    ->constrained()
                    ->onDelete('cascade');

            $table->string('name');

            $table->integer('total_question');
            $table->integer('exam_duration')->comment('in minute');
            $table->boolean('has_negative_mark')->default(false);
            $table->float('negative_mark')->default(0.25);

            $table->timestamp('exam_started_at')->nullable();
            $table->timestamp('exam_ended_at')->nullable();

            $table->json('subjects');

            $table->enum('status', ['pending', 'published', 'ongoing', 'closed'])->default('pending');
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
        Schema::dropIfExists('exams');
    }
}
