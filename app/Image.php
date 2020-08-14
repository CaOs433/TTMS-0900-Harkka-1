<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Album;

class Image extends Model /*Eloquent*/ {

    protected $table = 'images';

    protected $casts = [
        'keywords' => 'array',
        'exif' => 'array',
        'iptc' => 'array',
    ];
  
    protected $fillable = array('album_id', 'title', 'description', 'copyright', 'keywords', 'exif', 'iptc', 'image');
    
}

