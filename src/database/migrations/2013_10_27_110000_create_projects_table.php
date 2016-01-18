<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->date('date');
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('project_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('locale')->index();
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('summary');
            $table->text('body');
            $table->timestamps();
            $table->unique(['project_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_translations');
        Schema::drop('projects');
    }
}
