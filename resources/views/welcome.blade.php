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
    @if($credsOK)
    <script>
        $('#exampleModalCenter').modal('show');
    </script>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Wrong Credential</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please try again</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection