<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->string('uniq_id');
            $table->integer('id_user');
            $table->integer('id_category');
            $table->integer('id_assign');
            $table->string('priority');
            $table->string('subject');
            $table->string('description');
            $table->string('attachment');
            $table->string('status');
            $table->timestamps();

            // $table->foreign('id_user')->references('id')->on('user');
            // $table->foreign('id_category')->references('id')->on('category');
            // $table->foreign('id_assign')->references('id')->on('user');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
