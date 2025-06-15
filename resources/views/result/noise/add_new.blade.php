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

@section('content')
<div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link" href="{{ route('result.noise.add', $instituteSubject->id) }}">
                <i class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 1</i></b></a></li></a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('result.noise.add_new', $instituteSubject->id) }}"><i
                    class="bx bx-current-location me-1"></i>
                <b><i style="font-size: 1.13rem;">LOC - 2</i></b></a></li>
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
    <form class="card" action="{{ route('result.noise.noise_sample', $instituteSubject->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-header">
                <h4 class="card-title mb-0">@yield('title')
                    @if ($subject)
                        <i class="fw-bold">{{ $subject->name }}</i>
                    @else
                        <i class="fw-bold">No Subject Name Available</i>
                    @endif
                </h4>

                @if ($regulations && $regulations->isNotEmpty())
                    @foreach ($regulations as $regulation)
                        <div>
                            <i class="fw-bold" style="font-size: 1.1rem; color: darkred;">
                                {{ $regulation->title ?? 'No Regulation Title Available' }}
                            </i>
                        </div>
                    @endforeach
                @else
                    <i class="text-muted">No Regulations Found</i>
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
                                <td><input type="text" class="form-control text-center me-1" name="no_sample"
                                        value="{{ old('no_sample', $institute->no_coa ?? '') }}" readonly>
                                    <input type="number" class="form-control text-center" name="no_sample"
                                        style="width: 60px;"
                                        value="{{ old('no_sample', $samplings->no_sample ?? '') }}">
                                </td>
                                <td><input type="text" class="form-control text-center fst-italic"
                                        name="sampling_location" value="{{ old('sampling_location') }} See Table"
                                        readonly></td>
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
                                        value="{{ old('sampling_time', $samplings->sampling_time ?? '') }}">
                                </td>
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
                <a href="{{ route('result.list_result', $institute->id) }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
    </form>
</div>

<br>
{{-- ===================== TEMPLATE 2 (032, 034) ===================== --}}
@if (!empty(array_intersect($regulationCodes, ['032', '034'])))
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('result.noise.add_new', $institute->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered" id="locationTable2">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Sampling Location</th>
                                <th class="text-center">Testing Result</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Regulatory Standard</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Methods</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><input type="text" class="form-control text-center" name="location[]" value="{{ old("location.$index", $result->location ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="testing_result[]" value="{{ old("testing_result.$index", $result->testing_result ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="time[]" value="{{ old("time.$index", $result->time ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="regulatory_standard[]" value="{{ old("regulatory_standard.$index", $result->regulatory_standard ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="unit[]" value="{{ $parameters[0]->unit ?? '' }}" readonly></td>
                                <td><input type="text" class="form-control text-center" name="method[]" value="{{ $parameters[0]->method ?? '' }}" readonly></td>
                                <td>
                                    <button class="btn btn-info btn-sm mt-1 custom-blue" type="submit">Save</button>
                                    <button type="button" class="btn btn-danger btn-sm mt-1 remove-row">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-primary" id="addLocation2">Add Location</button>
                    <a href="{{ route('result.list_result', $institute->id) }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endif

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
                format: 'YYYY-MM-DD HH:mm'
            }
        });
    });
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
                <td><input type="text" class="form-control text-center" name="location[]"></td>
                <td><input type="text" class="form-control text-center" name="testing_result[]"></td>
                <td><input type="text" class="form-control text-center" name="time[]"></td>
                <td><input type="text" class="form-control text-center" name="regulatory_standard[]"></td>
                <td><input type="text" class="form-control text-center" name="unit[]" value="{{ $parameters[0]->unit }}" readonly></td>
                <td><input type="text" class="form-control text-center" name="method[]" value="{{ $parameters[0]->method }}" readonly></td>
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
