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
                    <form action="{{ route('director.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label"><b>Director Name:</b></label>
                            <input type="text" class="form-control p-2" id="name" name="name" required
                                placeholder="Enter director name" value="{{ old('name', $director->name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="ttd" class="form-label"><b>Signature (PNG/JPG):</b></label>
                            <input type="file" class="form-control p-2" id="ttd" name="ttd" accept="image/png, image/jpeg">
                            @if(isset($director->ttd))
                                <br>
                                <img src="{{ asset($director->ttd) }}" width="120px" class="mt-2" alt="No Signature">
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
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
                                    @if(isset($director->ttd))
                                        <img src="{{ asset($director->ttd) }}" width="100px" alt="No Signature">
                                    @else
                                        No Signature
                                    @endif
                                </td>
                                <td>
                                    @if(isset($director->id))
                                        <form action="{{ route('director.destroy', $director->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="menu-icon tf-icons bx bx-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<<<<<<< HEAD

            <!-- Card Header Title -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"><b>Manage Directors</b></h3>
                    <hr>
                    <form action="{{ route('director.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label"><b>Director Name:</b></label>
                            <input type="text" class="form-control p-2" id="name" name="name" required
                                placeholder="Enter director name" value="{{ old('name', $director->name ?? '') }}">
                        </div>

                        <div class="mb-3">
            
                            <label for="ttd" class="form-label"><b>Upload Signature (Max 15MB):</b></label>
                            <input type="file" class="form-control p-2" id="ttd" name="ttd" accept="image/png, image/jpeg">
                            @if(isset($director->ttd))
                                <br>
                                <img src="{{ asset($director->ttd) }}" width="120px" class="mt-2" alt="Signature">
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            

=======
>>>>>>> b652e3676f0b67f547ee4bcb8002080d380dbbc6
        </div>
    </div>
</div>
@endsection
<script>
    $(document).ready(function() {
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
