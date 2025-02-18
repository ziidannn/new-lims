@extends('layouts.master')
@section('content')
@section('title', 'New Sampling')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .checkbox label::before {
        border: 1px solid #333;
    }

</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection
@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
        <div class="col-xl-12">
            <form class="card" method="POST" action="">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">Add @yield('title')</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a>
                            </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">No Sample<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('no_sample')  is-invalid @enderror"
                                    maxlength="120" name="no_sample" placeholder="Input Nomor Sample"
                                    value="{{ old('no_sample') }}">
                                @error('no_sample')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sampling Location<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('sampling_location') is-invalid @enderror"
                                    maxlength="120" name="sampling_location" placeholder="Input Sampling Location"
                                    value="{{ old('sampling_location') }}">
                                @error('sampling_location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sampling Description<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <select
                                    class="form-select @error('sample_description_id') is-invalid @enderror input-sm select2-modal"
                                    name="sample_description_id" id="sample_description_id"
                                    placeholder="Input Sampling Description">
                                    @foreach($description as $p)
                                    <option value="{{ $p->id }}"
                                        {{ ($p->id==old('sample_description_id') ? "selected": "") }}>
                                        {{ $p->id }} - {{ $p->name }}</option>
                                    @endforeach
                                </select>
                                @error('sample_description_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sampling Date<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    maxlength="120" name="date" placeholder="Input Sampling Date"
                                    value="{{ old('date') }}">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sampling Time<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="time" class="form-control @error('time')  is-invalid @enderror"
                                    maxlength="120" name="time" placeholder="Input Sampling Time"
                                    value="{{ old('time') }}">
                                @error('time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sampling Method<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('method')  is-invalid @enderror"
                                    maxlength="120" name="method" placeholder="Input Sampling Method"
                                    value="{{ old('method') }}">
                                @error('method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Date Received<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('date_received')  is-invalid @enderror"
                                    maxlength="120" name="date_received" placeholder="Input Date Received"
                                    value="{{ old('date_received') }}">
                                @error('date_received')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Interval Testing Date Start<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('itd_start')  is-invalid @enderror"
                                    maxlength="120" name="itd_start" placeholder="Input The New Criteria"
                                    value="{{ old('itd_start') }}">
                                @error('itd_start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Interval Testing Date End<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('itd_end')  is-invalid @enderror"
                                    maxlength="120" name="itd_end" placeholder="Input The New Criteria"
                                    value="{{ old('itd_end') }}">
                                @error('itd_end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary me-1" type="submit">Create</button>
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
