@extends('layouts.master')
@section('title', 'Create Resume')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('style')
<style>
    .img {
        height: 100px;
        width: 100px;
        border-radius: 50%;
        object-fit: cover;
        background: #dfdfdf
    }

</style>
@endsection


@section('content')

@if(session('msg'))
<div class="alert alert-primary alert-dismissible" role="alert">
    {{session('msg')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card">
    <form action="" method="POST" enctype="multipart/form-data" id="form-add-new-record">
        
        <!-- Account -->
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6 fv-plugins-icon-container">
                    <label class="form-label">Customer</label>
                    <input class="form-control" type="text" maxlength="40" name="customer" value="">
                </div>
                <div class="mb-3 col-md-6 fv-plugins-icon-container">
                    <label class="form-label">Address</label>
                    <input class="form-control" type="text" maxlength="7" name="address"
                        value="">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Contact Nama</label>
                    <input class="form-control" type="text" maxlength="20" name="contact_ama"
                        value="">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="text" maxlength="7" name="back_title"
                        value="">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone <i>(ex. 62xxxxxxxxx)</i></label>
                    <input class="form-control" type="number" name="no_phone" id="phone"
                        value="" placeholder="62xxxxxxxxxx">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Subject</label>
                    <select name="department_id" id="department_id" class="form-select select2">
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Sample taken by</label>
                    <input class="form-control" type="text" maxlength="20" name="nidn" id="nidn"
                        value="">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Sample Recive Data</label>
                    <input class="form-control" type="text" maxlength="20" name="nidn" id="nidn"
                        value="">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Sample Analysis</label>
                    <input class="form-control" type="text" maxlength="20" name="nidn" id="nidn"
                        value="">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Report Date</label>
                    <input class="form-control" type="text" maxlength="20" name="nidn" id="nidn"
                        value="">
                </div>
               
            </div>
            <div class="text-end mt-2">
                <button type="submit" class="btn btn-primary me-1" onclick="return confirmSubmit(event)">Update</button>
                <a class="btn btn-outline-secondary" href="">Back</a>
            </div>
            <input type="hidden">
        </div>
        <!-- /Account -->
    </form>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

@if(session('msg'))
<script type="text/javascript">
    //swall message notification
    $(document).ready(function () {
        swal(`{!! session('msg') !!}`, {
            icon: 'success',
            customClass: {
                confirmButton: 'btn btn-success'
            }
        });
    });

</script>
@endif

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

    function remove_zero() {
        var x = document.getElementById("phone").value;
        let number = Number(x);
        if (number == 0) {
            document.getElementById("phone").value = null;
        } else {
            document.getElementById("phone").value = number;
        }
    }

    document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('uploadedAvatar').src = e.target.result;
            }
            reader.readAsDataURL(file);
            // Display file info
            const fileInfo = `Selected file: ${file.name} (${file.type})`;
            document.getElementById('fileInfo').textContent = fileInfo;
        }
    });

</script>
@endsection
