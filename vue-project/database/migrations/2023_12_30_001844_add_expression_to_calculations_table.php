<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpressionToCalculationsTable extends Migration
{
    public function up()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->string('expression')->nullable(); // Adjust the data type if necessary
        });
    }

    public function down()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn('expression');
        });
    }
}

