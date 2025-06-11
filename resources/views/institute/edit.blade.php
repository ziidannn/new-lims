@extends('layouts.master')
@section('content')
@section('title', 'Edit Coa')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .checkbox label::before {
        border: 1px solid #333;
    }

    .form-select {
    width: 100%;
    min-width: 300px;
    }

    .select2-selection {
        white-space: normal !important; /* biar teks bisa wrap */
        height: auto !important;        /* tinggi mengikuti isi */
        min-height: 38px;
    }

    .select2-selection__rendered {
        white-space: normal !important;
        word-wrap: break-word !important;
        line-height: 1.2 !important;
    }

</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection
@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
        <div class="col-xl-12">
            <form class="card" method="POST" action="">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">@yield('title') ( <i>{{ $data->no_coa }} |
                            {{ $data->customer->name }}</i> )</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 mb-2">
                            <label class="form-label" for="basicDate">No Coa<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('no_coa') is-invalid @enderror"
                                    style="background-color:rgb(248, 246, 246);" maxlength="120" name="no_coa"
                                    placeholder="Example: 250101010.01" value="{{ old('no_coa', $data->no_coa ?? '') }}"
                                    readonly>
                                @error('no_coa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-2">
                            <label class="form-label @error('customer_id') is-invalid @enderror">Customer<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <select
                                    class="form-select @error('customer_id') is-invalid @enderror input-sm select2-modal"
                                    name="customer_id" id="customer_id">
                                    <option value="">Select Customer</option>
                                    @foreach($customer as $c)
                                    <option value="{{ $c->id }}" {{ $data->customer_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->id }} - {{$c->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-2">
                            <label class="form-label" for="basicDate">Sample Receive Data<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date"
                                    class="form-control @error('sample_receive_date') is-invalid @enderror"
                                    maxlength="120" name="sample_receive_date" placeholder="Input Sample Recive Data"
                                    value="{{ old('sample_receive_date', $data->sample_receive_date) }}">
                                @error('sample_receive_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-2">
                            <label class="form-label" for="basicDate">Sample Analysis Date<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date"
                                    class="form-control @error('sample_analysis_date') is-invalid @enderror"
                                    maxlength="120" name="sample_analysis_date" placeholder="Input Sample Analysis Date"
                                    value="{{ old('sample_analysis_date', $data->sample_analysis_date) }}">
                                @error('sample_analysis_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-2">
                            <label class="form-label" for="basicDate">Report Date<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('report_date') is-invalid @enderror"
                                    maxlength="120" name="report_date" placeholder="Input Sample Report Date"
                                    value="{{ old('report_date', $data->report_date) }}">
                                @error('report_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="col-form-label">Sample Description & Regulation</label>
                            <div id="subject_id_container">
                                @foreach ($data->subjects as $index => $subject)
                                <div class="mb-4 p-3 border rounded bg-light">
                                    <!-- Subject -->
                                    <label>Subject</label>
                                    <select name="subject_id[]" class="form-select select2-modal subject_id" required>
                                        <option value="">Select Subject</option>
                                        @foreach ($description as $desc)
                                            <option value="{{ $desc->id }}" {{ $subject->id == $desc->id ? 'selected' : '' }}>
                                                {{ $desc->subject_code }} - {{ $desc->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Regulation -->
                                    <label class="mt-3">Regulation</label>
                                    <select name="regulations[{{ $index }}][]" class="form-select select2-modal" multiple required>
                                        @foreach ($regulation->where('subject_id', $subject->id) as $rg)
                                            <option value="{{ $rg->id }}"
                                                {{ in_array($rg->id, $subject->instituteRegulations->pluck('regulation_id')->toArray()) ? 'selected' : '' }}>
                                                {{ $rg->regulation_code }} - {{ $rg->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Remove -->
                                    <div class="text-end mt-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-primary mt-2" id="add_more">+ Add More</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary me-1" type="submit">Update</button>
                    <a href="{{ url()->previous() }}">
                        <span class="btn btn-outline-secondary">Back</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
    $(document).ready(function () {
        // Init awal
        $('.select2-modal').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Tambah row baru
        $('#add_more').on('click', function () {
            let index = $('.row').length; // hitung index dinamis
            let container = $('#subject_id_container');
            let div = $(`
                <div class="row mb-2">
                    <div class="col-md-5">
                        <select name="subject_id[]" class="form-select select2-modal subject-select" required>
                            <option value="">Select Sample Description</option>
                            @foreach ($description as $desc)
                                <option value="{{ $desc->id }}">{{ $desc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <select name="regulations[${index}][]" class="form-select select2-modal regulation-select" multiple required>
                            <option value="">Select Regulation</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-row">X</button>
                    </div>
                </div>
            `);

            container.append(div);

            // Reinit select2
            div.find('.select2-modal').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });

        // Remove row
        $(document).on('click', '.remove-row', function () {
            $(this).closest('.row').remove();
        });

        // Load regulation berdasarkan subject_id
        $(document).on('change', '.subject-select', function () {
            let subjectId = $(this).val();
            let regulationSelect = $(this).closest('.row').find('.regulation-select');

            if (subjectId) {
                $.ajax({
                    url: "{{ route('DOC.get_regulation_id_by_id') }}",
                    type: "GET",
                    data: { ids: [subjectId] },
                    dataType: 'json',
                    success: function (results) {
                        let options = '';
                        $.each(results, function (key, value) {
                            options += `<option value="${value.id}">(${value.regulation_code}) - ${value.title}</option>`;
                        });
                        regulationSelect.html(options).trigger('change');
                    }
                });
            } else {
                regulationSelect.html('<option value="">Select Regulation</option>');
            }
        });
    });
</script>
@endsection

