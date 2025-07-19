@extends('layouts.master')
@section('title', 'Edit Parameter')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <h5 class="card-header">Edit Parameter</h5>
        <div class="card-body">
            @if(session('msg'))
            <div class="alert alert-primary alert-dismissible">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('coa.parameter.edit', $data->id) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    {{-- FIELD SUBJECT (PENTING!) --}}
                    <div class="col-md-6">
                        <label class="form-label">Subject <i class="text-danger">*</i></label>
                        <select class="form-control select2" id="subject_select" name="subject_id" required>
                            <option value="">-- Select Subject --</option>
                            @foreach($subjects as $p)
                            <option value="{{ $p->id }}" data-code="{{ $p->subject_code }}" {{ old('subject_id', $data->subject_id) == $p->id ? 'selected' : '' }}>
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
                        <textarea name="name" class="form-control" rows="2" maxlength="175" required>{{ old('name', $data->name) }}</textarea>
                        @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Unit <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="unit" value="{{ old('unit', $data->unit) }}" required>
                        @error('unit')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Method <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="method" value="{{ old('method', $data->method) }}" required>
                        @error('method')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- BAGIAN DINAMIS: SAMPLING TIME (HANYA UNTUK AMBIENT AIR) --}}
                <div class="mt-4" id="sampling_section" style="display: none;">
                    <label class="form-label">Sampling Time & Regulation Standard</label>
                    <div id="sampling_time_container">
                        {{-- Tampilkan data yang sudah ada --}}
                        @forelse ($existingSamplingTimes as $existing)
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <select name="sampling_time_id[]" class="form-control sampling-input select2">
                                    <option value="">Select Sampling Time</option>
                                    @foreach ($samplingTime as $sampling)
                                    <option value="{{ $sampling->id }}" {{ $existing->sampling_time_id == $sampling->id ? 'selected' : '' }}>
                                        {{ $sampling->time }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="regulation_standard_id[]" class="form-control sampling-input select2">
                                    <option value="">Select Regulation Standard</option>
                                    @foreach ($regulationStandards as $standard)
                                    <option value="{{ $standard->id }}" {{ $existing->regulation_standard_id == $standard->id ? 'selected' : '' }}>
                                        {{ $standard->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-row">X</button>
                            </div>
                        </div>
                        @empty
                        {{-- Jika tidak ada data, sediakan satu baris kosong --}}
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
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add_more">+ Add More</button>
                </div>

                {{-- BAGIAN DINAMIS: REGULATION PER CLASS --}}
                <div class="mt-4" id="regulation_class_section" style="display: none;">
                    <label class="form-label">Regulation Standard per Class (Optional)</label>
                    <div class="row">
                        @foreach(['I', 'II', 'III', 'IV'] as $class)
                        <div class="col-md-3 mb-2">
                            <label for="reg_class_{{ $class }}">Class {{ $class }}</label>
                            <input type="text" class="form-control" name="regulation_class[{{ $class }}]" id="reg_class_{{ $class }}"
                                value="{{ old('regulation_class.' . $class, $existingRegClasses[$class] ?? '') }}">
                        </div>
                        @endforeach
                        @error('regulation_class')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <label class="text-danger"><i><b>* Regulation Standard Class digunakan jika perlu, Contohnya Subject Wastewater & Surface Water</b></i></label>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a class="btn btn-outline-secondary" href="{{ route('coa.parameter.index') }}">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

{{-- SCRIPT LENGKAP UNTUK LOGIKA DINAMIS --}}
<script>
$(document).ready(function () {
    // Konfigurasi dasar
    const select2Options = { placeholder: "Select an option", allowClear: true };
    $('.select2').select2(select2Options);

    // Definisi elemen-elemen penting
    const subjectSelect = $('#subject_select');
    const samplingSection = $('#sampling_section');
    const samplingTimeContainer = $('#sampling_time_container');
    const regulationClassSection = $('#regulation_class_section'); // 🔌 Definisikan elemen baru

    // Fungsi untuk menampilkan/menyembunyikan section "Sampling Time"
    function toggleSamplingSection() {
        const subjectCode = subjectSelect.find('option:selected').data('code');
        const isAmbientAir = String(subjectCode).trim() === '01';

        if (isAmbientAir) {
            samplingSection.show();
            samplingSection.find('.sampling-input').prop('required', true);
        } else {
            samplingSection.hide();
            samplingSection.find('.sampling-input').prop('required', false);
        }
    }

    // ✅ Fungsi BARU untuk menampilkan/menyembunyikan section "Regulation per Class"
    function toggleRegulationClassSection() {
        const subjectCode = String(subjectSelect.find('option:selected').data('code')).trim();
        // Tampilkan hanya jika subject code adalah '08' (Wastewater) atau '10' (Surface Water)
        const requiredCodes = ['08', '10'];

        if (requiredCodes.includes(subjectCode)) {
            regulationClassSection.show();
        } else {
            regulationClassSection.hide();
        }
    }

    // --- EVENT LISTENER ---
    subjectSelect.on('change', function () {
        // Panggil kedua fungsi saat subject berubah
        toggleSamplingSection();
        toggleRegulationClassSection(); // Panggil fungsi baru
    });

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
                <div class="col-md-2"><button type="button" class="btn btn-danger remove-row">X</button></div>
            </div>`;

        const newRow = $(newRowHtml);
        samplingTimeContainer.append(newRow);
        newRow.find('.select2').select2(select2Options);
        if (samplingSection.is(":visible")) {
            newRow.find('.sampling-input').prop('required', true);
        }
    });

    samplingTimeContainer.on('click', '.remove-row', function () {
        $(this).closest('.row').remove();
    });

    // --- PANGGILAN AWAL ---
    // Panggil kedua fungsi saat halaman dimuat untuk mengatur tampilan awal yang benar
    toggleSamplingSection();
    toggleRegulationClassSection(); // Panggil fungsi baru
});
</script>
@endsection
