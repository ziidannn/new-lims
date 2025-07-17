@extends('layouts.master')
@section('title', 'Analysis Result')

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
</style>
@endsection

@section('content')
{{-- Gunakan SATU form utama untuk semua input --}}
<form class="card" action="{{ route('result.surface_water.add', $instituteSubject->id) }}" method="POST">
    @csrf
    <div class="card-header">
        <h4 class="card-title mb-1">
            @yield('title') - <span class="fw-bold">{{ $subject->name ?? 'N/A' }}</span>
        </h4>
        @if ($regulations->isNotEmpty())
            @foreach ($regulations as $regulation)
                <i class="fw-bold" style="font-size: 1.1rem; color: darkred;">{{ $regulation->title ?? 'N/A' }}</i>
            @endforeach
        @endif
    </div>

    <div class="card-body">
        {{-- BAGIAN 1: HEADER INFORMASI SAMPEL (Sesuai Template Word) --}}
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
                         <input type="hidden" name="institute_subject_id" value="{{ $instituteSubject->id }}">
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

        {{-- BAGIAN 2: TABEL HASIL ANALISIS (Sesuai Template Word) --}}
        <div class="table-responsive">
            <table class="table table-bordered mt-3" id="parameterTable">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Parameters</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Testing Result</th>
                        <th colspan="4">Regulatory Standard</th>
                        <th rowspan="2">Methods</th>
                    </tr>
                    <tr>
                        <th>I</th>
                        <th>II</th>
                        <th>III</th>
                        <th>IV</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop untuk setiap grup parameter --}}
                    @foreach ($groupedParameters as $groupName => $parameters)
                        @if ($parameters->isNotEmpty())
                            <tr class="parameter-group-header">
                                <th colspan="9">{{ $groupName }}</th>
                            </tr>
                            @php $parameterNumber = 1; @endphp
                            @foreach ($parameters as $parameter)
                                @php $result = $results->get($parameter->id); @endphp
                                <tr>
                                    <td>{{ $parameterNumber++ }}</td>
                                    <td class="text-start">
                                        {{ $parameter->name }}
                                        <input type="hidden" name="results[{{ $parameter->id }}][parameter_id]" value="{{ $parameter->id }}">
                                    </td>
                                    <td>{{ $parameter->unit }}</td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-center" name="results[{{ $parameter->id }}][testing_result]" value="{{ old('results.'.$parameter->id.'.testing_result', $result->testing_result ?? '') }}">
                                    </td>

                                    {{-- Menampilkan Baku Mutu Kelas I-IV --}}
                                    @php
                                        $standards = $regStandardsByParameter[$parameter->id] ?? null;
                                    @endphp
                                    <td>{{ $standards['I'] ?? '-' }}</td>
                                    <td>{{ $standards['II'] ?? '-' }}</td>
                                    <td>{{ $standards['III'] ?? '-' }}</td>
                                    <td>{{ $standards['IV'] ?? '-' }}</td>

                                    <td>{{ $parameter->method }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer text-end">
        <a href="{{ route('result.list_result', $institute->id) }}" class="btn btn-outline-secondary">Back</a>
        <button class="btn btn-primary" type="submit">Save All Results</button>
    </div>
</form>
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
