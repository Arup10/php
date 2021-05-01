@extends('layout.frame')


@section('content')
<div class="card-header">
    <div class="d-flex justify-content-end">
        <p class="px-3">Welcome, {{$name}}</p>
        <button class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Logout" onclick="window.location='{{ route('welcome')}}'">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </div>
    <div class="col-lg-2 mb-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <a href="{{route('users.soldIpList')}}" class="btn btn-primary">View Sold Ip List</a>
            </div>
        </div>
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <a href="{{route('users.unsoldIpList')}}" class="btn btn-primary">View Unsold Ip List</a>
            </div>
        </div>
    </div>

</div>
@endsection