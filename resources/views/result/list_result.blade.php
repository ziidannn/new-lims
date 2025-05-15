@extends('layouts.master')
@section('content')
@section('title', 'List Result')

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

    .badge-truncate {
    display: inline-block;
    max-width: 800px; /* Sesuaikan ukuran */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    }
</style>
@endsection
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sample Description</th>
                                <th>Regulation</th>
                                <th>Action</th>
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
@if(request()->has('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            swal("Success!", "Data Sample and Logo Successfully Submitted.", "success");
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
                url: "{{ route('result.getDataResult', $institute->id) }}", // Ambil data berdasarkan institute_id
                data: function (d) {
                    d.search = $('input[type="search"]').val();
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
                        console.log(row); // Debug data di browser console
                        if (row.institute_subject && row.institute_subject.subject) {
                            return `<span class="badge bg-dark">${row.institute_subject.subject.name}</span>`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        console.log(row); // Debug di browser console

                        if (row.regulation) {
                            return `<span title="${row.regulation.title}">${row.regulation.title}</span>`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        var html = '';

                        if (row.institute_subject && row.institute_subject.id) {
                            var instituteSubjectId = row.institute_subject.id; // Gunakan institute_subject.id

                            if (row.institute_subject.subject.id == 1) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Ambient Air" href="/result/ambient_air/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            } else if (row.institute_subject.subject.id == 2) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Workplace Air" href="/result/workplace/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            } else if (row.institute_subject.subject.id == 3) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Noise" href="/result/noise/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            } else if (row.institute_subject.subject.id == 4) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Odor" href="/result/odor/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            } else if (row.institute_subject.subject.id == 5) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Illumination*" href="/result/illumination/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            } else if (row.institute_subject.subject.id == 6) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Heat Stress" href="/result/heat_stress/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            } else if (row.institute_subject.subject.id == 7) {
                                html = `<a class="badge bg-warning badge-icon" title="Add Stationary Stack Source Emission" href="/result/stationary_stack/${instituteSubjectId}">
                                        <i class="bx bx-pencil icon-white"></i></a>`;
                            }
                        } else {
                            html = '-';
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
