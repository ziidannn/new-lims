@extends('layouts.master')
@section('content')
@section('title', 'Print Audit Report')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
</style>
@endsection

<div class="card p-3">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flaex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="offset-md-0 col-md-0 text-md-end text-center pt-3 pt-md-0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-hover table-sm" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="5%"><b>No</b></th>
                                <th><b>Name</b></th>
                                <th width="5%"><b>Action</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">Absensi</td>
                                <td class="text-md-center">
                                    <a class="badge bg-primary" title="Print Make Report" href="{{ route('pdf.att', ['id' => $data->id, 'type' => 'AMI Report']) }}">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-center">Berita Acara</td>
                                <td class="text-md-center">
                                    <a class="badge bg-primary" title="Print Make Report" href="{{ route('pdf.meet_report', ['id' => $data->id, 'type' => 'AMI Report']) }}">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-center">Form Checklist</td>
                                <td class="text-md-center">
                                    <a class="badge bg-primary" title="Print Make Report" href="{{ route('pdf.form_cl', ['id' => $data->id, 'type' => 'AMI Report']) }}">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-center">KS/KTS</td>
                                <td class="text-md-center">
                                    <a class="badge bg-primary" title="Print Make Report" href="{{ route('pdf.ks_kts', ['id' => $data->id, 'type' => 'AMI Report']) }}">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-center">PTP/PTK</td>
                                <td class="text-md-center">
                                    <a class="badge bg-primary" title="Print Make Report" href="{{ route('pdf.ptp_ptk', ['id' => $data->id, 'type' => 'AMI Report']) }}">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/locale/id.js"></script> <!-- Memuat lokal Indonesia untuk moment.js -->

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

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: false,  // Change to false if data is loaded directly in the Blade view
            ordering: false,
            language: {
                searchPlaceholder: 'Search data..'
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            columns: [
                {
                    render: function (data, type, row, meta) {
                        var no = meta.row + 1;
                        return no;
                    },
                    className: "text-center"
                },
                {
                    data: 'name',
                    className: "text-md-center"
                },
            ]
        });
    });
</script>
@endsection
