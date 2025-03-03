@extends('layouts.master')
@section('title', 'Add Result')

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
                    $instituteSamples = \App\Models\InstituteSubject::where('institute_id', $institute->id)->get();
                    $instituteSamplesIds = $instituteSamples->pluck('id');
                    $samplings = \App\Models\Sampling::whereIn('institute_subject_id', $instituteSamplesIds)->get();
                    $samplingsIds = $samplings->pluck('subject_id');
                    $sampleNames = \App\Models\Subject::whereIn('id', $samplingsIds)
                    ->pluck('name', 'id')
                    ->toArray();
                    $samplingsIdsArray = $samplingsIds->toArray();
                    $selectedSampleId = reset($samplingsIdsArray); // Get the first ID from the list
                    $selectedSampleName = $sampleNames[$selectedSampleId] ?? 'N/A';
                    $regulationIds = \App\Models\Sampling::whereIn('institute_subject_id', $instituteSamplesIds)
                        ->pluck('regulation_id', 'subject_id')
                        ->toArray();
                    @endphp
                    <b><i>{{ $selectedSampleName }}</i></b>
                    <br>
                    <b>Regulation IDs:</b>
                    <ul>
                        @foreach($regulationIds as $subjectId => $regulationId)
                        <li>Subject ID: {{ $subjectId }}, Regulation ID: {{ $regulationId }}</li>
                        @endforeach
                    </ul></ul>
                </h4>
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
                                <td><input type="text" class="form-control text-center" name="no_sample"
                                        value="{{ old('no_sample', $sampling->no_sample ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="sampling_location"
                                        value="{{ old('sampling_location', $sampling->sampling_location ?? '') }}"></td>
                                <td>
                                    <input type="hidden" name="institute_id" value="{{ $institute->id }}">
                                    <input type="hidden" name="institute_subject_id" value="{{ $selectedSampleId }}">
                                    <input type="text" class="form-control text-center" value="{{ $selectedSampleName }}"
                                        readonly>
                                </td>
                                <td><input type="date" class="form-control text-center" name="sampling_date"
                                        value="{{ old('sampling_date', $sampling->sampling_date ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="sampling_time"
                                        value="{{ old('sampling_time', $sampling->sampling_time ?? '') }}"></td>
                                <td><input type="text" class="form-control text-center" name="sampling_method"
                                        value="Grab/24 Hours" readonly></td>
                                <td><input type="date" class="form-control text-center" name="date_received"
                                        value="{{ old('date_received', $sampling->date_received ?? '') }}"></td>
                                <td>
                                    <input type="date" class="form-control text-center" name="itd_start"
                                        value="{{ old('itd_start', $sampling->itd_start ?? '') }}">
                                    <span class="mx-2">to</span>
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
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
    </form>
</div>

<br>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('result.noise', $institute->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center"><b>No</b></th>
                            <th class="text-center"><b>Sampling Location</b></th>
                            <th class="text-center"><b>Noise</b></th>
                            <th class="text-center"><b>Time</b></th>
                            <th class="text-center"><b>Leq</b></th>
                            <th class="text-center"><b>Ls</b></th>
                            <th class="text-center"><b>Lm</b></th>
                            <th class="text-center"><b>Lsm</b></th>
                            <th class="text-center"><b>Regulatory Standard</b></th>
                            <th class="text-center"><b>Unit</b></th>
                            <th class="text-center"><b>Methods</b></th>
                        </tr>
                        @foreach($parameters as $key => $parameter)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <input type="text" class="form-control text-center" name="sampling_location[]"
                                    value="{{ old('sampling_location', $sampling->sampling_location ?? '') }} Upwind">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" value="L1" readonly>
                                <input type="text" class="form-control text-center" value="L2" readonly>
                                <input type="text" class="form-control text-center" value="L3" readonly>
                                <input type="text" class="form-control text-center" value="L4" readonly>
                                <input type="text" class="form-control text-center" value="L5" readonly>
                                <input type="text" class="form-control text-center" value="L6" readonly>
                                <input type="text" class="form-control text-center" value="L7" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="noise[L1][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L2][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L3][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L4][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L5][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L6][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L7][]" value="-" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="leq[L1][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L2][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L3][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L4][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L5][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L6][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L7][]" value="-" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="ls" value="-">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="lm" value="-">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="lsm" value="-">
                            </td>
                            <td>
                                @php
                                    $regulationStandards = $samplingTimeRegulations->where('parameter_id', $parameter->id);
                                @endphp
                                @if ($regulationStandards->isNotEmpty())
                                    @foreach ($regulationStandards as $rs)
                                    <input type="text" class="form-control text-center" name="regulation_standard_id[]" value="{{ $rs->regulationStandards->title }}" readonly>
                                    @endforeach
                                @else
                                    <input type="text" class="form-control text-center" name="regulation_standard_id[]" value="70" readonly>
                                @endif
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="unit[]" value="{{ $parameter->unit ?? '' }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="method[]" value="{{ $parameter->method ?? '' }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $key + 2 }}</td>
                            <td>
                                <input type="text" class="form-control text-center" name="sampling_location[]"
                                    value="{{ old('sampling_location', $sampling->sampling_location ?? '') }} Downwind">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" value="L1" readonly>
                                <input type="text" class="form-control text-center" value="L2" readonly>
                                <input type="text" class="form-control text-center" value="L3" readonly>
                                <input type="text" class="form-control text-center" value="L4" readonly>
                                <input type="text" class="form-control text-center" value="L5" readonly>
                                <input type="text" class="form-control text-center" value="L6" readonly>
                                <input type="text" class="form-control text-center" value="L7" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="noise[L1][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L2][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L3][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L4][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L5][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L6][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="noise[L7][]" value="-" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="leq[L1][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L2][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L3][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L4][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L5][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L6][]" value="-" readonly>
                                <input type="text" class="form-control text-center" name="leq[L7][]" value="-" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="ls" value="-">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="lm" value="-">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="lsm" value="-">
                            </td>
                            <td>
                                @php
                                    $regulationStandards = $samplingTimeRegulations->where('parameter_id', $parameter->id);
                                @endphp
                                @if ($regulationStandards->isNotEmpty())
                                    @foreach ($regulationStandards as $rs)
                                    <input type="text" class="form-control text-center" name="regulation_standard_id[]" value="{{ $rs->regulationStandards->title }}" readonly>
                                    @endforeach
                                @else
                                    <input type="text" class="form-control text-center" name="regulation_standard_id[]" value="70" readonly>
                                @endif
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="unit[]" value="{{ $parameter->unit ?? '' }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="method[]" value="{{ $parameter->method ?? '' }}" readonly>
                            </td>
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
