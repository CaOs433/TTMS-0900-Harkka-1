@extends('layouts.app')

@section('content')
<!--div class="navbar navbar-dark bg-dark fixed-top navbar-expand-md">
    <!--div class="navbar navbar-inverse navbar-fixed-top"-- >
    <div class="container">
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".nav-collapse">&#x2630;</button>
        <!--button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse"-- >
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button-- >
        <a class="navbar-brand" href="{{URL::route('index')}}">Gallery</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <!--li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li-- >
                <li class="nav-item">
                    <a href="{{URL::route('create_album_form')}}" class="nav-link">Create New Album</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</div-->

<div class="container">

    <div class="starter-template">

        <div class="row">
            @foreach($albums as $album)
            <div class="col-lg-3">
                <div class="card" style="min-height: auto;">
                    <img class="card-img-top" alt="{{$album->name}}" src="{{URL::asset('albums')}}/{{$album->cover_image}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$album->name}}</h5>
                            <p class="card-text">
                                {{$album->description}}<br>
                                {{count($album->Photos)}} image(s).<br>
                                Created date: {{ date("d F Y",strtotime($album->created_at)) }} at {{date("g:ha",strtotime($album->created_at)) }}
                            </p>
                            <p><a href="{{URL::route('show_album',array('id'=>$album->id))}}" class="btn btn-primary">Show Album</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div><!-- /.container -->
</div>
@endsection