<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddCategoriesToPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            /* Creiamo una foreign key in una tabella esistente, NON può avere NULL, la posizioniamo dopo SLUG */
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            
            /* E' una foreign key che fa riferimento all'id della categoria' */
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            /* Togliamo prima la relazione, poi la colonna */
            $table->dropForeign('posts_category_id_foreign');
            
            $table->dropColumn('category_id');
        });
    }
}
