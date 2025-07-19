@extends('layouts.master')
@section('title', 'Analysis Result')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
@endsection

@section('style')
<style>
    .header-row { margin-bottom: 1rem; }
    .header-row .form-label { font-weight: bold; white-space: nowrap; }
    .table-bordered th, .table-bordered td { vertical-align: middle; text-align: center; }
    .template-section { display: none; }
    #template-24hours .input-group-text { width: 40px; }
</style>
@endsection

@section('content')
<form class="card" id="main-analysis-form" action="{{ route('result.noise.add', $instituteSubject->id) }}" method="POST" onsubmit="return false;">
    @csrf
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="card-title mb-1">
                @yield('title') - <span class="fw-bold">{{ $subject->name ?? 'N/A' }}</span>
            </h4>
            @if(isset($regulations) && $regulations->isNotEmpty())
                @foreach ($regulations as $regulation)
                    <i class="fw-bold d-block" style="font-size: 1rem; color: darkred;">Reg: {{ $regulation->title ?? 'N/A' }}</i>
                @endforeach
            @endif
        </div>
    </div>

    <div class="card-body">
        {{-- BAGIAN 1: HEADER & PEMILIHAN TEMPLATE --}}
        <div class="row">
            <div class="col-md-6">
                <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sample No.</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_sample" value="{{ old('no_sample', $institute->no_coa ?? $samplings->no_sample) }}">
                    </div>
                </div>
                <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sampling Location</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sampling_location" value="{{ old('sampling_location', $samplings->sampling_location ?? '') }}">
                    </div>
                </div>
                 <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sample Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $subject->name }}" readonly>
                    </div>
                </div>
                 <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sampling Date</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="sampling_date" value="{{ old('sampling_date', $samplings->sampling_date ?? '') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sampling Time</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sampling_time" placeholder="e.g. 10:00 - 11:00" value="{{ old('sampling_time', $samplings->sampling_time ?? '') }}">
                    </div>
                </div>
                 <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sampling Methods</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="sampling_method" value="SNI 8990-2021 / SNI 9063-2022">
                    </div>
                </div>
                <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Date Received</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="date_received" value="{{ old('date_received', $institute->sample_receive_date ?? '') }}">
                    </div>
                </div>
                 <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Interval Testing Date</label>
                    <div class="col-sm-8 d-flex align-items-center">
                        <input type="date" class="form-control" name="itd_start" value="{{ old('itd_start', $institute->sample_analysis_date ?? '') }}">
                        <span class="mx-2">to</span>
                        <input type="date" class="form-control" name="itd_end" value="{{ old('itd_end', $institute->report_date ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="text-end">
            <button type="button" id="save-header-btn" class="btn btn-info">
                <i class="bx bx-save me-1"></i> Save Sample
            </button>
        </div> -->

        <!-- <hr> -->

        <div class="row header-row align-items-center">
            <label class="col-sm-2 col-form-label form-label">Template Type</label>
            <div class="col-sm-8">
                <select class="form-select" id="template-switcher" name="noise_template_type">
                    <option value="">-- Select Template --</option>
                    <option value="standard" {{ old('noise_template_type', $samplings->noise_template_type) == 'standard' ? 'selected' : '' }}>Standard Noise</option>
                    <option value="24hours" {{ old('noise_template_type', $samplings->noise_template_type) == '24hours' ? 'selected' : '' }}>24 Hours Noise</option>
                </select>
            </div>
             <div class="col-sm-2 text-end">
                 <button type="button" id="save-header-btn" class="btn btn-info">Save Sample & Template</button>
            </div>
        </div>
        <hr>

        {{-- TEMPLATE A: STANDARD NOISE --}}
        <div id="template-standard" class="template-section">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-3">Standard Noise Measurement</h5>
                <button type="button" id="add-location-btn" class="btn btn-primary btn-sm">Add Location</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Sampling Location</th>
                            <th>Testing Result</th>
                            <th>Time</th>
                            <th>Regulatory Standard</th>
                            <th>Unit</th>
                            <th>Methods</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="standard-noise-body">
                        @forelse($standardResults as $result)
                            <tr class="standard-row">
                                <td class="row-number">{{ $loop->iteration }}</td>
                                <td><input type="text" class="form-control form-control-sm" name="location" value="{{ $result->location }}"></td>
                                <td><input type="text" class="form-control form-control-sm" name="testing_result" value="{{ $result->testing_result }}"></td>
                                <td><input type="text" class="form-control form-control-sm" name="time" value="{{ $result->time }}"></td>
                                <td>{{ $standardParameter->regulation_standard_id ?? 'N/A' }}</td>
                                <td>dBA</td>
                                <td>{{ $standardParameter->method ?? 'N/A' }}</td>
                                <td><button type="button" class="btn btn-primary btn-sm save-standard-btn" data-result-id="{{ $result->id }}">Save</button></td>
                            </tr>
                        @empty
                            {{-- Akan diisi oleh JavaScript jika kosong --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TEMPLATE B: 24 HOURS NOISE --}}
        <div id="template-24hours" class="template-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                 <h5 class="mb-0">24 Hours Noise Measurement</h5>
                 <button type="button" id="add-location-24h-btn" class="btn btn-primary btn-sm">Add Location</button>
            </div>
            <div class="table-responsive">
                 <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th><th>Sampling Location</th><th>Noise</th><th>Time</th><th>Leq</th>
                            <th>Ls</th><th>Lm</th><th>Lsm</th>
                            <th>Regulatory Standard</th><th>Unit</th><th>Methods</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-24h">
                        @forelse($results24h as $result)
                            <tr class="row-24h">
                                <td class="row-number">{{ $loop->iteration }}</td>
                                <td><input type="text" class="form-control form-control-sm" name="location" value="{{ $result->sampling_location }}"></td>
                                <td>
                                    @for ($j = 0; $j < 7; $j++) <div class="input-group input-group-sm mb-1"><span class="input-group-text">L{{$j+1}}</span></div> @endfor
                                </td>
                                <td>
                                    @for ($j = 0; $j < 7; $j++) <div class="input-group input-group-sm mb-1"><span class="input-group-text">T{{$j+1}}</span></div> @endfor
                                </td>
                                <td>
                                    @php $leqs = explode(',', $result->leq ?? ''); @endphp
                                    @for ($j = 0; $j < 7; $j++) <input type="text" class="form-control form-control-sm mb-1" name="leq[]" value="{{ $leqs[$j] ?? '' }}"> @endfor
                                </td>
                                <td><input type="text" class="form-control form-control-sm" name="ls" value="{{ $result->ls }}"></td>
                                <td><input type="text" class="form-control form-control-sm" name="lm" value="{{ $result->lm }}"></td>
                                <td><input type="text" class="form-control form-control-sm" name="lsm" value="{{ $result->lsm }}"></td>
                                <td>{{ $param24h->regulatory_standard ?? 'N/A' }}</td>
                                <td>dBA</td>
                                <td>{{ $param24h->method ?? 'N/A' }}</td>
                                <td><button type="button" class="btn btn-primary btn-sm save-24h-btn" data-result-id="{{ $result->id }}">Save</button></td>
                            </tr>
                        @empty
                            {{-- Akan diisi oleh JavaScript --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('result.list_result', $institute->id) }}" class="btn btn-outline-secondary">Back</a>
    </div>
