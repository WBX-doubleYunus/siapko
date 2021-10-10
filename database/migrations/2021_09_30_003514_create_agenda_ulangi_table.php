<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaUlangiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_ulangi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agenda_id')->unsigned();

            $table->foreign('agenda_id')
                    ->references('id')
                    ->on('agenda')
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
        Schema::dropIfExists('agenda_ulangi');
    }
}
