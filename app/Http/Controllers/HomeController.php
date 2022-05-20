<?php

namespace App\Http\Controllers;

use App\Http\Traits\CompanySettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    use CompanySettingTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $timezome=$this->getCompanyDetails(Auth::user()->id);
        if ($timezome != ""){
        Session::put('timezone',$timezome->company_time_zone);
        }
        return view('home')->with('title','Dashboard');
    }
}
