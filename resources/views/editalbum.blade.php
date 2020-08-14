@extends('layouts.app')

@section('content')

<div class="container" style="text-align: center;">

    <div class="span4" style="display: inline-block;margin-top:20px;">

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

        <form name="editalbum" method="POST" action="{{URL::route('edit_album')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
                <legend>Edit <strong>{{$album->name}}</strong></legend>
                <img class="card-img-top" alt="{{$album->name}}" src="{{ URL::asset('albums') }}/{{$album->cover_image}}">
                <div class="form-group">
                    <label for="name">Album Name</label>
                    <input name="name" type="text" class="form-control" placeholder="{{$album->name}}" value="{{Input::old('name')}}">
                </div>
                <div class="form-group">
                    <label for="description">Album Description</label>
                    <textarea name="description" type="text" class="form-control" placeholder="{{$album->description}}">{{Input::old('descrption')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="cover_image">Select a Cover Image</label>
                    {{Form::file('cover_image')}}
                </div>
                <input type="hidden" name="album_id" value="{{$album->id}}" />
                <button type="submit" class="btn btn-primary">Save</button>
            </fieldset>
        </form>
    </div>


    <div class="row">
        @foreach($album->Photos as $photo)
        <div class="col-xl-3">
            <div class="card" style="max-height: 500px; min-height: 350px;">
                <img class="card-img-top" alt="{{$album->name}}" src="{{ URL::asset('albums') }}/{{$photo->image}}">
                <div class="card-body">
                    <h5 class="card-title">{{$album->name}}</h5>
                    <p class="card-text">
                        {{$photo->description}}<br>
                        Created date: {{ date("d F Y",strtotime($photo->created_at)) }} at {{ date("g:ha",strtotime($photo->created_at)) }}<br>
                        <a class="card-link" href="{{URL::route('delete_image',array('id'=>$photo->id))}}" onclick="returnconfirm('Are you sure?')"><button type="button" class="btn btn-danger btn-small">Delete Image</button></a><br>
                        Move image to another Album :
                        <form name="movephoto" method="POST" action="{{URL::route('move_image')}}">
                            <select name="new_album">
                                @foreach($albums as $others)
                                <option value="{{$others->id}}">{{$others->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="photo" value="{{$photo->id}}" />
                            <button type="submit" class="btn btn-small btn-info" onclick="return confirm('Are you sure?')">Move Image</button>
                        </form>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection