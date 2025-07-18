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
    .parameter-name-row { background-color: #f8f9fa; font-weight: bold; }
    .sub-row td { border-top: none !important; padding-top: 0.3rem; padding-bottom: 0.3rem; }
</style>
@endsection

@section('content')
<form class="card" id="main-analysis-form" action="{{ route('result.odor.add', $instituteSubject->id) }}" method="POST" onsubmit="return false;">
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
        {{-- BAGIAN 1: HEADER INFORMASI SAMPEL --}}
        <div class="row">
            <div class="col-md-6">
                <div class="row header-row">
                    <label class="col-sm-4 col-form-label form-label">Sample No.</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_sample" value="{{ old('no_sample', $samplings->no_sample ?? $institute->no_coa) }}">
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
        <div class="text-end">
            <button type="button" id="save-header-btn" class="btn btn-info">
                <i class="bx bx-save me-1"></i> Save Sample
            </button>
        </div>
        <hr>

        {{-- BAGIAN 2: TABEL HASIL ANALISIS --}}
         <div class="table-responsive">
            <table class="table table-bordered mt-3" id="parameterTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Parameters</th>
                        <th style="width: 15%;">Testing Result</th>
                        <th style="width: 20%;">Regulatory Standard</th>
                        <th style="width: 8%;">Unit</th>
                        <th>Methods</th>
                        <th style="width: 8%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rowNumber = 1; @endphp
                    @foreach ($parameters as $parameter)
                        @php
                            // Ambil semua kombinasi sampling time untuk parameter ini
                            $samplingTimeRelations = $samplingTimeRegulations->get($parameter->id);
                        @endphp

                        @if ($samplingTimeRelations && $samplingTimeRelations->count() > 0)
                            @foreach ($samplingTimeRelations as $relation)
                                @php
                                    $samplingTime = $relation->samplingTime;
                                    $regulationStandards = $relation->regulationStandards; // Gunakan nama relasi tunggal yang benar
                                    $resultKey = "{$parameter->id}-{$samplingTime->id}";
                                    $result = $results->get($resultKey);
                                @endphp
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td class="text-start">{{ $parameter->name }}</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-center"
                                               value="{{ old('results.'.$resultKey, $result->testing_result ?? '') }}">
                                    </td>
                                    <td>{{ $regulationStandards->title ?? '-' }}</td>
                                    <td>{{ $parameter->unit }}</td>
                                    <td>{{ $parameter->method }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm save-result-btn"
                                                data-parameter-id="{{ $parameter->id }}"
                                                data-sampling-time-id="{{ $samplingTime->id }}"
                                                data-regulation-standard-id="{{ $regulationStandards->id }}">
                                            Save
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Baris ini ditampilkan jika parameter tidak punya sampling time sama sekali --}}
                            <tr>
                                <td>{{ $rowNumber++ }}</td>
                                <td class="text-start">{{ $parameter->name }}</td>
                                <td colspan="6" class="text-center text-muted">No sampling time set for this parameter.</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>

        {{-- BAGIAN 3: FIELD CONDITIONS --}}
        <div class="row mt-4">
            <h4 class="mb-3">Environmental Condition</h4>
            {{-- ... Letakkan input untuk field conditions (coordinate, temperature, dll) di sini ... --}}
            <div class="row">
                <div class="col-lg-6 col-md-6 field-condition" id="coordinate">
                    <label class="form-label">Coordinate</label>
                    <input type="text" class="form-control" name="coordinate" placeholder="Input Coordinate"
                        value="{{ old('coordinate', $fieldCondition->coordinate ?? '') }}">
                </div>
                <div class="col-lg-6 col-md-6 field-condition" id="temperature">
                    <label class="form-label">Temperature</label>
                    <input type="text" class="form-control" name="temperature" placeholder="Input Temperature"
                        value="{{ old('temperature', $fieldCondition->temperature ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 field-condition" id="pressure">
                    <label class="form-label">Pressure</label>
                    <input type="text" class="form-control" name="pressure" placeholder="Input Pressure"
                        value="{{ old('pressure', $fieldCondition->pressure ?? '') }}">
                </div>
                <div class="col-lg-6 col-md-6 field-condition" id="humidity">
                    <label class="form-label">Humidity</label>
                    <input type="text" class="form-control" name="humidity" placeholder="Input Humidity"
                        value="{{ old('humidity', $fieldCondition->humidity ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 field-condition" id="wind_speed">
                    <label class="form-label">Wind Speed</label>
                    <input type="text" class="form-control" name="wind_speed" placeholder="Input Wind Speed"
                        value="{{ old('wind_speed', $fieldCondition->wind_speed ?? '') }}">
                </div>
                <div class="col-lg-6 col-md-6 field-condition" id="wind_direction">
                    <label class="form-label">Wind Direction</label>
                    <input type="text" class="form-control" name="wind_direction"
                        placeholder="Input Wind Direction"
                        value="{{ old('wind_direction', $fieldCondition->wind_direction ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 field-condition" id="weather">
                    <label class="form-label">Weather</label>
                    <input type="text" class="form-control" name="weather" placeholder="Input Weather"
                        value="{{ old('weather', $fieldCondition->weather ?? '') }}">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                <button type="button" id="save-field-btn" class="btn btn-info">Save Conditions</button>
            </div>
        </div>
        {{-- BAGIAN OPSI LOGO & FOOTER --}}
        <div class="px-4 pb-3">
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <label class="form-label d-block fw-bold">Display logo on the report?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="showLogoYes" name="show_logo" value="1"
                            {{ old('show_logo', $samplings->show_logo) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="showLogoYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="showLogoNo" name="show_logo" value="0"
                            {{ old('show_logo', $samplings->show_logo) != 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="showLogoNo">No</label>
                    </div>
                </div>
                <div>
                    {{-- ✅ Tombol Baru Khusus untuk Simpan Logo --}}
                    <button type="button" id="save-logo-btn" class="btn btn-info">Save Logo</button>
                    <a href="{{ route('result.list_result', $institute->id) }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';
    const formUrl = $('#main-analysis-form').attr('action');

    // ======================================================
    // AJAX UNTUK TOMBOL "Save Sample Data"
    // ======================================================
    $('#save-header-btn').on('click', function() {
        const button = $(this);
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

        const headerData = {
            _token: csrfToken,
            action: 'save_header',
            no_sample: $('input[name="no_sample"]').val(),
            sampling_location: $('input[name="sampling_location"]').val(),
            sampling_date: $('input[name="sampling_date"]').val(),
            sampling_time: $('input[name="sampling_time"]').val(),
            sampling_method: $('input[name="sampling_method"]').val(),
            date_received: $('input[name="date_received"]').val(),
            itd_start: $('input[name="itd_start"]').val(),
            itd_end: $('input[name="itd_end"]').val()
        };

        $.ajax({
            url: formUrl,
            type: 'POST',
            data: headerData,
            success: function(response) {
                if(response.success) {
                    swal("Success!", response.message, "success");
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMsg = "An error occurred. Please check your input.";
                if (errors) {
                    errorMsg = Object.values(errors).flat().join('\n');
                }
                swal("Validation Error!", errorMsg, "error");
            },
            complete: function() {
                button.prop('disabled', false).html('<i class="bx bx-save me-1"></i> Save Sample Data');
            }
        });
    });

    // SCRIPT AJAX UNTUK SAVE FIELD CONDITIONS
    // SCRIPT AJAX UNTUK SAVE FIELD CONDITIONS
    $('#save-field-btn').on('click', function() {
        const button = $(this);
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        const fieldData = {
            _token: csrfToken,
            action: 'save_field_conditions',
            coordinate: $('input[name="coordinate"]').val(),
            temperature: $('input[name="temperature"]').val(),
            pressure: $('input[name="pressure"]').val(),
            humidity: $('input[name="humidity"]').val(),
            wind_speed: $('input[name="wind_speed"]').val(),
            wind_direction: $('input[name="wind_direction"]').val(),
            weather: $('input[name="weather"]').val(),
        };

        $.ajax({
            url: formUrl, type: 'POST', data: fieldData,
            success: function(response) { swal("Success!", response.message, "success"); },
            error: function(xhr) { swal("Error!", "Could not save field conditions.", "error"); },
            complete: function() { button.prop('disabled', false).text('Save Field Conditions'); }
        });
    });

    // SCRIPT AJAX UNTUK SAVE PER HASIL TES
    $('#parameterTable').on('click', '.save-parameter-btn', function() {
        const button = $(this);
        button.prop('disabled', true).text('...');
        const parameterId = button.data('parameter-id');
        const testingResult = button.closest('tr').find('input[name*="testing_result"]').val();
        const parameterData = {
            _token: csrfToken, action: 'save_single_parameter',
            parameter_id: parameterId, testing_result: testingResult
        };
        $.ajax({
            url: formUrl, type: 'POST', data: parameterData,
            success: function(response) {
                if(response.success){
                    // Animasi hijau (sudah ada)
                    button.closest('tr').css('background-color', '#d4edda');
                    setTimeout(() => button.closest('tr').css('background-color', ''), 2000);

                    // ✅ TAMBAHKAN NOTIFIKASI INI
                    swal("Success!", response.message, "success");
                } else {
                    swal("Error!", response.message, "error");
                }
            },
            error: function(xhr) { swal("Error!", xhr.responseJSON.message || "Could not save.", "error"); },
            complete: function() { button.prop('disabled', false).text('Save'); }
        });
    });

    // ✅ JAVASCRIPT BARU UNTUK TOMBOL "Save Logo Preference"
    $('#save-logo-btn').on('click', function() {
        const button = $(this);
        button.prop('disabled', true).text('Saving...');

        const logoData = {
            _token: csrfToken,
            action: 'save_logo_preference',
            show_logo: $('input[name="show_logo"]:checked').val()
        };

        $.ajax({
            url: formUrl,
            type: 'POST',
            data: logoData,
            success: function(response) {
                if(response.success) {
                    swal("Success!", response.message, "success");
                }
            },
            error: function(xhr) {
                swal("Error!", xhr.responseJSON.message || "Could not save preference.", "error");
            },
            complete: function() {
                button.prop('disabled', false).text('Save Logo');
            }
        });
    });

    // ======================================================
    // SCRIPT HIDE/UNDO BAWAAN ANDA (SUDAH DISESUAIKAN)
    // ======================================================
    const instituteSubjectId = "{{ $instituteSubject->id }}"; // Kunci unik untuk localStorage
    let storedHidden = JSON.parse(localStorage.getItem(`hidden_params_${instituteSubjectId}`)) || [];

    function updateUndoButton() {
        $('#btn-undo').toggle(storedHidden.length > 0);
    }

    // Saat halaman dimuat, sembunyikan yang perlu disembunyikan
    storedHidden.forEach(paramId => {
        $(`tr[data-row-id="${paramId}"]`).hide();
    });
    updateUndoButton();

    // Event listener untuk tombol hide
    $('#parameterTable').on('click', '.hide-parameter', function() {
        const button = $(this);
        const parameterId = button.data('parameter-id');

        if (!storedHidden.includes(parameterId)) {
            storedHidden.push(parameterId);
            localStorage.setItem(`hidden_params_${instituteSubjectId}`, JSON.stringify(storedHidden));
            button.closest('tr').fadeOut();
            updateUndoButton();
        }
    });

    // Event listener untuk tombol undo
    $('#btn-undo').on('click', function() {
        if (storedHidden.length > 0) {
            let lastHiddenId = storedHidden.pop();
            localStorage.setItem(`hidden_params_${instituteSubjectId}`, JSON.stringify(storedHidden));
            $(`tr[data-row-id="${lastHiddenId}"]`).fadeIn();
            updateUndoButton();
        }
    });
});
</script>
@endsection
