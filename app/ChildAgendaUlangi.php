<?php

namespace App;

use App\Agenda;
use App\AgendaUlangi;
use Illuminate\Database\Eloquent\Model;

class ChildAgendaUlangi extends Model
{
    protected $table = 'child_agenda_ulangi';
    protected $fillable = [
        'agenda_id',
        'agenda_ulangi_id'
    ];
    public $timestamps = false;

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    public function agendaUlangi()
    {
        return $this->belongsTo(AgendaUlangi::class, 'agenda_ulangi_id');
    }
}
