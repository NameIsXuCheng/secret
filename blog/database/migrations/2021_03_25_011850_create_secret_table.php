<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secret', function (Blueprint $table) {
            $table->id();
            $table->string('app_key')->default('');
            $table->string('app_secret')->default('');
            $table->text('interfaces_id');
            $table->tinyInteger('is_definition');
            $table->tinyInteger('fee_type');
            $table->float('fee');
            $table->integer('fee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secret');
    }
}
