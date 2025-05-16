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
                        <select id="select_subject" class="form-control input-sm select2" data-placeholder="Subject">
                            <option value="">Select subject</option>
                            @forEach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md d-flex justify-content-center justify-content-md-end">
                        <a class="btn btn-primary btn-block btn-mail" title="Add new"
                            href="{{ route('institute.create')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th><b>No</b></th>
                                <th>Kode Coa</th>
                                <th><b>Customer</b></th>
                                <th><b>Email</b></th>
                                <th><b>Phone</b></th>
                                <th><b>Description</b></th>
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
                url: "{{ route('institute.data') }}",
                data: function (d) {
                    d.select_subject = $('#select_subject').val()
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
                        var html = "<code><span title='" + row.no_coa + "' style='font-size: 18px; color:rgb(199, 76, 76);'>"
                                    + row.no_coa + "</span></code>";
                        return html;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        var html = "<span title='" + row.customer.name + "' style='font-size: 16px; color:rgb(80, 83, 94);'>"
                                    + row.customer.name + "</span>";
                        return html;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html = "<span title='" + row.customer.email + "' style='font-size: 16px; font-style: italic; color: #dc3545;'>"
                                    + row.customer.email + "</span>";
                        return html;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html = "<code><span title='" + row.customer.phone + "' style='font-size: 18px; color:rgb(30, 55, 23);'>"
                                    + row.customer.phone + "</span></code>";
                        return html;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.subjects && row.subjects.length > 0) {
                            // Gunakan Set untuk menyimpan subject_id yang unik
                            var uniqueSubjects = new Set();
                            var html = '';

                            row.subjects.forEach(function(subject) {
                                if (!uniqueSubjects.has(subject.id)) {
                                    uniqueSubjects.add(subject.id);
                                    html += `<span class="badge bg-dark me-1">${subject.name}</span>`;
                                }
                            });

                            return html;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        var html = '';
                        {
                            html = `
                                    <a class="badge bg-dark badge-icon" title="View Resume" href="/preview_pdf/${row.id}">
                                    <i class="bx bx-printer"></i></a>
                                    <a class="badge bg-warning badge-icon" title="Edit" href="/institute/edit/${row.id}">
                                    <i class="bx bx-pencil"></i></a>
                                    <a class="badge bg-danger badge-icon" title="Delete" style="cursor:pointer" onclick="DeleteId('${row.id}', '${row.no_coa}')">
                                    <i class="bx bx-trash icon-white"></i></a>
                                    `;
                        }
                        return html;
                    },
                    orderable: false,
                    className: "text-md-center"
                }
            ]
        });
        $('#select_subject').change(function () {
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
                        url: "{{ route('institute.delete') }}",
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
