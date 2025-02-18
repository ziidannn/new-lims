@extends('layouts.master')
@section('content')
@section('title', 'COA')

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
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <select id="select_description" class="form-control input-sm select2" data-placeholder="description">
                            <option value="">Select Description</option>
                            <!-- @foreach($description as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach -->
                        </select>
                    </div>
                    <div class="col-md d-flex justify-content-center justify-content-md-end">
                        <a class="btn btn-primary btn-block btn-mail" title="Add Audit Plan"
                            href="{{ route('audit_plan.add')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th><b>No</b></th>
                                <th width="20%"><b>Parameter</b></th>
                                <th width="35%"><b>Sampling Time</b></th>
                                <th width="10%"><b>Regulatory Standard</b></th>
                                <th width="20%"><b>Unit</b></th>
                                <th width="20%"><b>Method</b></th>
                                <th width="15%"><b>Action</b></th>
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
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/id.js')}}"></script>
{{-- <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/locale/id.js"></script> --}}
<!-- Memuat lokal Indonesia untuk moment.js -->

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
            ordering: true,
            language: {
                searchPlaceholder: 'Search data..'
            },
            ajax: {
                url: "{{ route('audit_plan.data') }}",
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
                    data: 'id',
                    render: function (data, type, row, meta) {
                        var no = (meta.row + meta.settings._iDisplayStart + 1);
                        return no;
                    },
                    className: "text-center",
                    orderable: true
                },
                {
                    render: function (data, type, row, meta) {
                        var html = `<a class="text-primary" title="` + row.auditee.name +
                            `" href="{{ url('setting/manage_account/users/edit/` +
                            row.idd + `') }}">` + row.auditee.name + `</a>`;

                        if (row.auditee.no_phone) {
                            html += `<br><a href="tel:` + row.auditee.no_phone +
                                `" class="text-muted" style="font-size: 0.8em;">` +
                                `<i class="fas fa-phone-alt"></i> ` + row.auditee.no_phone +
                                `</a>`;
                        }
                        return html;
                    },
                },
                {
                    data: null, // Kita akan menggabungkan date_start dan date_end, jadi tidak ada sumber data spesifik
                    render: function (data, type, row, meta) {
                        // Menggunakan moment.js untuk memformat tanggal
                        var formattedStartDate = moment(row.date_start).format(
                            'DD MMMM YYYY, HH:mm');
                        var formattedEndDate = moment(row.date_end).format(
                            'DD MMMM YYYY, HH:mm');
                        return formattedStartDate + ' - ' + formattedEndDate;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        var html =
                            `<span class="badge bg-${row.auditstatus.color}">${row.auditstatus.title}</span>`;
                        return html;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.location;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        var html = '';
                        if (row.auditstatus.id === 1 || row.auditstatus.id === 2 || row.auditstatus.id === 13 || row.auditstatus.id === 5) {
                            html = `<a class="badge bg-dark badge-icon" title="Edit Auditor Standard" href="{{ url('audit_plan/standard/edit/') }}/${row.id}">
                                    <i class="bx bx-show-alt icon-white"></i></a>
                                    <a class="badge bg-warning badge-icon" title="Edit Audit Plan" href="{{ url('edit_audit/') }}/${row.id}">
                                    <i class="bx bx-pencil"></i></a>
                                    <a class="badge bg-danger badge-icon" title="Delete Audit Plan" style="cursor:pointer" onclick="DeleteId('${row.id}', '${row.auditee.name}')">
                                    <i class="bx bx-trash icon-white"></i></a>`;
                        } else if (row.auditstatus.id === 1 || row.auditstatus.id === 2 || row
                            .auditstatus.id === 6 || row.auditstatus.id === 14) {
                            html = `<a class="badge bg-danger badge-icon" title="Delete Audit Plan" style="cursor:pointer" onclick="DeleteId('${row.id}', '${row.auditee.name}')">
                                    <i class="bx bx-trash icon-white"></i></a>`;
                        }
                        return html;
                    },
                    orderable: false,
                    className: "text-md-center"
                }
            ]
        });
        $('#select_auditee').change(function () {
            table.draw();
        });
    });

    function DeleteId(id, data) {
        swal({
                title: "Are you sure?",
                text: "After deleting, the data (" + data + ") cannot be recovered!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('audit_plan.delete') }}",
                        type: "DELETE",
                        data: {
                            "id": id,
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (data) {
                            if (data['success']) {
                                swal(data['message'], {
                                    icon: "success",
                                });
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                swal(data['message'], {
                                    icon: "error",
                                });
                            }
                        }
                    })
                }
            })
    }

</script>
@endsection
