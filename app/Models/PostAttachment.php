<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{

    protected $table = 'post_attachments';

    public $timestamps = false;


    public function getURL(){
        return url('storage/uploads/posts/'.$this->attachment_path);
    }

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}