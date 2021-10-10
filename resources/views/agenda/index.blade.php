@extends('template.app')

@section('title', 'Agenda')

@push('libraries-css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.21/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/Responsive-2.2.5/css/responsive.bootstrap4.min.css') }}">
    <style>
        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Agenda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Agenda</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <h4>Data Agenda</h4>
                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route('agenda.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah Data</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tbody>
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Ulangi</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('libraries-js')
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.21/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.21/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/Responsive-2.2.5/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Datatables
            const table = $('table').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: "{{ route('agenda.json') }}",
                    headers: {
                        'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                    },
                    method: 'GET'
                },
                columns: [
                    { data: 'judul', name: 'judul' },
                    { data: 'ulangi', name: 'ulangi' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'aksi', name: 'aksi' }
                ],
                columnDefs: [
                    {
                        targets: [4],
                        orderable: false
                    },
                    {
                        targets: [4],
                        searchable: false
                    },
                    {
                        targets: 3,
                        visible: false
                    }
                ],
                order: [[3, 'desc']]
            });

            // delete
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).attr('data-id');

                $.ajax({
                    url: `/agenda/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });
        });
    </script>
@endpush
