@extends('layouts.master')
@section('content')
@section('title', 'Add Resume')

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
    <form class="card" action="{{ route('resume.add_sample', $institute->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-header">
                <h4 class="card-title mb-0">@yield('title')
                    @php
                    $sampleDescriptions = \App\Models\InstituteSampleDescription::where('institute_id', $institute->id)
                    ->pluck('sample_description_id')
                    ->toArray();
                    $sampleNames = \App\Models\SampleDescription::whereIn('id', $sampleDescriptions)
                    ->pluck('name', 'id')
                    ->toArray();
                    $selectedSampleId = reset($sampleDescriptions); // Get the first ID from the list
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
                                <th><b>Sample No.</b></th>
                                <th><b>Sampling Location</b></th>
                                <th><b>Sample Description</b></th>
                                <th><b>Date</b></th>
                                <th><b>Time</b></th>
                                <th><b>Sampling Method</b></th>
                                <th><b>Date Received</b></th>
                                <th><b>ITD</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($samplings as $sampling)
                            <tr>
                                <td><textarea class="form-control w-100" name="no_sample"
                                        rows="2">{{ $sampling->no_sample }}</textarea></td>
                                <td><textarea class="form-control w-100" name="sampling_location"
                                        rows="2">{{ $sampling->sampling_location }}</textarea></td>
                                <td>
                                    <input type="hidden" name="sample_description_id" value="{{ $selectedSampleId }}">
                                    <textarea class="form-control w-100" rows="3"
                                        readonly>{{ $selectedSampleName }}</textarea>
                                </td>
                                <td><input type="date" class="form-control w-100" name="date"
                                        value="{{ $sampling->date }}"></td>
                                <td><input type="time" class="form-control w-100 me-2" name="time"
                                        value="{{ $sampling->time }}"></td>
                                <td><textarea class="form-control w-100" name="method" rows="2"
                                        readonly>{{ $sampling->method }}</textarea></td>
                                <td><input type="date" class="form-control w-100" name="date_received"
                                        value="{{ $sampling->date_received }}"></td>
                                <td>
                                    <input type="date" class="form-control w-100 me-2" name="itd_start"
                                        value="{{ $sampling->itd_start }}">
                                    <span class="mx-2">to</span>
                                    <input type="date" class="form-control w-100" name="itd_end"
                                        value="{{ $sampling->itd_end }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end" style="margin-top: -30px;">
                <button class="btn btn-primary me-1" type="submit">Save</button>
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
    </form>
</div>

<br>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('resume.add_resume', $institute->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <th><b>No</b></th>
                            <th><b>Parameters</b></th>
                            <th><b>Sampling Time</b></th>
                            <th><b>Testing Result</b></th>
                            <th><b>Regulatory Standard</b></th>
                            <th><b>Unit</b></th>
                            <th><b>Methods</b></th>
                        </tr>
                        @foreach ($resumes as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <input type="hidden" name="sample_description_id[{{ $item->id }}]" value="1">
                            <td>
                                @php
                                    $parameter = \App\Models\Parameter::where('id', $item->parameter_id)
                                        ->whereHas('regulation', function($query) use ($selectedSampleId) {
                                            $query->where('sample_description_id', $selectedSampleId);
                                        })
                                        ->first();
                                @endphp
                                {{ $parameter ? $parameter->name : 'N/A' }}
                            </td>
                            <td>
                                @foreach(explode(',', $item->sampling_time) as $time)
                                    <div>{{ $time }}</div>
                                @endforeach
                            </td></td>
                            <td>
                                <input type="text" name="testing_result[{{ $item->id }}]" class="form-control"
                                    value="{{ $item->testing_result }}">
                            </td>
                            <td>
                                @foreach(explode(',', $item->regulation) as $regulation)
                                    <div>{{ $regulation }}</div>
                                @endforeach
                            </td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->method }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="card-footer text-end" style="margin-top: -10px;">
                    <button class="btn btn-primary me-1" type="submit">Save</button>
                    <a href="{{ url()->previous() }}">
                        <span class="btn btn-outline-secondary">Back</span>
                    </a>
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
