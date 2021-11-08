<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendly_links', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id')->unsigned();
            $table->string('name');
            $table->string('logo')->nullable()->comment('友情链接logo');
            $table->string('linkurl');
            $table->string('remarks')->nullable()->comment('备注');
            $table->tinyInteger('is_enabled')->unsigned()->nullable()->default(1)->comment('是否启用：0否，1是');
            $table->tinyInteger('sort')->nullable()->default(0)->comment('显示顺序');
            $table->timestamps();

            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friendly_links');
    }
}
