@extends('layouts.master')
@section('content')
@section('title', 'Regulation')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>

    .badge-icon {
        display: inline-block;
        font-size: 1em;
        padding: 0.4em;
        margin-right: 0.1em;
    }

    .icon-white {
        color: white;
    }

</style>
@endsection
<div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link active" href=""><i
                    class="bx bx-add-to-queue me-1"></i>
                Regulation</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.parameter.index') }}"><i
                    class="bx bx-chart me-1"></i>
                Parameter</a></li>
    </ul>
</div>
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <select id="select_description" class="form-control input-sm select2" data-placeholder="Description">
                            <option value="">Select Description</option>

                        </select>
                    </div>
                    <div class="col-md d-flex justify-content-center justify-content-md-end">
                        <a class="btn btn-primary btn-block btn-mail" title="Add new"
                            href="{{ route('resume.create')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="20px"><b>No</b></th>
                                <th scope="col" width="20px"><b>Name</b></th>
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
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
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
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            searching: true,
            language: {
                searchPlaceholder: 'Search..',
            },
            ajax: {
                url: "{{ route('coa.regulation.data_regulation') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.select_description = $('#select_description').val()
                },
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            columns: [{
                    render: function (data, type, row, meta) {
                        var no = (meta.row + meta.settings._iDisplayStart + 1);
                        return no;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        return row.title;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        var html = '';
                        {
                            html = `<a class="badge bg-warning badge-icon" title="Add Resume COA" href="{{ url('coa/add_sampling/${row.id}') }}">
                                    <i class="bx bx-plus icon-white"></i></a>`;
                        }
                        return html;
                    },
                    orderable: false,
                    className: "text-md-center"
                }
            ]
        });
        $('#select_description').change(function () {
            table.draw();
        });
    });
</script>
@endsection
