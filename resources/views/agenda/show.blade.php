@extends('template.app')

@section('title', 'Agenda')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Agenda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></div>
                <div class="breadcrumb-item">Detail Data</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Agenda</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Judul</strong>
                                    <span>{{ $agenda->judul }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Ulangi</strong>
                                    <span>
                                        <span class="badge badge-primary">{{ ucwords(str_replace('_', ' ', $agenda->ulangi)) }}</span>
                                    </span>
                                </li>
                                @if($agenda->ulangi == 'satu_hari')
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Tanggal Mulai</strong>
                                        <span>{{ $agenda->tanggal_mulai->format('d/m/Y') }}</span>
                                    </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Status</strong>
                                    <span>{{ $agenda->status == 'belum' ? 'Belum Selesai' : 'Sudah Selesai' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Dibuat Oleh</strong>
                                    <span>{{ $agenda->users->nama }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('agenda.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            @if(auth()->user()->role == 'pemilik' && $agenda->status == 'belum')
                                <button type="button" class="btn btn-sm btn-success btn-selesai">Selesai</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page-js')
    <script>
        $(function() {
            $('.btn-selesai').on('click', function() {
                $.ajax({
                    url: "{{ route('agenda.update-status', $agenda->id) }}",
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        location.reload();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endpush
