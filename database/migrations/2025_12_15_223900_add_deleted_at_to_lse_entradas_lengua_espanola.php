<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lse_entradas_lengua_espanola', function (Blueprint $table) {
            $table->softDeletes(); // crea la columna deleted_at
        });
    }

    public function down()
    {
        Schema::table('lse_entradas_lengua_espanola', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
