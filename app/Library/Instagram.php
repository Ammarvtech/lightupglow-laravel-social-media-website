<?php
/**
 * Created by aiyash ahmed/srilanka.
 * Date: 02/06/2020.
 */
namespace App\Library;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Models\Post;
use Auth;


class Instagram{
    /**
     * instagram connection
     * login with instagram and save all the data to lightup db.
     * return : if success returns true.
     */
    public function connect($code){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => '596731891177726',
                'app_secret' => '092d2628e31cdac6189ee08c3203dc9e',
                'grant_type' => 'authorization_code',
                'redirect_uri' => 'https://lightupglo.com/auth/instagram/callback',
                'code' => $code,
            ]
        ]);
        $datas = json_decode($response->getbody()->getContents());
        $accessToken = $datas->access_token;
        $userId = $datas->user_id;

        $response = $client->request('GET','https://graph.instagram.com/me/media?fields=id,caption&access_token='.$accessToken);
        $datas = json_decode($response->getbody()->getContents(),true);
        $next = $datas['paging']['next'];
        $next ? $this->nextUrl($next,$accessToken,$userId) : false;
        $x = 0;
        foreach($datas['data'] as $data){
            $id = $data['id'];
            $caption = $data['caption'];
            
            $posts[] = [
                'id' => $id,
                'caption' => $caption
            ];
        }

        return $this->makeOne($posts,$accessToken,$userId);        
    }

    private function nextUrl($next,$accessToken,$userId){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET',$next);
        $datas = json_decode($response->getbody()->getContents(),true);
        $i = 0;
        $next = $datas['paging']['next'];
        $next ? $this->nextUrl($next) : false;
        $posts = array();
        foreach($datas['data'] as $data){
            $caption = $data['caption'];
            $id = $data['id'];

            $posts[] = [
                'id' => $id,
                'caption' => $caption
            ];
        }
        $this->makeOne($posts,$accessToken,$userId);
    }

    private function makeOne($posts,$accessToken,$userId){
        $client = new \GuzzleHttp\Client();
        // print_r($posts); die;
        foreach($posts as $post){
            $response = $client->request('GET','https://graph.instagram.com/'.$post['id'].'?fields=id,media_type,media_url,username,timestamp&access_token='.$accessToken);
            $datas = json_decode($response->getbody()->getContents());
            
            $url = $datas->media_url;
            $type = $datas->media_type;
            $username = $datas->username;

            $instaPosts[] = [
                'url' => $url,
                'type' => $type,
                'u_name' => $username 
            ];
        }
        
        $i = 0;
        foreach($posts as $post){
            foreach($instaPosts[$i] as $key=>$value){
                $posts[$i][$key] = $value;
            }
            $i++;
        }
        print_r($posts);
        return $this->createPost($posts,$accessToken,$userId);
    }

    /**
     * add to database
     */
    private function createPost($posts,$accessToken,$userId){
        $post = new Post;
        return $post->createInstagramPost($posts,$accessToken,$userId);        
    }
}
?>