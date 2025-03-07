@extends('layouts.master')
@section('content')
@section('title', 'Parameter')

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

    table.dataTable td {
        text-overflow: ellipsis;
    }

</style>
@endsection
<div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.subject.index') }}">
            <i class="bx bx-add-to-queue me-1"></i>
                Subject</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('coa.regulation.index') }}"><i
                    class="bx bx-add-to-queue me-1"></i>
                Regulation</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('coa.parameter.index') }}"><i
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
                    <select id="select_description" class="form-control input-sm select2"
                        data-placeholder="Description">
                        <option value="">Select Description</option>
                    </select>
                </div>
                <!-- <div class="col-md d-flex justify-content-center justify-content-md-end">
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#newrecord"
                        aria-controls="offcanvasEnd" tabindex="0" aria-controls="DataTables_Table_0"
                        title="Add Standard Criteria" type="button"><span><i class="bx bx-plus me-sm-2"></i>
                            <span>Add</span></span>
                    </button>
                </div> -->
                <div class="col-md d-flex justify-content-center justify-content-md-end">
                        <a class="btn btn-primary btn-block btn-mail" title="Add new"
                            href="{{ route('parameter.add_parameter')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                <div class="offcanvas offcanvas-end @if($errors->all()) show @endif" tabindex="-1" id="newrecord"
                    aria-labelledby="offcanvasEndLabel">
                    <div class="offcanvas-header">
                        <h5 id="offcanvasEndLabel" class="offcanvas-title">Add Parameter</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                        <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                            id="form-add-new-record" method="POST" action="">
                            @csrf
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Regulation</label>
                                <div class="input-group input-group-merge has-validation">
                                    <select
                                        class="form-select @error('regulation_id') is-invalid @enderror input-sm select2-modal"
                                        name="regulation_id" id="regulation_id">
                                        <option value="">-- Select Regulation --</option>
                                        @foreach($regulation as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('regulation_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->id }} - {{ $p->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('regulation_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Parameter</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="text" class="form-control @error('name')  is-invalid @enderror"
                                        maxlength="120" name="name" placeholder="Input The New Criteria"
                                        value="{{ old('name') }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Sampling Time --}}
                            <div class="col-sm-12">
                                <label class="form-label">Sampling Time</label>
                                <select class="form-select" name="sampling_time_id" id="sampling_time_id">
                                    <option value="">-- Select Sampling Time --</option>
                                    @foreach($samplingTime as $time)
                                        <option value="{{ $time->id }}">{{ $time->time }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Regulation Standard --}}
                            <div class="col-sm-12">
                                <label class="form-label">Regulation Standard</label>
                                <select class="form-select" name="regulation_standard_id" id="regulation_standard_id"
                                    disabled>
                                    <option value="">-- Select Regulation Standard --</option>
                                    @foreach($regulationStandards as $standard)
                                    <option value="{{ $standard->id }}">{{ $standard->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Unit</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="text" class="form-control @error('unit')  is-invalid @enderror"
                                        maxlength="120" name="unit" placeholder="Input The New Criteria"
                                        value="{{ old('unit') }}">
                                    @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Method</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="text" class="form-control @error('method')  is-invalid @enderror"
                                        maxlength="120" name="method" placeholder="Input The New Criteria"
                                        value="{{ old('method') }}">
                                    @error('method')
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
                            <th scope="col" width="10px"><b>No</b></th>
                            <th scope="col" width="20px"><b>Code Regulation</b></th>
                            <th scope="col" width="20px"><b>Parameter</b></th>
                            <th scope="col" width="20px"><b>Sampling Time</b></th>
                            <th scope="col" width="20px"><b>Regulatory Standard</b></th>
                            <th scope="col" width="20px"><b>Unit</b></th>
                            <th scope="col" width="20px"><b>Methods</b></th>
                            <th scope="col" width="20px"><b>Action</b></th>
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
                url: "{{ route('coa.parameter.data_parameter') }}",
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
                        return `<span style="color: red; font-weight: bold;">${row.regulation.regulation_code}</span>`;
                    },
                    orderable: false,
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
                        if (row.samplingTime) {
                            var html = '<ul style="color: black; padding-left: 15px;">';
                            row.samplingTime.split(', ').forEach(function(time) {
                                html += `<li>${time}</span></li>`;
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
                        if (row.regulationStandards) {
                            var html = '<ul style="color: green; padding-left: 15px;">';
                            row.regulationStandards.split(', ').forEach(function(title) {
                                html += `<li>${title}</span></li>`;
                            });
                            html += '</ul>';
                            return html;
                        } else {
                            return '-';
                        }
                    }
                },
                // {
                //     render: function (data, type, row, meta) {
                //         // Check if row.category exists and has an id
                //         if (row.samplingTime && row.samplingTime.id) {
                //             var html =
                //                 `<a class="text-dark" title="${row.samplingTime.time}" href="">${row.samplingTime.time}</a>`;
                //             return html;
                //         } else {
                //             return ''; // Return empty string or handle the case where regulation.title is missing
                //         }
                //     },
                //     className: "text-center"
                // },
                // {
                //     render: function (data, type, row, meta) {
                //         // Check if row.category exists and has an id
                //         if (row.regulationStandard && row.regulationStandard.id) {
                //             var html =
                //                 `<a class="text-dark" title="${row.regulationStandard.title}" href="">${row.regulationStandards.title}</a>`;
                //             return html;
                //         } else {
                //             return ''; // Return empty string or handle the case where regulation.title is missing
                //         }
                //     },
                //     className: "text-center"
                // },
                {
                    render: function (data, type, row, meta) {
                        return row.unit;
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
                        var html = ''; {
                            html = `<a class="badge bg-warning badge-icon" title="Edit parameter" style="cursor:pointer" href="{{ url('coa/parameter/edit_parameter/${row.id}') }}">
                                    <i class="bx bx-pencil icon-white"></i></a>
                                    <a class="badge bg-danger badge-icon" title="Delete parameter" style="cursor:pointer"
                                    onclick="DeleteId(\'` + row.id + `\',\'` + row.title + `\')" >
                                    <i class='bx bx-trash icon-white'></i></a>`;
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const samplingTimeSelect = document.getElementById('sampling_time_id');
        const regulationStandardSelect = document.getElementById('regulation_standard_id');

        samplingTimeSelect.addEventListener('change', function () {
            if (this.value) {
                regulationStandardSelect.removeAttribute('disabled');
            } else {
                regulationStandardSelect.setAttribute('disabled', 'disabled');
            }
        });
    });
</script>
@endsection
