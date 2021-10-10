<form action="{{ isset($agenda) ? route('agenda.update', $agenda->id) : route('agenda.store') }}" method="POST">
    @csrf

    @if(isset($agenda))
        <input type="hidden" name="_method" value="PUT">
    @endif

    <div class="form-group">
        <label for="judul">Judul <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="judul" name="judul" value="{{ isset($agenda) ? $agenda->judul : old('judul') }}" required>
    </div>
    <div class="form-group">
        <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ isset($agenda) ? $agenda->tanggal_mulai->format('Y-m-d') : old('tanggal_mulai') }}" required>
    </div>
    <div class="form-group">
        <label for="ulangi">Ulangi <span class="text-danger">*</span></label>
        <select class="form-control" id="ulangi" name="ulangi" required>
            <option value="satu_hari" {{ isset($agenda) && $agenda->ulangi == 'satu_hari' ? 'selected' : '' }}>Satu Hari</option>
            <option value="setiap_hari" {{ isset($agenda) && $agenda->ulangi == 'setiap_hari' ? 'selected' : '' }}>Setiap Hari</option>
            <option value="senin" {{ isset($agenda) && $agenda->ulangi == 'senin' ? 'selected' : '' }}>Senin</option>
            <option value="selasa" {{ isset($agenda) && $agenda->ulangi == 'selasa' ? 'selected' : '' }}>Selasa</option>
            <option value="rabu" {{ isset($agenda) && $agenda->ulangi == 'rabu' ? 'selected' : '' }}>Rabu</option>
            <option value="kamis" {{ isset($agenda) && $agenda->ulangi == 'kamis' ? 'selected' : '' }}>Kamis</option>
            <option value="jumat" {{ isset($agenda) && $agenda->ulangi == 'jumat' ? 'selected' : '' }}>Jumat</option>
            <option value="sabtu" {{ isset($agenda) && $agenda->ulangi == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
            <option value="minggu" {{ isset($agenda) && $agenda->ulangi == 'minggu' ? 'selected' : '' }}>Minggu</option>
        </select>
    </div>
    <div class="form-group">
        @if(isset($agenda))
            <a href="{{ route('agenda.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
        @else
            <button type="reset" class="btn btn-sm btn-outline-secondary">Reset</button>
        @endif
        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
    </div>
</form>