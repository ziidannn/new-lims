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

    .custom-blue {
        background-color: rgb(43, 92, 177);
        /* Biru soft */
        border-color: rgb(201, 214, 236);
        /* Border sedikit lebih gelap */
        color: white;
    }

    .custom-blue:hover {
        background-color: #365A9E;
        /* Warna lebih gelap saat hover */
    }

    .button-group {
        display: flex;
        flex-direction: column;
        /* Susun tombol secara vertikal */
        gap: 2px;
        /* Jarak antar tombol */
        width: fit-content;
        /* Ukuran tombol menyesuaikan teks terpanjang */
    }

    .custom-button {
        min-width: 50px;
        /* Lebar minimum yang sama untuk semua tombol */
        text-align: center;
    }

</style>
@endsection

@section('breadcrumb-title')
@endsection
@section('content')
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
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('result.add_sample', $institute->id) }}" method="POST">
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
                    style="font-size: 1.08rem; color: darkred;">{{ $regulation->title ?? 'No Name Available' }}</i>
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
                                <td>
                                    <input type="text" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $institute->no_coa ?? '') }}" readonly>
                                    <input type="number" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $samplings->no_sample ?? '') }}">
                                </td>
                                <td><input type="text" class="form-control text-center" name="sampling_location"
                                        value="(See Table)">
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
                                        value="(See Table)"></td>
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
    <form class="card" action="{{ route('result.heat_stress.add', $institute->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
                <div class="row">
                    <table class="table table-bordered" id="locationTable">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center"><b>No.</b></th>
                                <th rowspan="2" class="text-center"><b>Sampling Location</b></th>
                                <th rowspan="2" class="text-center"><b>Time</b></th>
                                <th rowspan="2" class="text-center"><b>Humidity (%)</b></th>
                                <th colspan="3" class="text-center"><b>Temperature(°C)</b></th>
                                <th rowspan="2" class="text-center"><b>WBGT INDEX</b></th>
                                <th rowspan="2" class="text-center"><b>Methods</b></th>
                                <th rowspan="2" class="text-center"><b>Action</b></th>
                            </tr>
                            <tr>
                                <th class="text-center"><b>Wet</b></th>
                                <th class="text-center"><b>Dew</b></th>
                                <th class="text-center"><b>Globe</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
    $count = count($existingHeatStress);
@endphp

@for ($i = 0; $i < ($count > 0 ? $count : 1); $i++)
<tr>
    <td class="text-center">{{ $i + 1 }}</td>
    <td>
        <input type="text" class="form-control text-center" name="sampling_location[]"
            value="{{ old('sampling_location.' . $i, $existingHeatStress[$i]->sampling_location ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="time[]"
            value="{{ old('time.' . $i, $existingHeatStress[$i]->time ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="humidity[]"
            value="{{ old('humidity.' . $i, $existingHeatStress[$i]->humidity ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="wet[]"
            value="{{ old('wet.' . $i, $existingHeatStress[$i]->wet ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="dew[]"
            value="{{ old('dew.' . $i, $existingHeatStress[$i]->dew ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="globe[]"
            value="{{ old('globe.' . $i, $existingHeatStress[$i]->globe ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="wbgt_index[]"
            value="{{ old('wbgt_index.' . $i, $existingHeatStress[$i]->wbgt_index ?? '') }}">
    </td>
    <td>
        <input type="text" class="form-control text-center" name="methods[]"
            value="{{ old('methods.' . $i, $existingHeatStress[$i]->methods ?? '') }}">
    </td>
    <td>
        <button class="btn btn-info btn-sm mt-1 custom-button custom-blue" type="submit"
            name="save">Save</button>
        <button type="button" class="btn btn-danger btn-sm mt-1 remove-row">Remove</button>
    </td>
</tr>
@endfor

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end" style="margin-top: -30px;">
                <button type="button" class="btn btn-success" id="addLocation">Add Location</button>
                <a href="{{ route('result.list_result',$institute->id) }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
    </form>
</div>

<br>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
                <div class="row">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th rowspan="4" style="vertical-align: middle;"><b>Hourly Working Time Setting</b></th>
                            </tr>
                            <tr>
                                <th colspan="4"><b>WBGT INDEX</b></th>
                            </tr>
                            <tr>
                                <th colspan="4"><b>Workload</b></th>
                            </tr>
                            <tr>
                                <th><b>Light</b></th>
                                <th><b>Medium</b></th>
                                <th><b>Heavy</b></th>
                                <th><b>Very Heavy</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>75% - 100%</td>
                                <td>31.0</td>
                                <td>28.0</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>50% - 75%</td>
                                <td>31.0</td>
                                <td>29.0</td>
                                <td>27.5</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>25% - 50%</td>
                                <td>32.0</td>
                                <td>30.0</td>
                                <td>29.0</td>
                                <td>28.0</td>
                            </tr>
                            <tr>
                                <td>0% - 25%</td>
                                <td>32.2</td>
                                <td>31.1</td>
                                <td>30.5</td>
                                <td>30.0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
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

    function confirmSubmit(e) {
        e.preventDefault(); // Stop form from submitting immediately

        swal({
            title: "Are you sure?",
            text: "Please make sure all data is correct and complete before submitting.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willSubmit) => {
            if (willSubmit) {
                swal("Submitting...", {
                    icon: "info",
                    buttons: false,
                    timer: 1000,
                }).then(() => {
                    // Submit the form manually
                    document.getElementById("mainForm").submit();
                });
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
    function getLastRowNumber() {
        let lastNumber = 0;
        $('#locationTable tbody tr').each(function () {
            const num = parseInt($(this).find('td:first').text());
            if (!isNaN(num) && num > lastNumber) {
                lastNumber = num;
            }
        });
        return lastNumber;
    }

    $('#addLocation').click(function () {
        let newRowNumber = getLastRowNumber() + 1;

        var newRow = `
            <tr>
                <td>${newRowNumber}</td>
                <td>
                    <input type="text" class="form-control text-center" name="sampling_location[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="time[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="humidity[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="wet[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="dew[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="globe[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="wbgt_index[]" value="">
                </td>
                <td>
                    <input type="text" class="form-control text-center" name="methods[]" value="">
                </td>
                <td>
                    <button class="btn btn-info btn-sm mt-1 custom-button custom-blue" type="submit" name="save">Save</button>
                    <button type="button" class="btn btn-danger btn-sm mt-1 remove-row">Remove</button>
                </td>
            </tr>`;
        $('#locationTable tbody').append(newRow);
    });

    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();

        // Re-number semua baris ulang di locationTable
        let rowNumber = 1;
        $('#locationTable tbody tr').each(function () {
            $(this).find('td:first').text(rowNumber++);
        });
    });
});
</script>
@endsection
