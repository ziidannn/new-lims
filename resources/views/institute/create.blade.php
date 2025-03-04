@extends('layouts.master')
@section('content')
@section('title', 'Create Institute')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .checkbox label::before {
        border: 1px solid #333;
    }

</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection
@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
        <div class="col-xl-12">
            <form class="card" method="POST" action="">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">Add @yield('title')</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Customer<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('customer')  is-invalid @enderror"
                                    maxlength="120" name="customer"
                                    placeholder="Input customer, Example PT SSA SUMMIT SEAYON"
                                    value="{{ old('customer') }}">
                                @error('customer')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Address<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('address')  is-invalid @enderror"
                                    maxlength="120" name="address" placeholder="Input Name address"
                                    value="{{ old('address') }}">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Contact Name<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                                    maxlength="120" name="contact_name" placeholder="Input phone"
                                    value="{{ old('contact_name') }}">
                                @error('contact_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Email<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    maxlength="120" name="email" placeholder="Input Contact Name"
                                    value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Phone<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    maxlength="120" name="phone" placeholder="Input Contact Name"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sample Receive Data<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date"
                                    class="form-control @error('sample_receive_date') is-invalid @enderror"
                                    maxlength="120" name="sample_receive_date" placeholder="Input Sample Recive Data"
                                    value="{{ old('sample_receive_date') }}">
                                @error('sample_receive_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sample Analysis Date<i
                                    class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date"
                                    class="form-control @error('sample_analysis_date') is-invalid @enderror"
                                    maxlength="120" name="sample_analysis_date" placeholder="Input Sample Analysis Date"
                                    value="{{ old('sample_analysis_date') }}">
                                @error('sample_analysis_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Report Date<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('report_date') is-invalid @enderror"
                                    maxlength="120" name="report_date" placeholder="Input Sample Report Date"
                                    value="{{ old('report_date') }}">
                                @error('report_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Sampling Description<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <select class="form-select @error('subject_id') is-invalid @enderror input-sm select2-modal"
                                        name="subject_id[]" id="subject_id" multiple>
                                    @foreach($description as $p)
                                        <option value="{{ $p->id }}"
                                            {{ (is_array(old('subject_id')) && in_array($p->id, old('subject_id')) ? "selected": "") }}>
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
                        <div class="col-lg-6 col-md-12">
                            <label class="form-label" for="basicDate">Regulation<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <select class="form-select @error('regulation_id') is-invalid @enderror input-sm select2-modal"
                                        name="regulation_id[]" id="regulation_id" multiple>
                                    @foreach($regulation as $rg)
                                        <option value="{{ $rg->id }}"
                                            {{ (is_array(old('regulation_id')) && in_array($rg->id, old('regulation_id')) ? "selected": "") }}>
                                            {{ $rg->id }} - {{ $rg->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('regulation_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> -->
                        <div class="col-lg-12">
                            <label class="col-form-label">Sample Description & Regulation</label>
                            <div id="subject_id_container">
                                <div class="row mb-2">
                                    <div class="col-md-5">
                                    <select name="subject_id[]" class="form-select input-sm select2-modal" required>
                                        <option value="">Select Sample Description</option>
                                            @foreach ($description as $desc)
                                            <option value="{{ $desc->id }}">{{ $desc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-5">
                                        <select name="regulation_id[]" class="form-select input-sm select2-modal" required>
                                            <option value="">Select Regulation</option>
                                            @foreach ($regulation as $rg)
                                            <option value="{{ $rg->id }}">{{ $rg->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-row">X</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary mt-2" id="add_more">+ Add More</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary me-1" type="submit">Create</button>
                    <a href="{{ url()->previous() }}">
                        <span class="btn btn-outline-secondary">Back</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#subject_id').select2({
            placeholder: "Select Sample Description",
            allowClear: true
        });

        $('#regulation_id').select2({
            placeholder: "Select Regulation",
            allowClear: true
        });
    });
</script>
<script>
    $(document).on('change', 'select[name="subject_id[]"]', function () {
    let selectedSubject = $(this).val(); // Ambil subject_id yang dipilih
    let regulationSelect = $(this).closest('.row').find('select[name="regulation_id[]"]'); // Cari dropdown regulation terkait

    if (selectedSubject) {
        $.ajax({
            url: "{{ route('DOC.get_regulation_id_by_id') }}",
            type: "GET",
            data: { ids: [selectedSubject] }, // Kirim array subject_id
            dataType: 'json',
            success: function (results) {
                let regulationOptions = '<option value="">Select Regulation</option>';
                $.each(results, function (key, value) {
                    regulationOptions += '<option value="' + value.id + '">' + value.title + '</option>';
                });

                regulationSelect.html(regulationOptions);
            }
        });
    } else {
        regulationSelect.html('<option value="">Select Regulation</option>'); // Kosongkan jika tidak ada yang dipilih
    }
});
</script>
<script>
    $(document).ready(function () {
        const selectElement = document.querySelector('#is_required');
        selectElement.addEventListener('change', (event) => {
            selectElement.value = selectElement.checked ? 1 : 0;
            // alert(selectElement.value);
            $('#subject_id_container').on('click', '#add_more', function () {
                let container = document.getElementById('subject_id_container');
                let div = document.createElement('div');
                div.classList.add('row', 'mb-2');

                div.innerHTML = `
                <div class="col-md-5">
                    <select name="subject_id[]" class="form-select input-sm select2-modal" required>
                        <option value="">Select Sample Description</option>
                        @foreach ($description as $desc)
                            <option value="{{ $desc->id }}">{{ $desc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <select name="regulation_id[]" class="form-select input-sm select2-modal" required>
                        <option value="">Select Regulation </option>
                        @foreach ($regulation as $rg)
                            <option value="{{ $rg->id }}">{{ $rg->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-row">X</button>
                </div>
            `;

                container.appendChild(div);
                $('.select2').select2({
                    placeholder: "Select an option",
                    allowClear: true
                });
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('.row').remove();
            });

            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });
    });

</script>
<script>
    document.getElementById('add_more').addEventListener('click', function () {
        let container = document.getElementById('subject_id_container');
        let div = document.createElement('div');
        div.classList.add('row', 'mb-2');

        div.innerHTML = `
        <div class="col-md-5">
            <select name="subject_id[]" class="form-control" required>
                <option value="">Select Sample Description</option>
                @foreach ($description as $desc)
                    <option value="{{ $desc->id }}">{{ $desc->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-5">
            <select name="regulation_id[]" class="form-control" required>
                <option value="">Select Regulation </option>
                @foreach ($regulation as $rg)
                    <option value="{{ $rg->id }}">{{ $rg->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-row">X</button>
        </div>
    `;

        container.appendChild(div);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.row').remove();
        }
    });

</script>
@endsection
