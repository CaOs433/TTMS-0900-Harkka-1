<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Album;
use App\Image;
use Hamcrest\Type\IsNumeric;
use View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageM;
//use Intervention\Image\Imagick;

class ImagesController extends Controller {
    // Get form to add images to specific album
    public function getForm($id) {
        // Get data of the album
        $album = Album::find($id);
        // Return form page
        return View::make('addimage')->with('album', $album);
    }

    // Get form to add images to any album
    public function getFormFree() {
        // Get data of all albums
        $albums = Album::get();
        // Return form page
        return View::make('addimagefree')->with('albums', $albums);
    }

    // Add new image to an album
    public function postAdd() {
        // Request validation check
        $validator = Validator::make(Request::all(), [
            'title' => 'required_without_all:iptc_title',
            'description' => 'required_without_all:iptc_description',
            'swords' => 'required_without_all:iptc_swords'
        ], [
            'required_without_all' => __( 'At least line is required' ),
            'min'                  => __( 'Your input should be at least :min characters' ),
            'max'                  => __( 'Your input cannot be more than :max characters' ),
            'title.regex' => 'Use only English alphabets and numbers, MAX. 50 chars!',
            'description.regex' => 'Use only English alphabets and numbers, MAX. 500 chars!',
            'swords.regex' => 'Use only English alphabets and numbers, MAX. 500 chars!',
        ] );
        // Validation parameters for title
        $validator->sometimes(
            'title',
            'required|string|min:3|max:50|regex:/^[a-zA-Z0-9 ]{0,50}$/',
            function ( $input ) {
                return ! empty( $input->title );
            }
        );
        // Validation parameters for description
        $validator->sometimes(
            'description',
            'required|string|min:3|max:500|regex:/^[a-zA-Z0-9 ]{0,50}$/',
            function ( $input ) {
                return ! empty( $input->description );
            }
        );
        // Validation parameters for swords
        $validator->sometimes(
            'swords',
            'required|string|min:3|max:500|regex:/^[a-zA-Z0-9 ]{0,50}$/',
            function ( $input ) {
                return ! empty( $input->swords );
            }
        );
        // Validate
        $validator->validate();

        // Make random name for the image
        $random_name = Str::random(8);
        // Get album id
        $albumId = Request::get('album_id');
        // Make final file name from random string and default endfix with album id
        $filename = $random_name . "_album_{$albumId}_img.jpg";
        // Save image to albums/ folder
        $uploadSuccess = Request::file('image')->move('albums/', $filename);

        // Resize the image and add watermark
        $img = ImageM::make("albums/{$filename}")
            ->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->insert('watermark.png')
            ->save("albums/{$filename}", 100);
        
        // Get the image IPTC metadata if any
        $keywordsIPTC = (!is_null($img->iptc('keywords'))) ? $img->iptc('keywords') : [];
        // Get keywords and convert them to Array
        $swordsArr = explode(" ", Request::get('swords'));
        // Add the IPTC keywords to the keywords Array if any
        if (is_array($keywordsIPTC) || is_object($keywordsIPTC)) {
            foreach ($keywordsIPTC as $word) {
                array_push($swordsArr, $word);
            }
        }
        // Remove keyword dublicates
        $swordsArr = array_unique($swordsArr);
        // Encode keywords to JSON format
        $keywords = json_encode($swordsArr)/*(object)[];$keywords->words = ['word', 'word2'];$keywords->exif = $img->exif();$keywords->iptc = $img->iptc()*/;
        // Get image EXIF metadata if any
        $exif = ($img->exif()) ? $img->exif() : (object)[];
        // Get image IPTC metadata if any
        $iptc = ($img->iptc()) ? $img->iptc() : (object)[];
        // Get copyright owner. If not provided in request, check is it included to IPTC, if not, set "Unknown"
        $copyright = (!is_null(Request::get('copyright'))) ? Request::get('copyright') : ((!is_null($img->iptc('copyright'))) ? $img->iptc('copyright') : "Unknown");
        // Get title. If not provided in request, check is it included to IPTC, if not, set "Unknown"
        $title = (!is_null(Request::get('title'))) ? Request::get('title') : ((!is_null($img->iptc('title'))) ? $img->iptc('title') : "Unknown");
        // Get description. If not provided in request, check is it included to IPTC, if not, set "Unknown"
        $description = (!is_null(Request::get('description'))) ? Request::get('description') : ((!is_null($img->iptc('caption'))) ? $img->iptc('caption') : "Unknown");
        
        // Save image data to database
        Image::create(array(
            'description' => $description,
            'image' => $filename,
            'album_id' => Request::get('album_id'),
            'keywords' => json_encode($keywords),
            'exif' => json_encode($exif),
            'iptc' => json_encode($iptc),
            'copyright' => $copyright,
            'title' => $title
        ));
        
        if(!empty($profiles)) {
            $img->profileImage("icc", $profiles['icc']);
        }

        // Redirect to album of the new image
        return Redirect::route('show_album', array('id' => Request::get('album_id')));
        //return Redirect::route('index');
    }

