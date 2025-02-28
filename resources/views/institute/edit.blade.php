@extends('layouts.master')
@section('title', 'Edit Institute')
@section('content')

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
<script>
    $(document).ready(function () {
        $('#subject_id').select2({
            placeholder: "Select Sampling Description",
            allowClear: true
        });
    });

</script>
@endsection
