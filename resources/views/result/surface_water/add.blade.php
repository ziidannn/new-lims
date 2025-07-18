@extends('layouts.master')
@section('title', 'Analysis Result')

@section('css')
{{-- CSS Anda yang sudah ada --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
@endsection

@section('style')
<style>
    .header-row {
        margin-bottom: 1rem;
    }
    .header-row .form-label {
        font-weight: bold;
        white-space: nowrap;
    }
    .header-row .form-control[readonly] {
        background-color: #f0f0f0;
    }
    .table-bordered th, .table-bordered td {
        vertical-align: middle;
        text-align: center;
    }
    .parameter-group-header th {
        background-color: #f8f9fa;
        text-align: left !important;
        font-weight: bold;
    }
    /* Memberi sedikit ruang antar tombol di kolom Aksi */
    .action-buttons .btn {
        margin-right: 5px;
    }
</style>
@endsection

@section('content')

{{--
======================================================================
    FORM UTAMA
    Hanya ada satu form yang membungkus semuanya.
    Diberi ID agar mudah ditarget oleh JavaScript.
======================================================================
--}}
<form class="card" id="main-analysis-form" action="{{ route('result.surface_water.add', $instituteSubject->id) }}" method="POST" onsubmit="return false;">
    @csrf
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        {{-- Info Judul dan Regulasi --}}
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
        {{-- Tombol untuk menyimpan data header --}}
        <div class="mt-2 mt-md-0">
            <button type="button" id="save-header-btn" class="btn btn-info">
                <i class="bx bx-save me-1"></i> Save Sample Data
            </button>
        </div>
    </div>

    <div class="card-body">
        {{--
        ======================================================================
            BAGIAN 1: HEADER INFORMASI SAMPEL (Sesuai Template Word)
        ======================================================================
        --}}
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

        <hr>

        {{--
        ======================================================================
            BAGIAN 2: TABEL HASIL ANALISIS (Sesuai Template Word)
        ======================================================================
        --}}
        <div class="table-responsive">
            <table class="table table-bordered mt-3" id="parameterTable">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" style="width: 5%;">No</th>
                        <th rowspan="2">Parameters</th>
                        <th rowspan="2" style="width: 8%;">Unit</th>
                        <th rowspan="2" style="width: 15%;">Testing Result</th>
                        <th colspan="4">Regulatory Standard</th>
                        <th rowspan="2">Methods</th>
                        <th rowspan="2" style="width: 12%;">Action</th> {{-- Kolom Aksi Baru --}}
                    </tr>
                    <tr>
                        <th>I</th>
                        <th>II</th>
                        <th>III</th>
                        <th>IV</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedParameters as $groupName => $parameters)
                        @if ($parameters->isNotEmpty())
                            <tr class="parameter-group-header">
                                <th colspan="11">{{ $groupName }}</th> {{-- Sesuaikan colspan menjadi 11 --}}
                            </tr>
                            @php $parameterNumber = 1; @endphp
                            @foreach ($parameters as $parameter)
                                @php $result = $results->get($parameter->id); @endphp
                                <tr data-row-id="{{ $parameter->id }}"> {{-- Tambahkan ID untuk target hide/show --}}
                                    <td>{{ $parameterNumber++ }}</td>
                                    <td class="text-start">{{ $parameter->name }}</td>
                                    <td>{{ $parameter->unit }}</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-center" name="results[{{ $parameter->id }}][testing_result]" value="{{ old('results.'.$parameter->id.'.testing_result', $result->testing_result ?? '') }}">
                                    </td>
                                    @php $standards = $regStandardsByParameter[$parameter->id] ?? null; @endphp
                                    <td>{{ $standards['I'] ?? '-' }}</td>
                                    <td>{{ $standards['II'] ?? '-' }}</td>
                                    <td>{{ $standards['III'] ?? '-' }}</td>
                                    <td>{{ $standards['IV'] ?? '-' }}</td>
                                    <td>{{ $parameter->method }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center action-buttons">
                                            <button type="button" class="btn btn-primary btn-sm save-parameter-btn" data-parameter-id="{{ $parameter->id }}">Save</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm hide-parameter" data-parameter-id="{{ $parameter->id }}">Hide</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3">
             <button id="btn-undo" class="btn btn-warning me-1" style="display: none;">Undo Hide</button>
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
                <button type="button" id="save-logo-btn" class="btn btn-success">Save Logo Preference</button>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

<script>
$(document).ready(function() {
    // Ambil CSRF token untuk semua request AJAX
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

    // ======================================================
    // AJAX UNTUK TOMBOL "Save" PER BARIS PARAMETER
    // ======================================================
    $('#parameterTable').on('click', '.save-parameter-btn', function() {
        const button = $(this);
        button.prop('disabled', true).text('...');

        const parameterId = button.data('parameter-id');
        const testingResult = button.closest('tr').find('input[name*="testing_result"]').val();

        const parameterData = {
            _token: csrfToken,
            action: 'save_single_parameter',
            parameter_id: parameterId,
            testing_result: testingResult
        };

        $.ajax({
            url: formUrl,
            type: 'POST',
            data: parameterData,
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
            error: function(xhr) {
                swal("Error!", xhr.responseJSON.message || "Could not save the result.", "error");
            },
            complete: function() {
                button.prop('disabled', false).text('Save');
            }
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
                button.prop('disabled', false).text('Save Logo Preference');
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
