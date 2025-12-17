<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_field', function (Blueprint $table) {
            $table->id();
            $table->string('term_type')->nullable();
            $table->string('term_taxonomy_type')->nullable();
            $table->enum('field_type', ['text', 'textarea', 'richtext', 'select', 'single_image', 'multiple_image', 'checkbox', 'radio', 'colorpicker']); 
            $table->string('field_title');
            $table->string('field_name')->unique();
            $table->string('field_value')->nullable();
            $table->enum('field_for', ['Post', 'Category'])->nullable();
            $table->timestamps();

            //Foreign
            $table->foreign('term_type')->references('slug')->on('terms')->onDelete('cascade');
            $table->foreign('term_taxonomy_type')->references('slug')->on('term_taxonomy')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_field');
    }
}
