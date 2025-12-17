<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sub_title')->nullable();
            $table->string('order_by')->nullable();
            $table->string('slug')->unique();
            $table->longtext('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('term_type')->default('page');
            $table->string('category_id')->nullable();
            $table->string('meta_title')->nullable();
            $table->longtext('meta_description')->nullable();
            $table->longtext('meta_keyword')->nullable();
            $table->string('meta_author')->nullable();
            $table->text('template')->nullable();
            $table->enum('is_status',['publish','draft'])->nullable()->default('publish');
            $table->string('author')->nullable();
            $table->timestamps();
            
            //Foreign
            $table->foreign('term_type')->references('slug')->on('terms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
