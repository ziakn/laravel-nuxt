<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_replies', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_id');
            $table->string('name')->nullable();
            $table->text('comment')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('website')->nullable();
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
        Schema::dropIfExists('blog_replies');
    }
}
