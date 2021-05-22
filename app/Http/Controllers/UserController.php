<?php

namespace App\Http\Controllers;

use App\Models\Passwd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public $incorrectCreds;

    public function login(Request $request)
    {
        info("received login request for email " . $request["email"] . " and password " . $request["password"]);
        $match = ["email" => $request["email"], "password" => $request["password"]];
        $result = User::where($match)->get();
        if (count($result) > 0) {
            Log::info("record found...");
            $request->session()->put("user", $result[0]["name"]);
            $name = $result[0]["name"];
            return view('loggedIn', compact('name'));
        } else {
            $this->incorrectCreds = true;
            return redirect()->route('welcome')->with(['incorrectCreds' => $this->incorrectCreds]);
        }
    }

    public function getSoldIpList()
    {
        Log::info('getSoldIpList' . session('user'));
        if (session('user')) {
            return view('soldIpList');
        } else {
            return redirect()->route('welcome');
        }
    }

    public function getUnsoldIpList()
    {
        Log::info('getUnSoldIpList' . session('user'));
        if (session('user')) {
            return view('unsoldIpList');
        } else {
            return redirect()->route('welcome');
        }
    }

    public function logout()
    {
        Log::info('logging out the user...');
        session()->flush();
        return redirect()->route('welcome');
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