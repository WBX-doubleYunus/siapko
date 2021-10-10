@extends('template.app')

@section('title', 'Agenda')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Agenda</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></div>
                <div class="breadcrumb-item">Edit Data</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Agenda</h4>
                        </div>
                        <div class="card-body">
                            @include('agenda.partials._form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
