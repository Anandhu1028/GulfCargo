<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function generateEmail($name)
    {
        $domain = "@randommail.com";
        $name = str_replace(' ', '', $name);
        $name = strtolower($name);
        $num = rand(10, 999999);
        $email = $name . $num . $domain;
        return $email;
    }
}
