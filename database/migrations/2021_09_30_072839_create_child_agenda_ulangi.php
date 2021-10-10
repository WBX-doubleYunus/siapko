<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildAgendaUlangi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_agenda_ulangi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agenda_id')->unsigned();
            $table->bigInteger('agenda_ulangi_id')->unsigned();

            $table->foreign('agenda_id')
                    ->references('id')
                    ->on('agenda')
                    ->onDelete('cascade');

            $table->foreign('agenda_ulangi_id')
                    ->references('id')
                    ->on('agenda_ulangi')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_agenda_ulangi');
    }
}
