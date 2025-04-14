@extends('layouts.master')
@section('title', 'Manage Director')

@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
        <div class="col-md-12">
            @if(session('msg'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Card Header Title -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"><b>Manage Directors</b></h3>
                    <hr>

                    {{-- Form untuk Store / Update --}}
                    <form action="{{ route('director.store') }}" method="POST" enctype="multipart/form-data"
                        class="d-inline">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label"><b>Director Name:</b></label>
                            <input type="text" class="form-control p-2" id="name" name="name" required
                                placeholder="Enter director name" value="{{ old('name', $director->name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="ttd" class="form-label"><b>Signature (PNG/JPG):</b></label>
                            <input type="file" class="form-control p-2" id="ttd" name="ttd"
                                accept="image/png, image/jpeg">
                            @if(isset($director->ttd) && !empty($director->ttd))
                            <br>
                            <a href="{{ asset($director->ttd) }}" target="_blank"
                                onclick="openImagePopup(event, '{{ asset($director->ttd) }}')">
                                <img src="{{ asset($director->ttd) }}" width="120px" class="mt-2" alt="Signature">
                            </a>
                            @else
                            <p class="mt-2 text-muted">No Signature Available</p>
                            @endif
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                    {{-- Form untuk Delete, dipisah dari form utama --}}
                    <!-- @if(isset($director))
                    <form action="{{ route('director.destroy', $director->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this director?')">Delete</button>
                    </form>
                    @endif -->
                </div>
            </div>

            <!-- Card 2: Tabel Data Director -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"><b>Current Directors</b></h3>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Signature</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $director->name ?? 'No Data' }}</td>
                                <td>
                                @if(isset($director->ttd) && !empty($director->ttd))
                                    <a href="{{ asset($director->ttd) }}" target="_blank" onclick="openImagePopup(event, '{{ asset($director->ttd) }}')">
                                        <img src="{{ asset($director->ttd) }}" width="120px" class="mt-2" alt="Signature">
                                    </a>
                                @else
                                    <p class="mt-2 text-muted">No Signature Available</p>
                                @endif
                                </td>
                                <td>
                                    @if(isset($director->id))
                                        <form action="{{ route('director.destroy', $director->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this director ( {{ $director->name }} )')">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function openImagePopup(event, imageUrl) {
        event.preventDefault();
        const fileName = imageUrl.split('/').pop(); // Extract file name from URL
        const popup = window.open("", "_blank", "width=600,height=700,scrollbars=no,resizable=no");
        popup.moveTo((screen.width - 600) / 2, (screen.height - 700) / 2); // Center the popup
        popup.document.write(`
            <html>
                <head>
                    <title>${fileName}</title>
                    <style>
                        body {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            margin: 0;
                            height: 100vh;
                            background-color: #f4f4f4;
                        }
                        img {
                            max-width: 100%;
                            max-height: 100%;
                            border: 1px solid #ccc;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                        }
                    </style>
                </head>
                <body>
                    <img src="${imageUrl}" alt="Image Preview">
                </body>
            </html>
        `);
    }

</script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "columns": [{
                    "data": "name"
                },
                {
                    "data": "ttd"
                },
                {
                    "data": null,
                    "defaultContent": "<button class='btn btn-danger'>Delete</button>"
                }
            ]
        });
    });

</script>
