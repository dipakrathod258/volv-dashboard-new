<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddTrendingCategoryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trending_categories', function (Blueprint $table) {
            $table->string('trending_category_image')->after('trending_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trending_categories', function (Blueprint $table) {
            $table->dropColumn('trending_category_image')->after('trending_title');
        });

    }
}
