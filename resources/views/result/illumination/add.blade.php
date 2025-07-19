@extends('layouts.master')
@section('title', 'Analysis Result')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2.css')}}">
@endsection

@section('style')
<style>
    .header-row { margin-bottom: 1rem; }
    .header-row .form-label { font-weight: bold; white-space: nowrap; }
    .table-bordered th, .table-bordered td { vertical-align: middle; text-align: center; }
</style>
@endsection

@section('content')
<form class="card" id="main-analysis-form" action="{{ route('result.illumination.add', $instituteSubject->id) }}" method="POST" onsubmit="return false;">
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button type="button" id="add-location-btn" class="btn btn-primary btn-sm">
                <i class="bx bx-plus me-1"></i>Add Location
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Sampling Location</th>
                        <th style="width:15%">Testing Result</th>
                        <th style="width:10%">Time</th>
                        <th style="width:15%">Regulatory Standard</th>
                        <th style="width:8%">Unit</th>
                        <th>Methods</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody id="illumination-body">
                    @forelse($results as $result)
                        <tr class="illumination-row">
                            <td class="row-number">{{ $loop->iteration }}</td>
                            <td><input type="text" class="form-control form-control-sm" name="location" value="{{ $result->sampling_location }}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="testing_result" value="{{ $result->testing_result }}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="time" value="{{ $result->time }}"></td>
                            <td><input type="text" class="form-control form-control-sm" name="regulatory_standard" value="{{ $result->regulatory_standard }}"></td>
                            <td>{{ $illuminationParameter->unit ?? 'Lux' }}</td>
                            <td>{{ $illuminationParameter->method ?? '-' }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm save-result-btn" data-result-id="{{ $result->id }}">Save</button>
                                <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                            </td>
                        </tr>
                    @empty
                        {{-- Baris pertama akan dibuat oleh JavaScript jika tidak ada data --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer text-end">
        <a href="{{ route('result.list_result', $institute->id) }}" class="btn btn-outline-secondary">Back</a>
    </div>
</form>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

<script>
$(document).ready(function() {
    const csrfToken = '{{ csrf_token() }}';
    const formUrl = $('#main-analysis-form').attr('action');
    const parameterId = "{{ $illuminationParameter->id ?? '' }}";

    function renumberRows() {
        $('#illumination-body .illumination-row').each(function(index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    function createNewRow() {
        const newRowHtml = `
            <tr class="illumination-row">
                <td class="row-number"></td>
                <td><input type="text" class="form-control form-control-sm" name="location" placeholder="New Location"></td>
                <td><input type="text" class="form-control form-control-sm" name="testing_result"></td>
                <td><input type="text" class="form-control form-control-sm" name="time"></td>
                <td><input type="text" class="form-control form-control-sm" name="regulatory_standard"></td>
                <td>{{ $illuminationParameter->unit ?? 'Lux' }}</td>
                <td>{{ $illuminationParameter->method ?? '-' }}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm save-result-btn" data-result-id="">Save</button>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                </td>
            </tr>`;
        $('#illumination-body').append(newRowHtml);
        renumberRows();
    }

    if ($('#illumination-body .illumination-row').length === 0) {
        createNewRow();
    }
    renumberRows();

    $('#add-location-btn').on('click', createNewRow);

    $('#illumination-body').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        renumberRows();
    });

    // AJAX untuk Save Header
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

    // AJAX untuk Save per baris hasil
    $('#illumination-body').on('click', '.save-result-btn', function() {
        const button = $(this);
        const row = button.closest('tr');
        button.prop('disabled', true).text('...');

        const rowData = {
            _token: csrfToken, action: 'save_illumination_result',
            result_id: button.data('result-id') || null,
            parameter_id: parameterId,
            location: row.find('input[name="location"]').val(),
            testing_result: row.find('input[name="testing_result"]').val(),
            time: row.find('input[name="time"]').val(),
            regulatory_standard: row.find('input[name="regulatory_standard"]').val()
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
});
</script>
@endsection
