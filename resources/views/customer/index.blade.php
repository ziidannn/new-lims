@extends('layouts.master')
@section('content')
@section('title', 'Customer')

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
                <div class="row mb-3">
                    <!-- Tombol Export Excel di sebelah kiri -->
                    <div class="col-md d-flex justify-content-start">
                       <a href="{{ route('customer.export') }}" class="btn" style="background-color: #217346; color: white; border-color: #1e623b;">
                            <i class="bx bx-export me-sm-2"></i> Export Excel
                        </a>
                    </div>

                    <!-- Tombol Add di sebelah kanan -->
                    <div class="col-md d-flex justify-content-end">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#newrecord"
                            aria-controls="offcanvasEnd" title="Add Standard Criteria">
                            <i class="bx bx-plus me-sm-2"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </div>
                <div class="offcanvas offcanvas-end @if($errors->all()) show @endif" tabindex="-1" id="newrecord"
                    aria-labelledby="offcanvasEndLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEndLabel" class="offcanvas-title">Create Customer</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                        <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                            id="form-add-new-record" method="POST" action="">
                            @csrf
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="name">Customer</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        maxlength="120" name="name" placeholder="Example: PT. Delta Indonesia Laboratory"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="contact_name">Contact Name</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                                        maxlength="120" name="contact_name" placeholder="Example: Adit Jarwo"
                                        value="{{ old('contact_name') }}" required>
                                    @error('contact_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        maxlength="120" name="email" placeholder="Example: deltaindonesaialaboratory@gmail.com"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="phone">Phone</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        maxlength="15" name="phone" placeholder="Example: 08123456789"
                                        value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="address">Address</label>
                                <div class="input-group input-group-merge has-validation">
                                    <textarea type="text" class="form-control @error('address') is-invalid @enderror"
                                        maxlength="255" name="address" placeholder="Example: Jl. Raya Bogor"
                                        value="{{ old('address') }}" required></textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3 d-flex justify-content-right">
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
                            <th><b>Customer</b></th>
                            <th><b>Contact Name</b></th>
                            <th><b>Email</b></th>
                            <th><b>Phone</b></th>
                            <th><b>Address</b></th>
                            <th><b>Action</b></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Edit customer -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</b></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Customer</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContactName" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="editContactName" name="contact_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editAddress" name="address" required></textarea>
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
                url: "{{ route('customer.data') }}",
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
                        return row.name;
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
                        return row.email;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.phone;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return row.address;
                    },
                    orderable: false
                },
                {
                    render: function (data, type, row, meta) {
                        return `
                            <a class="badge bg-warning badge-icon edit-btn" title="Edit Customer"
                            style="cursor:pointer" data-id="${row.id}" data-name="${row.name}"
                            data-contact_name="${row.contact_name}" data-email="${row.email}"
                            data-phone="${row.phone}" data-address="${row.address}">
                                <i class="bx bx-pencil icon-white"></i>
                            </a>
                            <a class="badge bg-danger badge-icon" title="Delete Customer" style="cursor:pointer"
                            onclick="DeleteId('${row.id}', '${row.name}')">
                                <i class='bx bx-trash icon-white'></i>
                            </a>`;
                    },
                    orderable: false,
                    className: "text-md-center"
                }
            ]
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
                        url: "{{ route('delete') }}",
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
            let name = $(this).data('name');
            let contact_name = $(this).data('contact_name');
            let email = $(this).data('email');
            let phone = $(this).data('phone');
            let address = $(this).data('address');

            // Set data ke dalam modal
            $('#editName').val(name);
            $('#editContactName').val(contact_name);
            $('#editEmail').val(email);
            $('#editPhone').val(phone);
            $('#editAddress').val(address);
            $('#editForm').attr('action', `/customer/update/${id}`);

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
                    swal("Success!", "Customer updated successfully.", "success");
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
