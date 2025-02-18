@extends('layouts.master')
@section('content')
@section('title', 'Ambient Air')

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
                            href="{{ route('ambient_air.add')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th><b>No Sample</b></th>
                                <th><b>Location</b></th>
                                <th><b>Description</b></th>
                                <th><b>Date</b></th>
                                <th><b>Time</b></th>
                                <th><b>Method</b></th>
                                <th><b>Date Received</b></th>
                                <th><b>ITD</b></th>
                                <th><b>Action</b></th>
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
                url: "{{ route('ambient_air.data') }}",
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
                        return row.no_sample;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.sampling_location;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        // Check if row.category exists and has an id
                        if (row.description) {
                            var html =
                                `<a class="text-info" title="${row.description.name}"</a>`;
                            return html;
                        }
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        return row.date;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.time;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.method;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.date_received;
                    },
                    orderable: false
                },
                {
                    data: null, // Kita akan menggabungkan date_start dan date_end, jadi tidak ada sumber data spesifik
                    render: function (data, type, row, meta) {
                        // Menggunakan moment.js untuk memformat tanggal
                        var formattedStartDate = moment(row.itd_start).format(
                            'DD MMMM YYYY');
                        var formattedEndDate = moment(row.itd_end).format(
                            'DD MMMM YYYY');
                        return formattedStartDate + ' - ' + formattedEndDate;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        var html = '';
                        {
                            html = `<a class="badge bg-dark badge-icon" title="Edit Auditor Standard" href="/${row.id}">
                                    <i class="bx bx-show-alt icon-white"></i></a>
                                    <a class="badge bg-warning badge-icon" title="Edit Audit Plan" href="/${row.id}">
                                    <i class="bx bx-pencil"></i></a>
                                    <a class="badge bg-danger badge-icon" title="Delete Audit Plan" style="cursor:pointer" onclick="DeleteId('${row.id}')">
                                    <i class="bx bx-trash icon-white"></i></a>`;
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
                        url: "",
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
