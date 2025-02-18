@extends('layouts.master')
@section('title', '')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
@endsection

@section('style')
<style>
    table.dataTable tbody td {
        vertical-align: middle;
    }

    table.dataTable td:nth-child(2) {
        max-width: 120px;
    }

    table.dataTable td:nth-child(3) {
        max-width: 100px;
    }

    table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .badge-icon {
        display: inline-block;
        font-size: 1em;
        padding: 0.4em;
        margin-right: 0.1em;
    }

    .icon-white {
        color: white;
    }

    .checkbox label::before {
        border: 1px solid #333;
    }

</style>
@endsection

@section('breadcrumb-title')
<h3>@yield('title')</h3>
@endsection

@section('breadcrumb-items')
@endsection


@section('content')
<div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link" href=""><i
                    class="bx bx-add-to-queue me-1"></i>
                Data Standard</a></li>
        <li class="nav-item"><a class="nav-link" href=""><i
                    class="bx bx-chart me-1"></i>
                Standard Statement</a></li>
        <li class="nav-item"><a class="nav-link active" href=""><i
                    class="bx bx-bar-chart-alt-2 me-1"></i>
                Indicator</a></li>
        <li class="nav-item"><a class="nav-link" href=""><i
                    class="bx bx-folder-open me-1"></i>
                List Document</a></li>
    </ul>
</div>

<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <select id="select_statement" class="form-control input-sm select2"
                        data-placeholder="Standard Statement">
                        <option value="">Select Standard Statement</option>
                        
                        <option value=""></option>
                       
                    </select>
                </div>
                <div class="col-md d-flex justify-content-center justify-content-md-end">
                    <a class="btn btn-primary btn-block btn-mail" title="Add statement"
                        href="{{ route('resume.create')}}">
                        <i data-feather="plus"></i>+ Add
                    </a>
                </div>
                <table class="table table-hover table-sm" id="datatable" width="100%">
                    <thead>
                        <tr>
                            <th width="15px">No</th>
                            <th>Indicator</th>
                            <th>Standard Statement</th>
                            <th width="15px">Standard Criteria</th>
                            <th width="5px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
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


