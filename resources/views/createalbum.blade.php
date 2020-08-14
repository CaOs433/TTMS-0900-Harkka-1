@extends('layouts.app')

@section('content')

<div class="container" style="text-align: center;">
    <div class="span4" style="display: inline-block;margin-top:100px;">

        @if($errors->isNotEmpty())
        <div class="alert alert-warning" role="alert" id="error-block">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
            <h4 class="alert-heading">Warning!</h4>
            <ul style="text-align: left;">
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form name="createnewalbum" method="POST" action="{{URL::route('create_album')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
                <legend>Create an Album</legend>
                <div class="form-group">
                    <label for="name">Album Name</label>
                    <input name="name" type="text" class="form-control" placeholder="Album Name" value="{{Input::old('name')}}">
                </div>
                <div class="form-group">
                    <label for="description">Album Description</label>
                    <textarea name="description" type="text" class="form-control" placeholder="Albumdescription">{{Input::old('descrption')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="cover_image">Select a Cover Image</label>
                    {{Form::file('cover_image')}}
                </div>
                <button type="submit" class="btn btn-primary">Create!</button>
            </fieldset>
        </form>
    </div>
</div> <!-- /container -->
@endsection