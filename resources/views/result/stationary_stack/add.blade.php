@extends('layouts.master')
@section('title', 'Analysis')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endsection

@section('style')
<style>
    .checkbox label::before {
        border: 1px solid #333;
    }

    .form-group {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Jarak antara label dan input */
    }

    .form-label {
        white-space: nowrap;
        /* Mencegah label turun ke bawah */
        font-weight: bold;
    }

    .form-control {
        flex: 1;
        /* Membuat input menyesuaikan lebar */
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .text-danger {
        color: red;
    }

</style>
@endsection

@section('breadcrumb-title')
@endsection
@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    @if(session('msg'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form class="card" action="{{ route('result.stationary_stack.add', $instituteSubject->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-header">
                <h4 class="card-title mb-0">@yield('title')
                    @if ($subject)
                    <i class="fw-bold">{{ $subject->name }}</i>
                    @else
                    <i class="fw-bold">No Name Available</i>
                    @endif
                </h4>
                @if ($regulations->isNotEmpty())
                @foreach ($regulations as $regulation)
                <i class="fw-bold"
                    style="font-size: 1.1rem; color: darkred;">{{ $regulation->title ?? 'No Name Available' }}</i>
                @endforeach
                @endif
            </div>
            <div class="card-body">
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
                <div class="row">
                    <table class="table table-bordered" id="samplingLocationTable">
                        <thead>
                            <tr>
                                <th class="text-center"><b>Sample No.</b></th>
                                <th class="text-center"><b>Sampling Location</b></th>
                                <th class="text-center"><b>Sample Description</b></th>
                                <th class="text-center"><b>Sampling Date</b></th>
                                <th class="text-center"><b>Sampling Time</b></th>
                                <th class="text-center"><b>Sampling Method</b></th>
                                <th class="text-center"><b>Date Received</b></th>
                                <th class="text-center"><b>Interval Testing Date</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $institute->no_coa ?? '') }}" readonly>
                                    <input type="number" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $samplings->no_sample ?? '') }}">
                                </td>
                                <td><input type="text" class="form-control text-center" name="sampling_location"
                                        value="{{ old('sampling_location', $samplings->sampling_location ?? '') }}">
                                </td>
                                <td>
                                    <input type="hidden" name="institute_id" value="{{ $institute->id }}">
                                    <input type="hidden" name="institute_subject_id"
                                        value="{{ $instituteSubject->id }}">
                                    <input type="text" class="form-control text-center"
                                        value="{{ $instituteSubject->subject->name }}" readonly>
                                </td>
                                <td><input type="date" class="form-control text-center" name="sampling_date"
                                        value="{{ old('sampling_date', $institute->sample_receive_date ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="sampling_time"
                                        value="{{ old('sampling_time', $samplings->sampling_time ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="sampling_method"
                                        value="Grab" readonly></td>
                                <td><input type="date" class="form-control text-center" name="date_received"
                                        value="{{ old('date_received', $institute->sample_analysis_date ?? '') }}"></td>
                                <td>
                                    <input type="date" class="form-control text-center" name="itd_start"
                                        value="{{ old('itd_start', $institute->sample_analysis_date ?? '') }}">
                                    <span class="mx-2">to</span>
                                    <input type="date" class="form-control text-center" name="itd_end"
                                        value="{{ old('itd_end', $institute->report_date ?? '') }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end" style="margin-top: -30px;">
                <button class="btn btn-primary custom-button custom-blue" type="submit" name="action"
                    value="add_sample">Save</button>
                <a href="{{ route('result.list_result',$institute->id) }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
        </div>
    </form>
