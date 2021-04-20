<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostVideo extends Model
{

    protected $table = 'post_videos';

    public $timestamps = false;


    public function getURL(){
        if(starts_with($this->video_path,'<iframe')){
            return $this->video_path;
        }else if(starts_with($this->video_path,'http')){
            return $this->video_path;
        }else{
            return url('storage/uploads/posts/'.$this->video_path);
        }
        
    }

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

}