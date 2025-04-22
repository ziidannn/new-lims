@extends('layouts.master')
@section('content')
@section('title', 'Add Parameter')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
        <div class="col-md-12">
            @if(session('msg'))
            <div class="alert alert-primary alert-dismissible" role="alert">
                {{session('msg')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card mb-4">
                <h5 class="card-header">Add Parameter</h5>
                <hr class="my-0">
                <div class="card-body">
                    <form action="{{ route('parameter.add_parameter') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="editSampleSubjects" class="form-label">Subject<i
                                        class="text-danger">*</i></label>
                                <select class="form-control" id="editSampleSubjects" name="subject_id" required>
                                    <option value="">-- Select Subject --</option>
                                    @foreach($subjects as $p)
                                    <option value="{{ $p->id }}" data-code="{{ $p->subject_code }}">
                                        {{ $p->subject_code }} - {{ $p->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('subject_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror


                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name <i class="text-danger">*</i></label>
                                    <textarea class="form-control" maxlength="175" placeholder="Max 175 characters..."
                                        rows="2" name="name" id="name">{{ old('name') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="unit" class="col-form-label">Unit <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="unit" id="unit"
                                        value="{{ old('unit') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="method" class="col-form-label">Method <i
                                            class="text-danger">*</i></label>
                                    <input type="text" class="form-control" name="method" id="method"
                                        value="{{ old('method') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12" id="sampling_section">
                                <label class="col-form-label">Sampling Time & Regulation Standard</label>
                                <div id="sampling_time_container">
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <select name="sampling_time_id[]" class="form-control sampling-input">
                                                <option value="">Select Sampling Time</option>
                                                @foreach ($samplingTime as $sampling)
                                                <option value="{{ $sampling->id }}">{{ $sampling->time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="regulation_standard_id[]" class="form-control sampling-input">
                                                <option value="">Select Regulation Standard</option>
                                                @foreach ($regulationStandards as $standard)
                                                <option value="{{ $standard->id }}">{{ $standard->title }}</option>
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

                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a class="btn btn-outline-secondary" href="{{ route('coa.parameter.index') }}">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.select2-modal').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });

</script>

<script>
    document.getElementById('add_more').addEventListener('click', function () {
        let container = document.getElementById('sampling_time_container');
        let div = document.createElement('div');
        div.classList.add('row', 'mb-2');

        div.innerHTML = `
        <div class="col-md-5">
            <select name="sampling_time_id[]" class="form-control sampling-input">
                <option value="">Select Sampling Time</option>
                @foreach ($samplingTime as $sampling)
                    <option value="{{ $sampling->id }}">{{ $sampling->time }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-5">
            <select name="regulation_standard_id[]" class="form-control sampling-input">
                <option value="">Select Regulation Standard</option>
                @foreach ($regulationStandards as $standard)
                    <option value="{{ $standard->id }}">{{ $standard->title }}</option>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subjectSelect = document.getElementById('editSampleSubjects');
        const samplingSection = document.getElementById('sampling_section');

        function toggleSamplingSection() {
            const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
            const subjectCode = selectedOption.getAttribute('data-code');
            const isAmbientAir = subjectCode === '01'; // Ganti sesuai kode Ambient Air kamu

            if (isAmbientAir) {
                samplingSection.style.display = 'block';
                document.querySelectorAll('.sampling-input').forEach(input => {
                    input.setAttribute('required', 'required');
                });
            } else {
                samplingSection.style.display = 'none';
                document.querySelectorAll('.sampling-input').forEach(input => {
                    input.removeAttribute('required');
                });
            }
        }

        subjectSelect.addEventListener('change', toggleSamplingSection);
        toggleSamplingSection(); // run saat halaman pertama kali load
    });
</script>
@endsection
