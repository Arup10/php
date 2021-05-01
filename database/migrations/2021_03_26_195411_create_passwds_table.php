<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwds', function (Blueprint $table) {
            $table->string('ip');
            $table->string('port');
            $table->string('user');
            $table->string('password');
            $table->smallInteger('enabled')->default(1);
            $table->smallInteger('sold')->default(0);
            $table->string('fullname')->default("proxybazaar");
            $table->string('comment')->nullable();
            $table->timestamp('created_timestamp');
            $table->timestamp('sold_timestamp')->nullable();
            $table->timestamp('expiry_timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passwds');
    }
}
