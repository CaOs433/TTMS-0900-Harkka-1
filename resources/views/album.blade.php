@extends('layouts.app')

@section('content')

<div class="container">

    <div class="starter-template">
        <div class="media">
            <!--media-object float-left-->
            <img class="align-self-start mr-3" alt="{{$album->name}}" src="{{ URL::asset('albums') }}/{{$album->cover_image}}" width="">
            <div class="media-body">
                <h2 class="media-heading" style="font-size: 26px;">Album Name:</h2>
                <p>{{$album->name}}</p>
                <h2 class="media-heading" style="font-size: 26px;">AlbumDescription :</h2>
                <p>{{$album->description}}</p>
                <a href="{{URL::route('add_image',array('id'=>$album->id))}}"><button type="button" class="btn btn-primary btn-large">Add New Image to Album</button></a>
                <a href="{{URL::route('delete_album',array('id'=>$album->id))}}" onclick="return confirm('Are yousure?')"><button type="button" class="btn btn-danger btn-large">Delete Album</button></a>
            </div>
        </div>
        <hr>
        <div class="row" id="gallery" data-toggle="modal" data-target="#photoModal">
            @foreach($album->Photos as $photo)
            <div class="col-lg-3">
                <div class="card" style="max-height: 500px; min-height: 350px;">
                    <img class="card-img-top" alt="{{$album->name}}" src="{{ URL::asset('albums') }}/{{$photo->image}}" data-target="#carouselModal" data-slide-to="{{$loop->index}}">
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
                <!--<diva class="card" style="min-height: auto;">
                    <img class="card-img-top" alt="{{$album->name}}" src="{{URL::asset('albums')}}/{{$album->cover_image}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$album->name}}</h5>
                            <p class="card-text">
                                {{$album->description}}<br>
                                {{count($album->Photos)}} image(s).<br>
                                Created date: {{ date("d F Y",strtotime($album->created_at)) }} at {{date("g:ha",strtotime($album->created_at)) }}
                            </p>
                            <p><a href="{{URL::route('show_album',array('id'=>$album->id))}}" class="btn btn-primary">Show Gallery</a></p>
                    </div>
                </diva>-->
            </div>
            @endforeach

        </div>
        <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselModal" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($album->Photos as $photo)

                                @if ($loop->first)
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{ URL::asset('albums') }}/{{$photo->image}}">
                                </div>
                                @else
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ URL::asset('albums') }}/{{$photo->image}}">
                                </div>
                                @endif

                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselModal" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselModal" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        {{ $photos->links() }}
    </div>
</div>


</div>
@endsection