<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Image;

class Album extends Model /*Eloquent*/ {
    
    protected $table = 'albums';
  
    protected $fillable = array('name','description','cover_image');
  
    public function Photos() {
        return $this->hasMany(Image::class);
    }
}

