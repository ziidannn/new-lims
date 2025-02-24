@extends('layouts.master')
@section('content')
@section('title', 'Add Resume Description')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
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
    <form class="card" action="{{ route('resume.add_sampling', $data->id) }}" method="POST">
        @csrf
        <div class="col-xl-12">
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <th><b>Sample No.</b></th>
                            <th><b>Sampling Location</b></th>
                            <th><b>Sample Description</b></th>
                            <th><b>Date & Time </b></th>
                            <th><b>Sampling Method</b></th>
                            <th><b>Date Received</b></th>
                            <th><b>ITD</b></th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary me-1" type="submit">Save</button>
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
    </form>
</div>

<br>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <form class="card" action="{{ route('resume.add_sampling', $data->id) }}" method="POST">
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
                            @foreach ($description as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <input type="hidden" name="sample_description_id[{{ $item->id }}]" value="1">
                                    <td>{{ $item->name_parameter }}</td>
                                    <td>{{ $item->sampling_time }}</td>
                                    <td>
                                        <input type="text" name="testing_result[{{ $item->id }}]"
                                            class="form-control" value="{{ $item->testing_result }}">
                                    </td>
                                    <td>{{ $item->regulation }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->method }}</td>
                                </tr>
                            @endforeach
                    </table>
                    <!-- <table class="table table-bordered">
                            <tr>
                                <td colspan="3">
                                    <label>
                                        <b>Ambient Environmental Condition</b>
                                    </label>
                                    <br>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Coordinate :</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Coordinate" value="{{ old('') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Temperature:</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Temperature" value="{{ old('') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Pressure :</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Pressure" value="{{ old('') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Humidity :</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Humidity" value="{{ old('') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Wind Speed :</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Wind Speed" value="{{ old('') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Wind Direction :</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Wind Direction" value="{{ old('') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="basicDate">Weather :</label>
                                        <input type="text" class="form-control" maxlength="120" name=""
                                            placeholder="Input Weather" value="{{ old('') }}">
                                    </div>
                    </div>
                                </td>
                            </tr>
                        </table> -->
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary me-1" type="submit">Save</button>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    $(document).ready(function () {
        const selectElement = document.querySelector('#is_required');
        selectElement.addEventListener('change', (event) => {
            selectElement.value = selectElement.checked ? 1 : 0;
            // alert(selectElement.value);
        });
    });

</script>
@endsection