</form>
@endsection

@section('script')
{{-- Load semua library JS yang dibutuhkan --}}
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

<script>
$(document).ready(function() {
    //======================================================
    // 1. PENGATURAN AWAL & FUNGSI UTAMA
    //======================================================
    const csrfToken = '{{ csrf_token() }}';
    const formUrl = $('#main-analysis-form').attr('action');
    const standardParameterId = "{{ $standardParameter->id ?? '' }}";
    const param24hId = "{{ $param24h->id ?? '' }}";

    // Fungsi untuk menampilkan template yang sesuai berdasarkan pilihan dropdown
    function switchTemplate() {
        const selectedTemplate = $('#template-switcher').val();
        $('.template-section').hide(); // Sembunyikan semua template
        if (selectedTemplate) {
            $(`#template-${selectedTemplate}`).show(); // Tampilkan yang dipilih
        }
    }

    // Panggil saat halaman pertama kali dimuat untuk menampilkan template yang tersimpan
    switchTemplate();

    // Panggil setiap kali pilihan di dropdown berubah
    $('#template-switcher').on('change', switchTemplate);

    //======================================================
    // 2. LOGIKA UNTUK TEMPLATE STANDARD
    //======================================================

    // Fungsi untuk menomori ulang baris tabel standard
    function renumberStandardRows() {
        $('#standard-noise-body .standard-row').each(function(index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    // Fungsi untuk membuat baris baru di tabel Standard
    function createNewStandardRow() {
        const newRowHtml = `
            <tr class="standard-row">
                <td class="row-number"></td>
                <td><input type="text" class="form-control form-control-sm" name="location" placeholder="New Location"></td>
                <td><input type="text" class="form-control form-control-sm" name="testing_result"></td>
                <td><input type="text" class="form-control form-control-sm" name="time"></td>
                <td>{{ $standardParameter->regulation_standard_id ?? 'N/A' }}</td>
                <td>{{ $standardParameter->unit ?? 'N/A' }}</td>
                <td>{{ $standardParameter->method ?? 'N/A' }}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm save-standard-btn" data-result-id="">Save</button>
                    <button type="button" class="btn btn-danger btn-sm remove-standard-row">Remove</button>
                </td>
            </tr>`;
        $('#standard-noise-body').append(newRowHtml);
        renumberStandardRows();
    }

    // Jika tabel standard kosong saat dimuat, tambahkan satu baris
    if ($('#standard-noise-body .standard-row').length === 0) {
        createNewStandardRow();
    }
    renumberStandardRows();

    // Event listener untuk tombol "Add Location" di template standard
    $('#add-location-btn').on('click', createNewStandardRow);

    // Event listener untuk menghapus baris di template standard
    $('#standard-noise-body').on('click', '.remove-standard-row', function() {
        $(this).closest('tr').remove();
        renumberStandardRows();
    });

    // Fungsi untuk menomori ulang baris 24 jam
    function renumber24hRows() {
        $('#tbody-24h .row-24h').each(function(index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    // Fungsi untuk membuat baris baru di tabel 24 Jam
    function createNew24hRow() {
        const newRowHtml = `
            <tr class="row-24h">
                <td class="row-number"></td>
                <td><input type="text" class="form-control form-control-sm" name="location" placeholder="Location"></td>
                <td>
                    ${[...Array(7)].map((_, j) => `
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text">L${j + 1}</span>
                        </div>`).join('')}
                </td>
                <td>
                    ${[...Array(7)].map((_, j) => `
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text">T${j + 1}</span>
                        </div>`).join('')}
                </td>
                <td>
                    ${[...Array(7)].map((_, j) => `
                        <input type="text" class="form-control form-control-sm mb-1" name="leq[]" placeholder="Leq ${j + 1}">`).join('')}
                </td>
                <td><input type="text" class="form-control form-control-sm" name="ls" placeholder="Ls"></td>
                <td><input type="text" class="form-control form-control-sm" name="lm" placeholder="Lm"></td>
                <td><input type="text" class="form-control form-control-sm" name="lsm" placeholder="Lsm"></td>
                <td>{{ $param24h->regulation_standard_id ?? 'N/A' }}</td>
                <td>{{ $param24h->unit ?? 'N/A' }}</td>
                <td>{{ $param24h->method ?? 'N/A' }}</td>
                <td><button type="button" class="btn btn-primary btn-sm save-24h-btn" data-result-id="">Save</button></td>
            </tr>`;
        $('#tbody-24h').append(newRowHtml);
        renumber24hRows();
    }

    // Event listener untuk tombol Add Location di template 24 jam
    $('#add-location-24h-btn').on('click', function () {
        createNew24hRow();
    });
    // Jika tabel 24 jam kosong saat dimuat, tambahkan satu baris
    if ($('#tbody-24h .row-24h').length === 0) {
        createNew24hRow();
    }
    renumber24hRows();

    //======================================================
    // 3. KUMPULAN AJAX EVENT HANDLER
    //======================================================

    // 3.1. AJAX untuk Tombol "Save Sample Data & Template"
    $('#save-header-btn').on('click', function() {
        const button = $(this);
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        const headerData = {
            _token: csrfToken,
            action: 'save_header',
            sampling_location: $('input[name="sampling_location"]').val(),
            sampling_date: $('input[name="sampling_date"]').val(),
            sampling_time: $('input[name="sampling_time"]').val(),
            sampling_method: $('input[name="sampling_method"]').val(),
            date_received: $('input[name="date_received"]').val(),
            itd_start: $('input[name="itd_start"]').val(),
            itd_end: $('input[name="itd_end"]').val(),
            noise_template_type: $('#template-switcher').val()
        };

        $.ajax({
            url: formUrl, type: 'POST', data: headerData,
            success: function(response) {
                if(response.success) swal("Success!", response.message, "success");
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMsg = xhr.responseJSON.message || "An error occurred.";
                if (errors) errorMsg = Object.values(errors).flat().join('\n');
                swal("Validation Error!", errorMsg, "error");
            },
            complete: function() {
                button.prop('disabled', false).html('<i class="bx bx-save me-1"></i> Save Sample & Template');
            }
        });
    });

    // 3.2. AJAX untuk Tombol "Save" per baris di Template Standard
    $('#standard-noise-body').on('click', '.save-standard-btn', function() {
        const button = $(this);
        const row = button.closest('tr');
        button.prop('disabled', true).text('...');

        const rowData = {
            _token: csrfToken, action: 'save_standard_result',
            result_id: button.data('result-id') || null,
            parameter_id: standardParameterId,
            location: row.find('input[name="location"]').val(),
            testing_result: row.find('input[name="testing_result"]').val(),
            time: row.find('input[name="time"]').val()
        };

        $.ajax({
            url: formUrl, type: 'POST', data: rowData,
            success: function(response) {
                if(response.success){
                    if(response.new_result_id) {
                        button.data('result-id', response.new_result_id);
                    }
                    swal("Success!", response.message, "success");
                    row.css('background-color', '#d4edda');
                    setTimeout(() => row.css('background-color', ''), 2000);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMsg = xhr.responseJSON.message || "Could not save.";
                if (errors) { errorMsg = Object.values(errors).flat().join('\n'); }
                swal("Error!", errorMsg, "error");
            },
            complete: function() { button.prop('disabled', false).text('Save'); }
        });
    });

    // 3.3. AJAX untuk Tombol "Save 24h Results"
    $('#tbody-24h').on('click', '.save-24h-btn', function () {
        const button = $(this);
        const row = button.closest('tr');

        button.prop('disabled', true).text('Saving...');

        const rowData = {
            _token: csrfToken,
            action: 'save_24h_location_result',
            result_id: button.data('result-id') || null,
            parameter_id: param24hId,
            location: row.find('input[name="location"]').val(),
            leq: row.find('input[name="leq[]"]').map(function() { return $(this).val(); }).get(),
            ls: row.find('input[name="ls"]').val(),
            lm: row.find('input[name="lm"]').val(),
            lsm: row.find('input[name="lsm"]').val(),
        };

        $.ajax({
            url: formUrl,
            type: 'POST',
            data: rowData,
            success: function (response) {
                if (response.success) {
                    if (response.new_result_id) {
                        button.data('result-id', response.new_result_id);
                    }
                    swal("Success!", response.message, "success");
                    row.css('background-color', '#d4edda');
                    setTimeout(() => row.css('background-color', ''), 2000);
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMsg = xhr.responseJSON.message || "Could not save.";
                if (errors) { errorMsg = Object.values(errors).flat().join('\n'); }
                swal("Error!", errorMsg, "error");
            },
            complete: function () {
                button.prop('disabled', false).text('Save');
            }
        });
    });
});
</script>
@endsection
