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

    public function indexV2() {
        return view('indexV2');
    }

    public function checkUserRegStatus() {
        $email = Session::get('email');

        if ($email == null) {
            /*if session not existed*/
            return response()->json([
                'message' => 'Session does not exist', 
                'sessionExist' => false
            ]);
        } else {
            /*if session existed*/
            $count = Participant::where('email', $email)
                ->where('isRegistered', true)
                ->count();

            if ($count == 0) {
                /*If user not registered*/
                return response()->json([
                    'message' => 'Participant not registered yet', 
                    'sessionExist' => true,
                    'isRegistered' => false
                ]);
            } else {
                /*If user registered*/
                $count = Participant::where('email', $email)
                    ->where('isRegistered', true)
                    ->where('isFirstTimeUser', true)
                    ->count();
                if ($count) {
                    /*If user is first time user*/
                    return response()->json([
                        'message' => 'Participant is first time user',
                        'sessionExist' => true,
                        'isRegistered' => true,
                        'isFirstTimeUser' => true]);
                } else {
                    /*If user is not first time user*/
                    return response()->json([
                        'message' => 'Participant is existing user',
                        'sessionExist' => true,
                        'isRegistered' => true,
                        'isFirstTimeUser' => false]);
                }
            }
        }
    }

    public function login(Request $request) {
        /*Retrieve data pass from request*/
        $email = $request->email;
        $password = bcrypt($request->password);

        /*Validate credentials*/
        $count = Participant::where('email', $email)->where('password', $password)->count();

        if ($count) {
            /*If credential valid, set user session*/
            Session::put('email', $request->email);
            return response()->json(['message' => 'User is logged in']);
        } else {
            return response()->json(['message' => 'Invalid credential, please try again']);
        }
    }

    public function register(Request $request) {
        /*Retrieve data pass from request*/
        $username = trim($request->username);
        $email = trim($request->email);
        $password = trim($request->password);
        $icno = trim($request->icno);
        $mobile = trim($request->mobile);

        /*Determine whether email is unique*/
        $count = Participant::where('email', $email)->count();

        if ($count) {
            /*User registered before with this email address*/
            return response()->json(['message' => 'User existed, please try another email address']);
        } else {
            /*Determine whether user's identification number is unique*/
            $count = Participant::where('icno', $icno)->count();

            if ($count) {
                /*Identification number is not unique*/
                return response()->json(['message' => 'Your identification number already registered']);
            } else {
                /*Create participant if user checking is ok*/
                Participant::create([
                    'username' => $username, 
                    'email' => $email, 
                    'password' => bcrypt($password), 
                    'icno' => $icno,
                    'mobile' => $mobile,
                    'isRegistered' => true
                ]);

                /*Set session for user*/
                Session::put('email', $email);

                return response()->json(['message' => 'User successfully register!']);
            }
        }
    }

    public function randomInstantReward() {
        $totalInstantRewardCount = Prize::where('type', 'instant')->count();

        $randNum = rand($totalInstantRewardCount);

        $prize = Prize::find($randNum);

        return response()->json(['message' => 'Your prize is ' . $prize->item]);
    }

    public function clearSession() {
        Session::flush();

        return response()->json(['message' => 'Session cleared']);
    }

    /*public function index() {
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
        var_dump($request);
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
    }*/


}
