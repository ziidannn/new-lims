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
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_1',$institute->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 1</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_2', $institute->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 2</i></b></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_3',$institute->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 3</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_4', $institute->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 4</i></b></a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('result.ambient_air.add_5',$institute->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 5</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_6', $institute->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 6</i></b></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_7',$institute->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 7</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_8', $institute->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 8</i></b></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_9',$institute->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 9</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('result.ambient_air.add_10', $institute->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.1rem;">Location - 10</i></b></a></li>
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
    <form class="card" action="{{ route('result.add_sample_5', $institute->id) }}" method="POST">
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><b>Sample No.</b></th>
                                <th class="text-center"><b>Sampling Location</b></th>
                                <th class="text-center"><b>Sample Description</b></th>
                                <th class="text-center"><b>Date</b></th>
                                <th class="text-center"><b>Time</b></th>
                                <th class="text-center"><b>Sampling Method</b></th>
                                <th class="text-center"><b>Date Received</b></th>
                                <th class="text-center"><b>Interval Testing Date</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $samplingData = $sampling->where('no_sample', '05')->where('institute_id', $institute->id)->first();
                                @endphp
                                <td>
                                    <input type="text" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $institute->no_coa ?? '') }}" readonly>
                                    <input type="number" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', '05') }}">
                                </td>
                                <td><input type="text" class="form-control text-center" name="sampling_location"
                                        value="{{ old('sampling_location', $samplingData->sampling_location ?? '') }}"></td>
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
                                        value="{{ old('sampling_time', $samplingData->sampling_time ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="sampling_method"
                                        value="Grab/24 Hours" readonly></td>
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
    @if(session('msg'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form class="card" action="{{ route('result.ambient_air.add_5', $institute->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center"><b>No</b></th>
                            <th class="text-center"><b>Parameters</b></th>
                            <th class="text-center"><b>Sampling Time</b></th>
                            <th class="text-center"><b>Testing Result</b></th>
                            <th class="text-center"><b>Regulatory Standard</b></th>
                            <th class="text-center"><b>Unit</b></th>
                            <th class="text-center"><b>Methods</b></th>
                            <th class="text-center"><b>Action</b></th>
                        </tr>
                        @foreach($parameters as $key => $parameter)
                        <tr>
                            <form class="card" action="{{ route('result.ambient_air.add_5', $institute->id) }}"
                                method="POST">
                                @csrf
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <input type="hidden" name="parameter_id[]" value="{{ $parameter->id }}">
                                    <input type="text" class="form-control text-center" value="{{ $parameter->name }}"
                                        readonly>
                                </td>
                                <td>
                                    @php
                                    $samplingTimes = $samplingTimeRegulations->where('parameter_id', $parameter->id);
                                    @endphp
                                    @foreach ($samplingTimes as $samplingTime)
                                    <input type="hidden" name="sampling_time_id[{{ $parameter->id }}][]"
                                        value="{{ $samplingTime->samplingTime->id }}">
                                    <input type="text" class="form-control text-center"
                                        value="{{ $samplingTime->samplingTime->time }}" readonly>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($samplingTimes as $samplingTime)
                                        @php
                                            $key = "{$parameter->id}-{$samplingTime->samplingTime->id}-{$samplingTime->regulationStandards->id}";
                                            $resultData = $results[$key] ?? null; // Ambil hanya data dari sampling_id yang aktif
                                        @endphp

                                        <input type="text" class="form-control text-center testing-result"
                                            name="testing_result[{{ $parameter->id }}][]"
                                            value="{{ $sampling ? ($resultData ? $resultData->first()->testing_result : '') : '' }}"
                                            required>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($samplingTimes as $samplingTime)
                                    @php
                                    $regulationStandard = $samplingTime->regulationStandards ?? null;
                                    @endphp
                                    @if ($regulationStandard)
                                    <input type="hidden" name="regulation_standard_id[{{ $parameter->id }}][]"
                                        value="{{ $regulationStandard->id }}">
                                    <input type="text" class="form-control text-center"
                                        value="{{ $regulationStandard->title }}" readonly>
                                    @endif
                                    @endforeach
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
                    <div class="card-footer d-flex justify-content-between align-items-end">
                        <div class="d-flex">
                            <button id="btn-undo" class="btn btn-warning me-1" style="display: none;">Undo</button>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary me-2" type="button" onclick="confirmSubmit()">Save All</button>
                            <a href="{{ route('result.list_result', $institute->id) }}" class="btn btn-outline-secondary">Back</a>
                        </div>
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

    $(document).ready(function () {
        $('#date_range').daterangepicker({
            timePicker: true,
            locale: {
                format: 'YYYY-MM-DD HH:mm'
            }
        });
    });

    function confirmSubmit() {
    swal({
        title: "Are you sure?",
        text: "Please make sure all data is correct and complete before submitting.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willSubmit) => {
        if (willSubmit) {
            swal("Submitting...", {
                icon: "info",
                buttons: false,
                timer: 300, // Delay 0.3 detik sebelum redirect
            }).then(() => {
                window.location.href = "{{ route('result.list_result', $institute->id) }}?success=1";
            });
        }
    });
}
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let regulationId = document.body.getAttribute("data-regulation-id"); // Ambil regulation_id dari atribut di body
        let storedHiddenParameters = JSON.parse(localStorage.getItem("hidden_parameters")) || {};
        let hiddenParameters = storedHiddenParameters[regulationId] || []; // Ambil parameter tersembunyi hanya untuk regulation saat ini
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
                    localStorage.setItem("hidden_parameters", JSON.stringify(storedHiddenParameters));
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
                let lastHiddenParameter = hiddenParameters.pop(); // Ambil parameter terakhir yang di-hide
                storedHiddenParameters[regulationId] = hiddenParameters;
                localStorage.setItem("hidden_parameters", JSON.stringify(storedHiddenParameters));

                // Munculkan kembali baris yang terakhir di-hide
                document.querySelectorAll(`[data-parameter-id="${lastHiddenParameter}"]`).forEach(element => {
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
