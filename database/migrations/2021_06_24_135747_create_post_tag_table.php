<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            /* 
                ESSENDO UNA TABELLA PONTE NON HA QUESTE COLONNE
                $table->id();
                $table->timestamps();
            */

            /* Creiamo le due colonne che ci interessano */
            $table->unsignedBigInteger('post_id');
            /* Stabiliamo la relazione, la colonna post_id fa riferimento alla colonna dei post "posts" */
            $table->foreign('post_id')->references('id')->on('posts');
            
            /* Stessa cosa per il TAG */
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Le mettiamo anche qui per il rollback */
        /* Prima di cancellare le colonne dobbiamo modificare la tabella con Schema,
        cancelliamo le relazioni quindi, lo facciamo in caso ci da problemi */
        Schema::table('post_tag', function (Blueprint $table) {
            $table->dropForeign('post_tag_post_id_foreign');
            $table->dropForeign('post_tag_tag_id_foreign');
        });
        
        Schema::dropIfExists('post_tag');
    }
}
