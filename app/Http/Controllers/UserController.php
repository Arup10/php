<?php

namespace App\Http\Controllers;

use App\Models\Passwd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public $credsOK = true;

    public function login(Request $request)
    {
        //dd($request);
        info("received login request for email " . $request["email"] . " and password " . $request["password"]);
        $match = ["email" => $request["email"], "password" => $request["password"]];
        $result = User::where($match)->get();
        if (count($result) > 0) {
            Log::info("record found...");
            //dd($result);
            //$request->session()->put("user", $result[0]["name"]);
            $name = $result[0]["name"];
            //$data = PasswdController::getAllIPs();
            return view('loggedIn', compact('name'));
        } else {
            $this->credsOK = false;
            return ('Incorrect creds..!');
            //return view('welcome', compact('credsOK'));
            //session()->flash('error', 'Incorrect creds..!');
        }
    }

    public function getSoldIpList()
    {
        return view('soldIpList');
    }

    public function getUnsoldIpList()
    {
        return view('unsoldIpList');
    }
}

        /* $data=[
            'name'=>'Virat Kohli',
            'mobile_no'=>'9874563233',
            'email'=>'virat@kohli.com',
            'password'=>'virat@123',
            'active_flag'=>'1',
        ];
        User::create($data);
        $data=[
            'name'=>'Sourav Ganguly',
            'mobile_no'=>'9874563210',
            'email'=>'sourav@ganguly.com',
            'password'=>'sourav@123',
            'active_flag'=>'1',
        ];
        User::create($data);
         */