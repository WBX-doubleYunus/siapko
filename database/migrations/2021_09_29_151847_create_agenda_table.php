<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('admin_id')->unsigned();
            $table->string('judul');
            $table->date('tanggal_mulai');
            $table->enum('status', ['belum', 'selesai']);
            $table->enum('ulangi', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu', 'satu_hari', 'setiap_hari']);
            $table->timestamps();

            $table->foreign('admin_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('agenda');
    }
}
