@extends('layouts.master')
@section('content')
@section('title', 'Resume')

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
                            href="{{ route('institute.create')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col" width=""><b>No</b></th>
                                <th scope="col" width=""><b>Customer</b></th>
                                <th scope="col" width=""><b>Contact Name</b></th>
                                <th scope="col" width=""><b>Email</b></th>
                                <th scope="col" width=""><b>Phone</b></th>
                                <th scope="col" width=""><b>Description</b></th>
                                <th scope="col" width=""><b>Action</b></th>
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
                url: "{{ route('resume.data') }}",
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
                        return row.customer;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.contact_name;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        var html = "<span title='" + row.email + "'>" + row.email +
                            "</span>";
                        return html;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        return row.phone;
                    },
                    orderable: false
                },
                // {
                //     render: function (data, type, row, meta) {
                //         if (row.sample_descriptions && row.sample_descriptions.length > 0) {
                //             var html = row.sample_descriptions.map(function(desc, index) {
                //                 return `<span class="badge bg-dark"
                //                             style="border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                //                             ${desc.name}
                //                         </span>`;
                //             }).join('');
                //             return html;
                //         } else {
                //             return '-';
                //         }
                //     }
                // },
                {
                    render: function (data, type, row, meta) {
                        if (row.sample_descriptions && row.sample_descriptions.length > 0) {
                            // Gunakan list dengan bullet atau badge untuk membedakan setiap description
                            var html = '<ul style="padding-left: 15px;">';
                            row.sample_descriptions.forEach(function(desc) {
                                html += `<li><span class="badge bg-dark">${desc.name}</span></li>`;
                            });
                            html += '</ul>';
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
                            html = `<a class="badge bg-dark badge-icon" title="Add Sampling" href="{{ url('resume/add_sampling/${row.id}') }}">
                                    <i class="bx bx-plus icon-white"></i></a>
                                    <a class="badge bg-warning badge-icon" title="Edit Sampling" href="/${row.id}">
                                    <i class="bx bx-pencil"></i></a>
                                    <a class="badge bg-danger badge-icon" title="Delete Sampling" style="cursor:pointer" onclick="DeleteId('${row.id}')">
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
