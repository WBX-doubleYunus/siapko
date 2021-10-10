<?php

namespace App;

use App\User;
use App\AgendaUlangi;
use App\RiwayatAgenda;
use App\ChildAgendaUlangi;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $fillable = [
        'admin_id',
        'judul',
        'tanggal_mulai',
        'status',
        'ulangi'
    ];
    protected $dates = [
        'tanggal_mulai',
        'created_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function agendaUlangi()
    {
        return $this->hasOne(AgendaUlangi::class);
    }

    public function childAgendaUlangi()
    {
        return $this->hasOne(ChildAgendaUlangi::class);
    }
}
