@extends('layout.frame')


@section('content')
<div class="col-lg-6 mb-4">
    <form name="user-login" id="user-login" method="post" action="{{route('users.loginPage')}}">
        @csrf
        <div class="input-group py-2">
            <input type="text" class="form-control bg-light border-2 small " placeholder="email" id="email" name="email" required="true" aria-label="Search" aria-describedby="basic-addon2">
        </div>
        <div class="input-group py-2">
            <input type="password" class="form-control bg-light border-2 small" placeholder="password" id="password" name="password" required="true" aria-label="Search" aria-describedby="basic-addon2">
        </div>
        <div class="input-group-append py-2">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
    @if(session('incorrectCreds'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Invalid Credential! Please try with the correct one!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

</div>
@endsection