@extends('layouts.master')
@section('title', 'Add Parameter')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <h5 class="card-header">Add Parameter</h5>
        <div class="card-body">
            @if(session('msg'))
            <div class="alert alert-primary alert-dismissible">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('parameter.add_parameter') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Subject <i class="text-danger">*</i></label>
                        <select class="form-control select2" id="editSampleSubjects" name="subject_id" required>
                            <option value="">-- Select Subject --</option>
                            @foreach($subjects as $p)
                            <option value="{{ $p->id }}" data-code="{{ $p->subject_code }}" {{ old('subject_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->subject_code }} - {{ $p->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">Name <i class="text-danger">*</i></label>
                        <textarea name="name" class="form-control" rows="2" maxlength="175" placeholder="e.g. pH, COD, TSS" required>{{ old('name') }}</textarea>
                        @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Unit <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="unit" placeholder="e.g. mg/L, °C, -" value="{{ old('unit') }}" required>
                        @error('unit')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Method <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="method" placeholder="e.g. SNI 6989.11:2019" value="{{ old('method') }}" required>
                        @error('method')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Sampling Time + Regulation (for subject_code 01 only) --}}
                <div class="mt-4" id="sampling_section" style="display: none;">
                    <label class="form-label">Sampling Time & Regulation Standard</label>
                    <div id="sampling_time_container">
                        <div class="row mb-2">
                            <div class="col-md-5">
                                {{-- Hapus id dan tambahkan class 'sampling-input' --}}
                                <select class="form-control sampling-input select2" name="sampling_time_id[]" required>
                                    <option value="">-- Select Sampling Time --</option>
                                    @foreach ($samplingTime as $sampling)
                                        <option value="{{ $sampling->id }}">{{ $sampling->time }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                {{-- Bagian ini sudah benar --}}
                                <select name="regulation_standard_id[]" class="form-control sampling-input select2">
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
                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add_more">+ Add More</button>
                </div>

                {{-- Regulation per Class (I–IV) --}}
                <div class="mt-4">
                    <label class="form-label">Regulation Standard per Class (Optional)</label>
                    <div class="row">
                        @foreach(['I', 'II', 'III', 'IV'] as $class)
                        <div class="col-md-3 mb-2">
                            <label for="reg_class_{{ $class }}">Class {{ $class }}</label>
                            <input type="text" class="form-control" name="regulation_class[{{ $class }}]"
                                id="reg_class_{{ $class }}" placeholder="e.g. 0.05 or 6-9"
                                value="{{ old('regulation_class.' . $class) }}">
                            @error('regulation_class')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    <label class="text-danger"><i><b>* Regulation Standard Class digunakan jika perlu, Contohnya Subject Wastewater & Surface Water</b></i></label>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-outline-secondary" href="{{ route('coa.parameter.index') }}">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

<script>
$(document).ready(function () {
    // Opsi konfigurasi untuk Select2 agar konsisten
    const select2Options = {
        placeholder: "Select an option",
        allowClear: true
    };

    // Inisialisasi semua Select2 saat halaman dimuat
    $('.select2').select2(select2Options);

    // Definisikan elemen utama
    const subjectSelect = $('#editSampleSubjects');
    const samplingSection = $('#sampling_section');
    const samplingTimeContainer = $('#sampling_time_container');

    // Fungsi untuk menampilkan/menyembunyikan section
    function toggleSamplingSection() {
        const selectedOption = subjectSelect.find('option:selected');
        const subjectCode = selectedOption.data('code');
        const isAmbientAir = String(subjectCode).trim() === '01';

        if (isAmbientAir) {
            samplingSection.show();
            samplingSection.find('.sampling-input').prop('required', true);
        } else {
            samplingSection.hide();
            samplingSection.find('.sampling-input').prop('required', false);
        }
        // Inisialisasi ulang Select2 di dalam section yang mungkin baru ditampilkan
        samplingSection.find('.select2').select2(select2Options);
    }

    // --- EVENT LISTENERS ---

    // 1. Event listener untuk perubahan Subject
    subjectSelect.on('change', function () {
        toggleSamplingSection();
    });

    // 2. Event listener untuk tombol 'Add More'
    $('#add_more').on('click', function () {
        const newRowHtml = `
            <div class="row mb-2">
                <div class="col-md-5">
                    <select name="sampling_time_id[]" class="form-control sampling-input select2">
                        <option value="">Select Sampling Time</option>
                        @foreach ($samplingTime as $sampling)
                        <option value="{{ $sampling->id }}">{{ $sampling->time }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="regulation_standard_id[]" class="form-control sampling-input select2">
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
        `;

        const newRow = $(newRowHtml);
        samplingTimeContainer.append(newRow);

        // Hanya inisialisasi Select2 pada elemen BARU yang ditambahkan
        newRow.find('.select2').select2(select2Options);

        // Pastikan input baru juga required jika section sedang terlihat
        if (samplingSection.is(":visible")) {
            newRow.find('.sampling-input').prop('required', true);
        }
    });

    // 3. Event listener untuk tombol 'Remove' (menggunakan event delegation)
    samplingTimeContainer.on('click', '.remove-row', function () {
        $(this).closest('.row').remove();
    });

    // --- INITIAL CALL ---
    // Panggil fungsi saat halaman dimuat untuk memeriksa nilai awal (misal: dari old input)
    toggleSamplingSection();
});
</script>
@endsection
