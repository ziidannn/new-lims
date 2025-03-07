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
    <form class="card" action="{{ route('result.add_sample', $institute->id) }}" method="POST">
        @php
        $sampling = \App\Models\Sampling::where('institute_id', $institute->id)->first();
        @endphp
        @csrf
        <div class="col-xl-12">
            <div class="card-header">
                <h4 class="card-title mb-0">@yield('title')
                    @php
                    $subjects = \App\Models\InstituteSubject::where('institute_id', $institute->id)
                    ->pluck('subject_id')
                    ->toArray();
                    $sampleNames = \App\Models\Subject::whereIn('id', $subjects)
                    ->pluck('name', 'id')
                    ->toArray();
                    $selectedSampleId = reset($subjects); // Get the first ID from the list
                    $selectedSampleName = $sampleNames[$selectedSampleId] ?? 'N/A';
                    @endphp
                    <b><i>{{ $selectedSampleName }}</i>
                    </b></h4>
            </div>
            <div class="card-body">
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                    <hr>
                </div>
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><b>Sample No.</b></th>
                                <th class="text-center"><b>Samp Location</b></th>
                                <th class="text-center"><b>Sample Desc</b></th>
                                <th class="text-center"><b>Samp Date</b></th>
                                <th class="text-center"><b>Samp Time</b></th>
                                <th class="text-center"><b>Samp Method</b></th>
                                <th class="text-center"><b>Received</b></th>
                                <th class="text-center"><b>Int Test Date</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $institute->no_coa ?? '') }}"></td>

                                <td><input type="text" class="form-control text-center" name="sampling_location"
                                        value="{{ old('sampling_location', $sampling->sampling_location ?? '') }}"></td>

                                <td>
                                    <input type="hidden" name="institute_subject_id"
                                        value="{{ old('institute_subject_id', $selectedSampleId) }}">
                                    <input type="text" class="form-control text-center"
                                        style="background-color:rgb(248, 246, 246);"
                                        value="{{ old('institute_subject_id', $selectedSampleName) }}" readonly>
                                </td>

                                <td><input type="date" class="form-control text-center" name="sampling_date"
                                        value="{{ old('sampling_date', $sampling->sampling_date ?? '') }}"></td>

                                <td><input type="text" class="form-control" name="sampling_time"
                                        value="{{ old('sampling_time', $sampling->sampling_time ?? '') }}"></td>

                                <td><input type="text" class="form-control text-center"
                                        style="background-color:rgb(248, 246, 246);" name="sampling_method"
                                        value="Grab/24 Hours" readonly></td>

                                <td><input type="date" class="form-control text-center" name="date_received"
                                        value="{{ old('date_received', $sampling->date_received ?? '') }}"></td>
                                <td>
                                    <input type="date" class="form-control text-center" name="itd_start"
                                        value="{{ old('itd_start', $sampling->itd_start ?? '') }}">
                                    <span>
                                        <center><b>to</b></center>
                                    </span>
                                    <input type="date" class="form-control text-center" name="itd_end"
                                        value="{{ old('itd_end', $sampling->itd_end ?? '') }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end" style="margin-top: -30px;">
                <button class="btn btn-primary me-1" type="submit">Save</button>
                <!-- <a href="{{ url()->previous() }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a> -->
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
    <form class="card" action="{{ route('result.ambient_air', $institute->id) }}" method="POST">
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
                            <form class="card" action="{{ route('result.ambient_air', $institute->id) }}" method="POST">
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
                                    <input type="text" class="form-control text-center testing-result"
                                        name="testing_result[{{ $parameter->id }}][]" value="{{ old('testing_result', ) }}" required>
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
                                    <button class="btn btn-success btn-sm mt-2" type="submit" name="save">Save</button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </table>
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
                format: 'YYYY-MM-DD HH:mm'
            }
        });
    });

</script>
@endsection
