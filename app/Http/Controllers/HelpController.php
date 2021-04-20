<?php 
namespace App\Http\Controllers;
 
//use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Response;
use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
class HelpController extends Controller
{
 
    public function index()
    {
        return view('help');
    }

    public function postIndex(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $input = json_decode($data['data'], true);
        $result = array();
        $result['code'] = 400;
        $result['message'] = 'Something Went Wrong!';

        $name = $input['name'];
        $email = $input['email'];
        $subject = $input['subject'];
        $content = $input['message'];
        $recaptcha = $input['g-recaptcha-response'];

        $client = new \GuzzleHttp\Client;
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'=>env('GOOGLE_RECAPTCHA_SECRET'),
                    'response'=>$recaptcha
                 ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        if($body->success){
            try{
                Mail::send('emails.helpmail', ['subject' => $subject, 'content' => $content], function ($m) use($email,$name)
                {

                    $m->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                    $m->to(Config::get('mail.from.address'), Config::get('mail.from.name'));
                    $m->replyTo($email, $name);

                });

                $result['code'] = 200;
                $result['message'] = 'Thank You!</br>We Will Get Back To You Soon..!';
            }
            catch (\Exception $e) {
                $result['message'] = 'Unable To Send Mail!';
            }

        }else{
            $result['message'] = 'Recaptcha Validation Failed!';
        }
        return Response::json($result);
    }
    
}