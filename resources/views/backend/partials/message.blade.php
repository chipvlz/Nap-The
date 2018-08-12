@if(session()->has('success'))
    <div class="alert alert-success alert-dismissable" style="    border: none;border-radius: 0px;padding: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="right: 3px; text-decoration: none">&times;</a>
        <strong>Success!</strong> {{session()->get('success')}}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissable" style="    border: none;border-radius: 0px;padding: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="right: 3px; text-decoration: none">&times;</a>
        <strong>Error!</strong> {{$errors->first()}}
    </div>
@endif