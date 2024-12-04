<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{

    public function __construct()
    {
//        $timezone = session()->get("timezone","UTC");
        $timezone = \Session::get("timezone");

        if ($timezone) {
//                    dd($timezone);
            date_default_timezone_set($timezone);
        }
    }

}
