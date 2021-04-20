<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{

    protected $table = 'post_images';

    public $timestamps = false;


    public function getURL(){
        if(starts_with($this->image_path,'http')){
            return url($this->image_path);
        }else{
            return url('storage/uploads/posts/'.$this->image_path);
        }
    }

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}