    // Delete image
    public function getDelete($id) {
        // Find the image
        $image = Image::find($id);
        // Delete the image from database
        $image->delete();

        // Redirect to album page of the deleted image
        return Redirect::route('show_album', array('id' => $image->album_id));
    }

    // Move image to another album
    public function postMove() {
        // Request validation check
        $validator = Validator::make(Request::all(), [
            'new_album' => 'required|numeric|exists:albums,id',
            'photo' => 'required|numeric|exists:images,id'
        ]);

        // Redirect to index.blade.php if the validation fails
        if ($validator->fails()) {
            return Redirect::route('index');
        }

        // Find the image
        $image = Image::find(Request::get('photo'));
        // Change the album id to the new one
        $image->album_id = Request::get('new_album');
        // Save changes
        $image->save();
        
        // Redirect to the new album
        return Redirect::route('show_album', array('id' => Request::get('new_album')));
    }

    // Search images from all albums by keyword
    public function search() {
        // Request validation check
        Validator::make(Request::all(),
            [ 'sword' => 'nullable|string|regex:/^[a-zA-Z0-9 ]{0,100}$/' ], 
            [ 'sword.regex' => 'Use only English alphabets and numbers, MAX. 100 chars!', ]
        )->validate();

        // Items per page for paginate func
        $pageCount = (isset($_GET['pageCount']) && is_numeric($_GET['pageCount'])) ? $_GET['pageCount'] : 32;

        // Check is the search word set and return all images if not
        if (isset($_GET['sword']) && $_GET['sword'] != "") {
            $word = request('sword');
            $results = Image::where('keywords', 'like', "%{$word}%")->paginate($pageCount);
        } else {
            $results = Image::paginate($pageCount);
        }
        
        // All albums
        $albums = Album::with('Photos')->get();
        
        // Return results and albums data with the results page
        return view('search')
            ->with('results', $results)
            ->with('albums', $albums);
    }
}







#SELECT * FROM images WHERE keywords->"$" LIKE 'word';

#SELECT * FROM images
#WHERE JSON_CONTAINS(keywords, 'word', '$');

/*$img = new \Imagick(realpath("albums/{$filename}"));
$profiles = $img->getImageProfiles("icc", true);
$img->stripImage();*/


//Old validation code for postAdd func:
/*$validator = * /Validator::make(
    Request::all(),
    [
        'album_id' => 'required|numeric|exists:albums,id',
        'image' => 'required|image',
        'image.*' => 'mimes:jpg,jpeg,JPG,JPEG',
        'title' => ['required_without:iptc_title|max:50', 'regex:/^[a-zA-Z0-9 ]$/'],
        'description' => ['required_without:iptc_description|max:500', 'regex:/^[a-zA-Z0-9 ]$/'],
        'swords' => ['required_without:iptc_swords|max:500', 'regex:/^[a-zA-Z0-9 ]$/'],
    ],
    [
        'title.regex' => 'Use only English alphabets and numbers, MAX. 50 chars!',
        'description.regex' => 'Use only English alphabets and numbers, MAX. 500 chars!',
        'swords.regex' => 'Use only English alphabets and numbers, MAX. 500 chars!',
    ]
)->validate();

if ($validator->fails()) {
    $url = url()->previous();
    $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();

    if ($route == 'add_image') {
        return Redirect::route('add_image', array('id' => Request::get('album_id')))
            ->withErrors($validator)
            ->withInput();
    } else if ($route == 'addimage') {
        return Redirect::route('add_image_free')
            ->withErrors($validator)
            ->withInput();
    } else {
        return Redirect::route('index');
    }
}*/


// Old search validation
/*Validator::make(
    Request::all(),
    [
        'sword' => [/*'required',* /
            'regex:/^[a-zA-Z0-9 ]{0,100}$/'
        ],
    ],
    [
        'sword.regex' => 'Use only letters from A to Z and numbers 0 to 9!',
    ]
)->validate();*/