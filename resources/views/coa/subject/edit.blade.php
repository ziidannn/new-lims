@extends('layouts.master')
@section('content')
@section('title', 'Edit Subject')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<style>

</style>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
        <div class="col-md-12">
            @if(session('msg'))
            <div class="alert alert-primary alert-dismissible" role="alert">
                {{session('msg')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card mb-4">
                <h5 class="card-header">Edit Regulation</h5>
                <hr class="my-0">
                <div class="card-body">
                    <form action="{{ route('coa.regulation.edit', $data->id) }}" method="POST">
                            @csrf
                            <div class="row">
                            <div class="form-group mb-3">
                                <label for="subject_id" class="form-label"><b>Select Criteria</b><i
                                        class="text-danger">*</i></label>
                                <select
                                    class="form-select digits select2 @error('subject_id') is-invalid @enderror"
                                    name="subject_id" id="subject_id" data-placeholder="Select">
                                    <option value="" selected disabled>Select Subjects</option>
                                    @foreach($subjects as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $data->subject_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->id }} - {{$c->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="title" class="col-form-label">Title<i class="text-danger">*</i></label>
                                    <textarea class="form-control" maxlength="175"
                                        placeholder="Note: Maximum 175 char...." rows="2" name="title"
                                        id="title">{{ $data->title }}</textarea>
                                </div>
                            </div>
                            <div class="mt-2 text-end">
                                <button type="submit" class="btn btn-primary me-1">Update</button>
                                <a class="btn btn-outline-secondary" href="{{ route('coa.regulation.index') }}">Back</a>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script>
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7
            });
        })(jQuery);
    }, 350);

</script>
@endsection
