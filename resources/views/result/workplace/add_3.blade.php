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
<div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_1', $instituteSubject->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 1</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_2', $instituteSubject->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 2</i></b></a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('result.workplace.add_3',$instituteSubject->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 3</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_4', $instituteSubject->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 4</i></b></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_5',$instituteSubject->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 5</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_6', $instituteSubject->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 6</i></b></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_7',$instituteSubject->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 7</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_8', $instituteSubject->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 8</i></b></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_9',$instituteSubject->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 9</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.workplace.add_10', $instituteSubject->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 10</i></b></a></li>
    </ul>
</div>
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
    <form class="card" action="{{ route('result.add_sample_3', $institute->id) }}" method="POST">
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
                                <td><input type="text" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $institute->no_coa ?? '') }}" readonly>
                                    <input type="number" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $sampleNames->no_sample ?? '') }}">
                                </td>
                                <td><input type="text" class="form-control text-center" name="sampling_location"
                                        value="{{ old('sampling_location', $sampleNames->sampling_location ?? '') }}">
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
                                        value="{{ old('sampling_time', $sampleNames->sampling_time ?? '') }}"></td>
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
                <button class="btn btn-primary me-1" type="submit">Save</button>
                <a href="{{ route('result.list_result',$institute->id) }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
    </form>
</div>

<br>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('result.workplace.add_3', $institute->id) }}" method="POST">
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
                        return $parameter->subject_id == 2 || $parameter->code_subject == '02' ||
                        $parameter->subjects->name == 'Workplace Air';
                        }) as $parameter)
                        <tr>
                            <form class="card" action="{{ route('result.workplace.add_3', $institute->id) }}"
                                method="POST">
                                @csrf
                                <td class="text-center">{{ $parameterNumber++ }}</td>
                                <td>
                                    <input type="hidden" name="parameter_id[]" value="{{ $parameter->id }}">
                                    <input type="text" class="form-control text-center" value="{{ $parameter->name }}"
                                        readonly>
                                </td>
                                <td>
                                    @php
                                    $regulationStandard = $samplingTimeRegulations->where('parameter_id',
                                    $parameter->id)->first()->regulationStandards ?? null;
                                    $resultKey = $parameter->id . '-' . ($regulationStandard->id ?? 'null');
                                    $testingResult = $results[$resultKey]->testing_result ?? '';
                                    @endphp
                                    <input type="text" class="form-control text-center testing-result"
                                        name="testing_result[{{ $parameter->id }}]"
                                        value="{{ old('testing_result.' . $parameter->id, $testingResult) }}" required>
                                </td>
                                <td>
                                    @if ($regulationStandard)
                                    <input type="hidden" name="regulation_standard_id[{{ $parameter->id }}]"
                                        value="{{ $regulationStandard->id }}">
                                    <input type="text" class="form-control text-center"
                                        value="{{ $regulationStandard->title }}" readonly>
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
                                            name="save">Save</button>
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
