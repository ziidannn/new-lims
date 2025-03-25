@extends('layouts.master')
@section('title', 'Change Password')

<style>
    body,
    html {
        height: 100%;
        margin: 0;

    }
    .container-centered {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .form-container {
        width: 100%;
        max-width: 610px;
        padding: 33px;
        border: 1px solid #ccc;
        border-radius: 15px;
        background-color: #ffffff;
    }
    .text-right {
        text-align: right;
    }
</style>

@section('content')
<div class="container-centered">
    <div class="form-container">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="{{ url('/') }}"><img class="img-fluid" src="" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <h2 ><b>Change Director</b></h2>
        <br>
         
        {{-- <div class="alert alert-success">
            
        </div>
        <div class="alert alert-danger">
            <ul>
               
                <li></li>
                
            </ul>
        </div> --}}
        @can('director.update')
        <form action="{{ route('director.edit', $director->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <div class="form-group text-center">
                <label for="current_password">Current Director:</label>
                @foreach($data as $director)
                    <h4 class="text-center">{{ $director->name }}</h4> 
                @endforeach
            </div>
        
            <br>
            <div class="form-group">
                <label for="name">New Director:</label>
                <input type="text" class="form-control" id="name" name="name" required
                    placeholder="Enter the new director's name">
            </div>
        
            <br>
            <div class="form-group">
                <label for="ttd"> New Signatures:</label>
                <input type="file" class="form-control" id="ttd"
                    name="ttd" required placeholder="Upload Your New Signature"
                    accept="image/png, image/jpeg">
            </div>
        
            <br>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        @endcan
    </div>
</div>
@endsection
