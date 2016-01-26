<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Participant;
use Session;
use DB;
use Storage;
use Input;

class CampaignController extends Controller
{
    public function index() {
        $username = Session::get('social_id');

        if ($username != null) {

        } else {
            return view('index');
        }

        return view('index');
    }

    public function userExistence() {
        return response()->json(['social_id' => Session::get('social_id')]);
    }

    public function createParticipant(Request $request) {
        $count = Participant::where('email', $request->email)->count();

        if ($count > 0) {
            Session::put('social_id', $request->social_id);

            return response()->json(['message' => 'Email registered']);
        } else {
            $participant = new Participant;
            $participant->email = $request->email;
            $participant->username = $request->username;
            $participant->social_id = $request->social_id;
            $participant->question_id = $request->question_id;
            $participant->save();

            Session::put('social_id', $request->social_id);

            return response()->json(['message' => '']);
        }
    }  

    public function checkUserRegistrationStatus(Request $request) {
        $social_id = $request->social_id;

        $count = Participant::where('social_id', $social_id)->where("isRegistered", true)->count();

        if ($count > 0) {
            return response()->json(['message' => 'User registered', 'isRegistered' => true]);
        } else {
            return response()->json(['message' => 'User havent register', 'isRegistered' => false]);
        }
    }

    public function registerUser(Request $request) {
        $social_id = $request->social_id;
        $icno = $request->icno;
        $mobile = $request->mobile;
        $photo = $request->photo;

        $dest = public_path('photo/');

        $extension = Input::file('photo')->getClientOriginalExtension();

        $unique = false;

        while(!$unique) {
            $fileName = trim(rand(111111, 999999) . '.' . $extension);

            $count = Participant::where('photo', $fileName)->count();

            if ($count) {
                $unique = false;
            } else {
                $unique = true;
            }
        }

        Input::file('photo')->move($dest, $fileName);

        Participant::where('social_id', $social_id)
            ->update([
                'ic' => $icno, 
                'mobile' => $mobile, 
                'isRegistered' => true,
                'photo' => $fileName,
            ]);

        return response()->json(['message' => 'User registered', 'isRegistered' => true]);
    }

    public function checkUserUploadingPhotoStatus(Request $request) {
        $social_id = $request->social_id;

        $count = Participant::where('social_id', $social_id)->where('photo', '<>', '')->count();

        if ($count > 0) {
            return response()->json(['message' => 'Photo uploaded', 'isUploaded' => true]);
        } else {
            return response()->json(['message' => 'Photo not upload', 'isUploaded' => false]);
        }
    }

    public function clearSession() {
        Session::flush();

        return response()->json(['message' => 'Session flush']);
    }
}
