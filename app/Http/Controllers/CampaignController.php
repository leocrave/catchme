<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Participant;

class CampaignController extends Controller
{
    public function index() {
    	return view('index');
    }

    public function createParticipant(Request $request) {
    	$count = Participant::where('email', 'leo@gmail.com')->count();

    	if ($count > 0) {
    		return response()->json(['message' => 'Email registered']);
    	} else {
	    	$participant = new Participant;
	    	$participant->email = $request->email;
	    	$participant->username = $request->username;
	    	$participant->social_id = $request->social_id;
	    	$participant->question_id = $request->question_id;
	    	$participant->save();

	    	return response()->json(['message' => '']);
    	}
    }
}
