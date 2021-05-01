<?php

namespace App\Http\Controllers;

use App\Models\Passwd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PasswdController extends Controller
{

    public $checked = [];

    /**
     * This method returns all the availabe ip mappings from the data store.
     * 
     */
    public static function getAllIPs()
    {
        $data = Passwd::all();
        return $data;
    }

    /**
     * This method returns the availabe ip mappings from the data store considering the given filters.
     * 
     */
    public function performFilterOnData($filterType)
    {
        Log::info("filter type: " . $filterType);
        Log::info("now- " . now());
        $data = null;
        switch ($filterType) {
            case 'exp_in_5d':
                $data = Passwd::where('expiry_timestamp', '<', now()->addDays(5))->where('expiry_timestamp', '>', now())->get();
                return view('ipList', compact('data', $this->checked));
            case 'exp_in_1m':
                $data = Passwd::where('expiry_timestamp', '<', now()->addDays(30))->where('expiry_timestamp', '>', now())->get();
                return view('ipList', compact('data', $this->checked));
            case 'expired':
                $data = Passwd::where('expiry_timestamp', '<', now())->get();
                return view('ipList', compact('data', $this->checked));
            case 'all':
                $data = Passwd::all();
                return view('ipList', compact('data', $this->checked));

            default:
                $data = Passwd::all();
                return view('ipList', compact('data', $this->checked));
        }
    }
}
