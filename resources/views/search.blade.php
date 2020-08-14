@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="starter-template">
        @if ($results->isNotEmpty())
        <div class="col-lg-3">
            <h2>{{$results->total()}} results!</h2>
        </div>
        <hr>
        <div class="row" id="gallery" data-toggle="modal" data-target="#photoModal">
            
            @foreach($results as $photo)
            <div class="col-lg-3">
                <div class="card" style="max-height: 500px; min-height: 350px;">
                    <img class="card-img-top" alt="{{$photo->name}}" src="{{ URL::asset('albums') }}/{{$photo->image}}" data-target="#carouselModal" data-slide-to="{{$loop->index}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$photo->name}}</h5>
                        <p class="card-text">
                            {{$photo->description}}<br>
                            Created date: {{ date("d F Y",strtotime($photo->created_at)) }} at {{ date("g:ha",strtotime($photo->created_at)) }}<br>
                            <a class="card-link" href="{{URL::route('delete_image',array('id'=>$photo->id))}}" onclick="returnconfirm('Are you sure?')"><button type="button" class="btn btn-danger btn-small">Delete Image</button></a><br>
                            Move image to another Album :
                            <form name="movephoto" method="POST" action="{{URL::route('move_image')}}">
                                {{ csrf_field() }}
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
                                @foreach($results as $photo)

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
        {{ $results->links() }}
        @else
        <div class="col-lg-3">
            <h1>No results!</h1>
        </div>
        @endif
    </div>
    
</div>


</div>
@endsection