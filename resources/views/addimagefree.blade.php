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
        <form name="addimagetoalbum" method="POST" action="{{URL::route('add_image_free')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!--input type="hidden" name="album_id" value="{album->id}" /-->
            <fieldset>
                <legend>Upload new image</legend>
                <div class="form-group">
                    <section class="section-preview">
                        <img id="preview_img" src="" style="display: none" width="100%" height="auto" />
                        <div class="input-group my-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="inputGroupFile01" onchange="loadPreview(this);" aria-describedby="inputGroupFileAddon01" required>
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </section>
                </div>
                <hr>
                <div class="form-group">
                    <label for="album_id" style="float: left;">Choose Album:</label>
                    <select name="album_id" class="form-control" required>
                        @foreach($albums as $album)
                        @if($loop->first)
                        <option value="{{$album->id}}" selected>{{$album->name}}</option>
                        @else
                        <option value="{{$album->id}}">{{$album->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <hr>
                <div class="form-group">
                    <label for="title" style="float: left;">Image Title</label>
                    <input maxlength="50" name="title" type="text" class="form-control" placeholder="Image Title" value="{{old('title')}}">
                </div>
                <fieldset class="form-group">
                    <div class="form-check" style="float: left;">
                        <input class="form-check-input" type="radio" id="iptc_title" name="iptc_title" value="iptc">
                        <label class="form-check-label" for="iptc_title">Use IPTC (Don't check if IPTC not set!)</label>
                    </div>
                </fieldset>
                <hr>
                <div class="form-group">
                    <label for="description" style="float: left;">Image Description</label>
                    <textarea maxlength="500" name="description" type="text" class="form-control" placeholder="Image Description">{{old('description')}}</textarea>
                </div>
                <fieldset class="form-group">
                    <div class="form-check" style="float: left;">
                        <input class="form-check-input" type="radio" id="iptc_description" name="iptc_description" value="iptc">
                        <label class="form-check-label" for="iptc_description">Use IPTC (Don't check if IPTC not set!)</label>
                    </div>
                </fieldset>
                <hr>
                <div class="form-group">
                    <label for="swords" style="float: left;">Search Words</label>
                    <textarea maxlength="500" name="swords" type="text" class="form-control" placeholder="Search Words">{{old('swords')}}</textarea>
                </div>
                <fieldset class="form-group">
                    <div class="form-check" style="float: left;">
                        <input class="form-check-input" type="radio" id="iptc_swords" name="iptc_swords" value="iptc">
                        <label class="form-check-label" for="iptc_swords">Use IPTC (Don't check if IPTC not set!)</label>
                    </div>
                </fieldset>
                <hr>

                <button type="submit" class="btn btn-success" style="float: right;">Upload</button>
            </fieldset>
        </form>
    </div>
</div> <!-- /container -->

@endsection