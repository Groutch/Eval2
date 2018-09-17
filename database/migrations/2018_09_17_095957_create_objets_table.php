<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objets', function (Blueprint $table) {
            $table->increments('idObjet');
            $table->string('nomObjet');
            $table->string('image');
            $table->longText('description');
            $table->unsignedInteger('idVendeur');
            $table->unsignedInteger('idCategorie');
            $table->timestamps();
            $table->foreign('idVendeur')->references('id')->on('users');
            $table->foreign('idCategorie')->references('idCat')->on('categorie');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objets');
    }
}
