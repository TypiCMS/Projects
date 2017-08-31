<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return null
     */
    public function up()
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('image_id')->unsigned()->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->json('status');
            $table->json('title');
            $table->json('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return null
     */
    public function down()
    {
        Schema::drop('project_categories');
    }
}