</div>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('result.stationary_stack.add', $instituteSubject->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered" id="parameterTable">
                        <tr>
                            <th class="text-center"><b>No</b></th>
                            <th class="text-center"><b>Parameters</b></th>
                            <th class="text-center"><b>Testing Result</b></th>
                            <th class="text-center"><b>Regulatory Standard</b></th>
                            <th class="text-center"><b>Unit</b></th>
                            <th class="text-center"><b>Methods</b></th>
                            <th class="text-center"><b>Action</b></th>
                        </tr>
                        @php $parameterNumber = 1; @endphp
                        @foreach ($parameters->filter(function($parameter) {
                        return $parameter->subject_id == 7 || $parameter->code_subject == '07' ||
                        $parameter->subjects->name == 'Stationary Stack Source Emission';
                        }) as $parameter)
                        <tr>
                            <form class="card" action="{{ route('result.stationary_stack.add', $instituteSubject->id) }}"
                                method="POST">
                                @csrf
                                <td class="text-center">{{ $parameterNumber++ }}</td>
                                <td>
                                    <input type="hidden" name="parameter_id[]" value="{{ $parameter->id }}">
                                    <input type="text" class="form-control text-center" value="{{ $parameter->name }}"
                                        readonly>
                                </td>
                                @php
                                    $resultObj = optional($results->get($parameter->id))->first();
                                    $regulationStandard = optional(
                                        $samplingTimeRegulations->where('parameter_id', $parameter->id)->first()
                                    )->regulationStandards;
                                @endphp

                                <td>
                                    <input type="text" class="form-control text-center"
                                        name="testing_result[{{ $parameter->id }}]"
                                        value="{{ old('testing_result.' . $parameter->id, $resultObj->testing_result ?? '') }}">
                                    @if ($errors->has('testing_result.' . $parameter->id))
                                        <span class="text-danger">{{ $errors->first('testing_result.' . $parameter->id) }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($regulationStandard)
                                        <input type="hidden" name="regulation_standard_id[{{ $parameter->id }}]" value="{{ $regulationStandard->id }}">
                                        <input type="text" class="form-control text-center" value="{{ $regulationStandard->title }}" readonly>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center"
                                        name="unit[{{ $parameter->id }}]" value="{{ $parameter->unit ?? '' }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center"
                                        name="method[{{ $parameter->id }}]" value="{{ $parameter->method ?? '' }}"
                                        readonly>
                                </td>
                                <td>
                                    <div class="button-group">
                                        <button class="btn btn-info btn-sm mt-1 custom-button custom-blue" type="submit"
                                            name="action" value="save_parameter">Save</button>
                                        <button type="button"
                                            class="btn btn-outline-info btn-sm mt-1 custom-button hide-parameter"
                                            data-parameter-id="{{ $parameter->id }}">
                                            Hide
                                        </button>
                                    </div>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </table>
                    <div class="card-footer text-end">
                        <button id="btn-undo" class="btn btn-warning me-1" style="display: none;">Undo</button>
                        <!-- <button class="btn btn-primary me-1" type="submit">Save</button> -->
                        <a href="{{ route('result.list_result',$institute->id) }}">
                            <span class="btn btn-outline-secondary">Back</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" id="mainForm" action="{{ route('result.stationary_stack.add', $instituteSubject->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    @php
                    $fieldCondition = \App\Models\FieldCondition::where('institute_subject_id',
                    $instituteSubject->id)->first();
                    @endphp
                    <h4 class="mb-3">Environmental Condition</h4>
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
                        <div class="col-lg-6 col-md-6 field-condition" id="velocity">
                            <label class="form-label">Velocity</label>
                            <input type="text" class="form-control" name="velocity" placeholder="Input Velocity"
                                value="{{ old('velocity', $fieldCondition->velocity ?? '') }}">
                        </div>
                    </div>

                    <hr style="display: block; color: #000;height: 1px;width: 100%;margin: 1rem 0;">

                    <label class="form-label d-block"><i>Do you want to give this sample a logo?</i></label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="showLogoYes" name="show_logo" value="1"
                            {{ old('show_logo', $samplingData->show_logo ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showLogoYes"><b>Yes</b></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="showLogoNo" name="show_logo" value="0"
                            {{ old('show_logo', $samplingData->show_logo ?? false) ? '' : 'checked' }}>
                        <label class="form-check-label" for="showLogoNo"><b>No</b></label>
                    </div>
                    <hr style="display: block; color: #000;height: 1px;width: 100%;margin: 10urem 0;">
                    <div class="card-footer text-end">
                        <button class="btn btn-primary me-2" type="submit" name="action" value="save_all"
                            onclick="confirmSubmit(event)">Save
                            All</button>
                        <input type="hidden" name="action" id="save_all" value="save_all">
                        <a href="{{ route('result.list_result', $institute->id) }}"
                            class="btn btn-outline-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function () {
        const selectElement = document.querySelector('#is_required');
        selectElement.addEventListener('change', (event) => {
            selectElement.value = selectElement.checked ? 1 : 0;
            // alert(selectElement.value);
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#date_range').daterangepicker({
            timePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let regulationId = document.body.getAttribute(
            "data-regulation-id"); // Ambil regulation_id dari atribut di body
        let storedHiddenParameters = JSON.parse(localStorage.getItem("hidden_parameters")) || {};
        let hiddenParameters = storedHiddenParameters[regulationId] ||
    []; // Ambil parameter tersembunyi hanya untuk regulation saat ini
        let undoButton = document.getElementById("btn-undo");

        // Tampilkan tombol Undo jika ada parameter yang disembunyikan
        undoButton.style.display = hiddenParameters.length > 0 ? "inline-block" : "none";

        // Sembunyikan parameter yang ada di localStorage untuk regulation saat ini
        hiddenParameters.forEach(parameterId => {
            document.querySelectorAll(`[data-parameter-id="${parameterId}"]`).forEach(element => {
                element.closest("tr").style.display = "none";
            });
        });

        // Event listener untuk tombol hide
        document.querySelectorAll(".hide-parameter").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                event.stopPropagation();

                let parameterId = this.getAttribute("data-parameter-id");

                // Simpan posisi scroll sebelum meng-hide
                let scrollPosition = window.scrollY;
                localStorage.setItem("scroll_position", scrollPosition);

                // Pastikan hidden_parameters hanya untuk regulation saat ini
                if (!hiddenParameters.includes(parameterId)) {
                    hiddenParameters.push(parameterId);
                    storedHiddenParameters[regulationId] = hiddenParameters;
                    localStorage.setItem("hidden_parameters", JSON.stringify(
                        storedHiddenParameters));
                }

                // Sembunyikan baris tanpa refresh
                this.closest("tr").style.display = "none";

                // Tampilkan tombol Undo
                undoButton.style.display = "inline-block";

                // Kembalikan posisi scroll agar tidak naik ke atas
                window.scrollTo(0, scrollPosition);
            });
        });

        // Event listener untuk tombol undo
        undoButton.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (hiddenParameters.length > 0) {
                let lastHiddenParameter = hiddenParameters
                    .pop(); // Ambil parameter terakhir yang di-hide
                storedHiddenParameters[regulationId] = hiddenParameters;
                localStorage.setItem("hidden_parameters", JSON.stringify(storedHiddenParameters));

                // Munculkan kembali baris yang terakhir di-hide
                document.querySelectorAll(`[data-parameter-id="${lastHiddenParameter}"]`).forEach(
                    element => {
                        element.closest("tr").style.display = "";
                    });

                // Sembunyikan tombol Undo jika tidak ada parameter yang di-hide
                if (hiddenParameters.length === 0) {
                    undoButton.style.display = "none";
                }

                // Ambil posisi scroll terakhir dan atur kembali
                let scrollPosition = localStorage.getItem("scroll_position");
                if (scrollPosition) {
                    window.scrollTo(0, scrollPosition);
                }
            }
        });

        // Reset hidden parameters jika regulation_id berubah
        document.body.setAttribute("data-regulation-id", regulationId);
    });

</script>
@endsection
