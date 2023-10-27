<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddArticleStatusArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('articles', function (Blueprint $table) {
            $table->string('article_status')->after('publish_article')->default('In Review');
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
            $table->string('article_status')->after('publish_article');
        });
    }
}
