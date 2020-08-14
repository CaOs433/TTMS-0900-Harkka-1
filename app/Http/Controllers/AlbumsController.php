<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Album;
use App\Image;
use View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as ImageM;

class AlbumsController extends Controller {
    // Get albums page
    public function getList() {
        // Get all albums data
        $albums = Album::with('Photos')->get();
        // Return albums data with the albums page
        return View::make('index')->with('albums', $albums);
    }

    // Get a album page
    public function getAlbum($id) {
        // Get album data with included images
        $album = Album::with('Photos')->find($id);
        // Get all albums data
        $albums = Album::with('Photos')->get();
        // Items per page for paginate func
        $pageCount = (isset($_GET['pageCount']) && is_numeric($_GET['pageCount'])) ? $_GET['pageCount'] : 32;
        // Get all images in the album
        $photos = Image::where('album_id', '=', $id)->paginate($pageCount);

        // Return album page with album and image data
        return View::make('album')
            ->with('album', $album)
            ->with('albums', $albums)
            ->with('photos', $photos);
    }

    // Get new album form
    public function getForm() {
        // Return new album form
        return View::make('createalbum');
    }

    // Make new album
    public function postCreate() {
        // Request validation check
        $validator = Validator::make(Request::all(), [
            'name' => 'required',
            'cover_image' => 'required|image',
            'cover_image.*' => 'mimes:jpg,jpeg,JPG,JPEG'
        ]);
        if ($validator->fails()) {
            return Redirect::route('create_album_form')
                ->withErrors($validator)
                ->withInput();
        }

        // Make random name for the album
        $random_name = Str::random(8);
        // Make final file name from random string and default endfix
        $filename = $random_name . '_cover.jpg';
        // Save image to albums/ folder
        Request::file('cover_image')->move('albums/', $filename);

        // Resize the image
        ImageM::make("albums/{$filename}")
            ->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save("albums/{$filename}", 95);

        // Save album data to database
        $album = Album::create(array(
            'name' => Request::get('name'),
            'description' => Request::get('description'),
            'cover_image' => $filename,
        ));

        // Redirect to the new album page
        return Redirect::route('show_album', array('id' => $album->id));
    }

    // Get edit form
    public function getEditForm($id) {
        // Get album data with images data
        $album = Album::with('Photos')->find($id);
        // Get all albums data
        $albums = Album::get();

        // Return edit form with album data
        return View::make('editalbum')
            ->with('album', $album)
            ->with('albums', $albums);
    }

    // Edit album
    public function postEdit() {
        // Request validation check
        $validator = Validator::make(Request::all(), [ 'album_id' => 'required' ]);
        if ($validator->fails()) {
            return Redirect::route('edit_album_form')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Get album
        $album = Album::find(Request::post('album_id'));

        // Loop all request data and update new values to album
        foreach (Request::all() as $key => $val) {
            switch ($key) {
                case 'name': $album->name = $val; break;
                case 'description': $album->description = $val; break;
                case 'cover_image':

                    $random_name = Str::random(8);
                    $filename = $random_name . '_cover.jpg';
                    Request::file('cover_image')->move('albums/', $filename);

                    ImageM::make("albums/{$filename}")
                        ->resize(700, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->save("albums/{$filename}", 95);

                    $album->cover_image = $filename; break;

                default: break;
            }
        }

        // Save updated values to database
        $album->save();

        // Redirect to the edited album
        return Redirect::route('show_album', array('id' => $album->id));
    }

    // Delete album from database
    public function getDelete($id) {
        // Find the album
        $album = Album::find($id);
        // Delete album from database
        $album->delete();

        // Redirect to front page
        return Redirect::route('index');
    }
}
