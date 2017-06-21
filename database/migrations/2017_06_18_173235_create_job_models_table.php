<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('job_id')->unsigned()->nullable();
            $table->longText('payload')->nullable();
            $table->string('progress', 100)->nullable();
            $table->text('log')->nullable();
            $table->string('status');
            $table->string('result')->nullable();
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
        Schema::drop('job_models');
    }
}
