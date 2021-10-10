<?php

namespace App\Http\Controllers;

use App\Agenda;
use DataTables;
use Carbon\Carbon;
use App\AgendaUlangi;
use App\ChildAgendaUlangi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:pemilik,admin')->only('json', 'index', 'show', 'indexRiwayat',);
        $this->middleware('role:admin')->only('create', 'store', 'edit', 'update', 'destroy');
        $this->middleware('role:pemilik')->only('updateStatus');
    }

    public function json(Request $request)
    {
        $data = Agenda::with('agendaUlangi')
                        ->where(function($query) use($request) {
                            if($request->has('is_riwayat')) {
                                if($request->tanggal_filter) {
                                    $query->whereDate('created_at', '=', $request->tanggal_filter);
                                } else {
                                    $query->whereDate('created_at', '<', date('Y-m-d'));
                                }
                            } else {
                                $query->whereDate('created_at', '=', date('Y-m-d'));
                            }
                        });

        return DataTables::of($data)
                            ->editColumn('status', function($data) {
                                if($data->status == 'belum') {
                                    return 'Belum Selesai';
                                }

                                return 'Sudah Selesai';
                            })
                            ->editColumn('created_at', function($data) {
                                return $data->created_at->format('d/m/Y');
                            })
                            ->editColumn('ulangi', function($data) {
                                return '<span class="badge badge-primary">'.ucwords(str_replace('_', ' ', $data->ulangi)).'</span>';
                            })
                            ->addColumn('aksi', function($data) {
                                $btn = '';

                                if(auth()->user()->role == 'admin') {
                                    $btn = '
                                        <a href="'.route('agenda.edit', $data->id).'" class="btn btn-sm btn-warning">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'.$data->id.'">Hapus</button>
                                    ';
                                }

                                return '
                                    <a href="'.route('agenda.show', $data->id).'" class="btn btn-sm btn-info">Detail</a>
                                '.$btn;
                            })
                            ->rawColumns(['aksi', 'ulangi'])
                            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agenda_ulangi = AgendaUlangi::with('agenda')->get();
        $now_day = date('N');
        $day_arr = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu'
        ];

        foreach($agenda_ulangi as $data) {
            $agenda_id = $data->agenda_id;
            $agenda_ulangi_id = $data->id;

            if($data->agenda->ulangi == $day_arr[$now_day] || $data->agenda->ulangi == 'setiap_hari') {
                $q_agenda = Agenda::where(function($query) use($data, $day_arr, $now_day) {
                    if($data->agenda->ulangi == $day_arr[$now_day]) {
                       $query->where('ulangi', '=', $day_arr[$now_day]); 
                    } else {
                        $query->where('ulangi', '=', 'setiap_hari');
                    }
                })
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->count();
                
                if($q_agenda == 0) {
                    $id_agenda_new = Agenda::create([
                        'admin_id' => $data->agenda->admin_id,
                        'judul' => $data->agenda->judul,
                        'tanggal_mulai' => $data->agenda->tanggal_mulai,
                        'status' => 'belum',
                        'ulangi' => $data->agenda->ulangi
                    ]);

                    ChildAgendaUlangi::create([
                        'agenda_id' => $id_agenda_new->id,
                        'agenda_ulangi_id' => $agenda_ulangi_id
                    ]);
                }
            }
        }

        return view('agenda.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $agenda = Agenda::create([
                'admin_id' => auth()->user()->id,
                'judul' => $request->judul,
                'tanggal_mulai' => $request->tanggal_mulai,
                'status' => 'belum',
                'ulangi' => $request->ulangi
            ]);

            if($request->ulangi != 'satu_hari') {
                AgendaUlangi::create([
                    'agenda_id' => $agenda->id
                ]);
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            dd($e->getMessage());
        }

        return redirect()->route('agenda.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agenda = Agenda::with(['agendaUlangi', 'users'])->findOrFail($id);

        return view('agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        return view('agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $agenda = Agenda::with('agendaUlangi')->findOrFail($id);

        DB::beginTransaction();

        try {
            $agenda->update([
                'judul' => $request->judul,
                'tanggal_mulai' => $request->tanggal_mulai,
                'ulangi' => $request->ulangi
            ]);
            
            if($agenda->agendaUlangi()->exists()) {
                Agenda::whereHas('childAgendaUlangi', function($query) use($agenda) {
                    $query->where('agenda_ulangi_id', '=', $agenda->agendaUlangi->id);
                })->update([
                    'ulangi' => $request->ulangi
                ]);

                if($request->ulangi == 'satu_hari') {
                    $agenda->agendaUlangi->delete();
                }
            } else {
                if($request->ulangi != 'satu_hari') {
                    AgendaUlangi::create([
                        'agenda_id' => $agenda->id
                    ]);
                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            dd($e->getMessage());
        }

        return redirect()->route('agenda.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agenda = Agenda::with('childAgendaUlangi')->find($id);

        if($agenda->childAgendaUlangi()->exists()) {
            $agenda->agendaUlangi->agenda->delete();
        }

        $agenda->delete();
    }

    public function updateStatus(Request $request, Agenda $agenda)
    {
        $agenda->update([
            'status' => 'selesai'
        ]);

        return response()->json([
            'message' => 'Status berhasil diubah'
        ], 200);
    }

    public function indexRiwayat()
    {
        return view('riwayat.index');
    }
}
