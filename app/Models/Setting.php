<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'site_settings';

    public $timestamps = false;
 

    public function getJsonAttribute($value){
        $value =  json_decode($value);
        return $value;
    }


}