<?php

namespace App;

use App\Agenda;
use App\ChildAgendaUlangi;
use Illuminate\Database\Eloquent\Model;

class AgendaUlangi extends Model
{
    protected $table = 'agenda_ulangi';
    protected $fillable = [
        'agenda_id'
    ];
    public $timestamps = false;

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    public function childAgendaUlangi()
    {
        return $this->hasMany(ChildAgendaUlangi::class);
    } 
}
