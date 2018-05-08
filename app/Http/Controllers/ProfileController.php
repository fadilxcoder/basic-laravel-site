<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

use App\Profile;
use Auth;

class ProfileController extends Controller
{    
    public function index()
    {
        return view('profiles.profile');
    }
    
    public function addProfile(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'designation' => 'required',
            'profile_pic' => 'required'
        ]);
        
        $profile = new Profile;
        $profile->user_id = Auth::user()->id;
        $profile->name = $request->input('name');
        $profile->designation = $request->input('designation');
        if(Input::hasFile('profile_pic'))
        {
            $file = Input::file('profile_pic');
            $file->move(public_path().'/uploads/profiles/', $file->getClientOriginalName());
            $url = URL::to("/").'/uploads/profiles/'.$file->getClientOriginalName();
        }
        $profile->profile_picture = $url;
        $profile->save();
        return redirect('/home')->with('response','Profile Added successfully');
    }
}
