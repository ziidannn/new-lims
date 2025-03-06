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
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.subject.index') }}">
            <i class="bx bx-add-to-queue me-1"></i>
                Subject</a></li></a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('coa.regulation.index') }}"><i
                    class="bx bx-add-to-queue me-1"></i>
                Regulation</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.parameter.index') }}"><i
                    class="bx bx-chart me-1"></i>
                Parameter</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.sampling_time.index') }}"><i
                    class="bx bx-chart me-1"></i>
                Sampling Time</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.regulation_standard.index') }}"><i
                    class="bx bx-chart me-1"></i>
                Regulation Standard</a></li>
    </ul>
</div>
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <select id="select_subjects" class="form-control input-sm select2" data-placeholder="subjects">
                        <option value="">Select subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md d-flex justify-content-center justify-content-md-end">
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#newrecord"
                        aria-controls="offcanvasEnd" tabindex="0" aria-controls="DataTables_Table_0"
                        title="Add Standard Criteria" type="button"><span><i class="bx bx-plus me-sm-2"></i>
                            <span>Add</span></span>
                    </button>
                </div>

                <div class="offcanvas offcanvas-end @if($errors->all()) show @endif" tabindex="-1" id="newrecord"
                    aria-labelledby="offcanvasEndLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEndLabel" class="offcanvas-title">Add New Regulation</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                        <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                            id="form-add-new-record" method="POST" action="">
                            @csrf
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Sample subjects</label>
                                <div class="input-group input-group-merge has-validation">
                                    <select
                                        class="form-select @error('subject_id') is-invalid @enderror input-sm select2-modal"
                                        name="subject_id" id="subject_id">
                                        <option value="">-- Select Subject --</option>
                                        @foreach($subjects as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('subject_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->id }} - {{ $p->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Name Regulation</label>
                                <div class="input-group input-group-merge has-validation">
                                    <textarea type="text" class="form-control @error('title')  is-invalid @enderror"
                                        maxlength="120" name="title" placeholder="Input The New Criteria"
                                        value="{{ old('title') }}"></textarea>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Create</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="offcanvas">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th><b>No</b></th>
                            <th><b>Subject</b></th>
                            <th><b>Code Regulation</b></th>
                            <th><b>Regulation</b></th>
                            <th><b>Action</b></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Edit Regulation -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Regulation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editSamplesubjects" class="form-label">Sample subjects</label>
                        <select class="form-select" id="editSamplesubjects" name="subject_id" required>
                            <option value="">-- Select Sample subjects --</option>
                            @foreach($subjects as $p)
                            <option value="{{ $p->id }}">{{ $p->subject_code }} - {{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
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
                        d.select_subjects = $('#select_subjects').val()
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
                        // Check if row.category exists and has an id
                        if (row.subjects && row.subjects.id) {
                            var html =
                                `<a class="text-primary" title="${row.subjects.name}" href=""><b>${row.subjects.name}</b></a>`;
                            return html;
                        } else {
                            return ''; // Return empty string or handle the case where regulation.title is missing
                        }
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        return `<span class="text-success fw-bold text-center">${row.regulation_code}</span>`;
                    },
                    orderable: false,
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
                        return `
                            <a class="badge bg-warning badge-icon edit-btn" title="Edit Regulation"
                            style="cursor:pointer" data-id="${row.id}" data-title="${row.title}"
                            data-subject_id="${row.subject_id}">
                                <i class="bx bx-pencil icon-white"></i>
                            </a>
                            <a class="badge bg-danger badge-icon" title="Delete Regulation" style="cursor:pointer"
                            onclick="DeleteId('${row.id}', '${row.title}')">
                                <i class='bx bx-trash icon-white'></i>
                            </a>`;
                    },
                    orderable: false,
                    className: "text-md-center"
                }
                // {
                //     render: function (data, type, row, meta) {
                //         var html = '';
                //         {
                //             html = `<a class="badge bg-warning badge-icon" title="Edit Regulation" style="cursor:pointer" href="{{ url('coa/regulation/edit_regulation/${row.id}') }}">
                //                     <i class="bx bx-pencil icon-white"></i></a>
                //                     <a class="badge bg-danger badge-icon" title="Delete Regulation" style="cursor:pointer"
                //                     onclick="DeleteId(\'` + row.id + `\',\'` + row.title + `\')" >
                //                     <i class='bx bx-trash icon-white'></i></a>`;
                //         }
                //         return html;
                //     },
                //     orderable: false,
                //     className: "text-md-center"
                // }
            ]
        });
        $('#select_subjects').change(function () {
            table.draw();
        });
    });

    function DeleteId(id, data) {
        swal({
                title: "Apa kamu yakin?",
                text: "Setelah dihapus, data (" + data + ") tidak dapat dipulihkan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('coa.regulation.delete_regulation') }}",
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
<script>
    $(document).ready(function () {
        $(document).on('click', '.edit-btn', function () {
            let id = $(this).data('id');
            let subject_id = $(this).data('subject_id');
            let title = $(this).data('title');

            // Set data ke dalam modal
            $('#editTitle').val(title);
            $('#editSamplesubjects').val(subject_id);
            $('#editForm').attr('action', `/coa/regulation/update/${id}`);

            // Tampilkan modal
            $('#editModal').modal('show');
        });

        // Handle form submission
        $('#editForm').submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#editModal').modal('hide');
                    swal("Success!", "Regulation updated successfully.",
                    "success");
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    alert("Error updating data.");
                }
            });
        });
    });
</script>
@endsection
