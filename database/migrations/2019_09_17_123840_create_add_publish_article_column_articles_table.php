<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddPublishArticleColumnArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       Schema::table('articles', function (Blueprint $table) {
            $table->string('publish_article')->after('right_color')->default('N');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('articles', function (Blueprint $table) {
            $table->string('publish_article')->after('right_color');
        });
    }
}
