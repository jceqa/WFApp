<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTextosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('textos', function (Blueprint $table) {
            $table->text('palabras');
            $table->text('frecuencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('textos', function (Blueprint $table) {
            $table->dropColumn('palabras');
            $table->dropColumn('frecuencias');
        });
    }
}
