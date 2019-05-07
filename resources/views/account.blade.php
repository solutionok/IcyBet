@extends('layouts.app')

@section('content')
<div class="col-lg-6 offset-lg-3">
<div class="row align-items-center mb-3 mb-md-4">
    <div class="col-md mb-2 mb-md-0">
        <h1 class="h3 mb-0 text-uppercase">account preferences</h1>
    </div>
</div>

<div class="card">
<div class="card-body p-3 pt-5">

<form action="{{url('account/save')}}" method="post">
@csrf

    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">Full name : </label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-3 col-form-label">Email : </label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="email" value="{{auth()->user()->email}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="phone" class="col-md-3 col-form-label">Phone : </label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="phone" value="{{auth()->user()->phone}}">
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-3 col-form-label">Password : </label>
        <div class="col-md-9">
            <input type="password" class="form-control" name="password" value="{{auth()->user()->password}}" >
        </div>
    </div>

    <div class="form-group row">
        <label for="email_notification" class="col-md-3 col-form-label">Email Notifications</label>
        <div class="col-md-4">
            <select class="form-control" name="email_notification">
                <option value="1" {{auth()->user()->email_notification==1?'selected':''}}>Yes</option>
                <option value="0" {{auth()->user()->email_notification!=1?'selected':''}}>No</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 col-form-label"></label>
        <div class="col-md-9">
            <a class="btn btn-secondary text-white close-account">Deactive</a>
            <button class="btn btn-primary">Update</button>
        </div>
    </div>

</form>
</div>
</div>
</div>

@endsection
@section('scripts')

<script type="text/javascript">
    $(document).on('ready', function() {
        $('.close-account').click(function(){
            Swal.fire({
                title: 'Are you really close your account?',
                text: "This operation can't be undone.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Deactive account'
            }).then((result) => {
                if (result.value && result.value===true) {

                    $.LoadingOverlay("show")

                    $.post(BASE_URL + '/account/cancel', function (r) {

                        $.LoadingOverlay("hide")

                        if(r=='ok'){

                            Swal.fire(
                            'Deactived!',
                            '',
                            'success'
                            ).then(()=>{
                                location.href = BASE_URL+'/logout' ;
                            })
                        }
                    })
                }
            })
        })
    })
</script>
@endsection
