<?php


use App\Models\Customers;
use App\Models\Statuses;
use App\Models\Countries;
use App\Models\Attendence;
use App\Models\Staffs;
// use Auth;


if (!function_exists('get_clients')) {
    function get_customers($type)
    {
        return Customers::where('type', $type)->orderBy('name')->get();
    }
}


if (!function_exists('status_list')) {
    function status_list()
    {
        return Statuses::get();
    }
}

if (!function_exists('status_list_admin')) {
    function status_list_admin()
    {
        return Statuses::where('view',1)->get();
    }
}

if (!function_exists('status_list_front')) {
    function status_list_front()
    {
        return Statuses::where('view',0)->get();
    }
}

if (!function_exists('status_list_front_edit_goods')) {
    function status_list_front_edit_goods()
    {
        return Statuses::where('view',2)->get();
    }
}

if (!function_exists('get_country_code')) {
    function get_country_code()
    {
        $country_list = Countries::pluck('phonecode');
        // $country_list = array(
        //     93,358,355,213,1684,376,244,1264,672,1268,54,374,297,61,43,994,1242,973,880,1246,375,32,501,229,1441,975,591,599,387,267,55,55,246,673,359,226,257,855,237,1,238,1345,236,235,56,86,61,672,57,269,242,242,682,506,225,385,53,599,357,420,45,253,1767,1809,593,20,503,240,291,372,251,500,298,679,358,33,594,689,262,241,220,995,49,233,350,30,299,1473,590,1671,502,44,224,245,592,509,0,39,504,852,36,354,91,62,98,964,353,44,972,39,1876,81,44,962,7,254,686,850,82,383,965,996,856,371,961,266,231,218,423,370,352,853,389,261,265,60,960,223,356,692,596,222,230,262,52,691,373,377,976,382,1664,212,258,95,264,674,977,31,599,687,64,505,227,234,683,672,1670,47,968,92,680,970,507,675,595,51,63,64,48,351,1787,974,262,40,7,250,590,290,1869,1758,590,508,1784,684,378,239,966,221,381,381,248,232,65,721,421,386,677,252,27,500,211,34,94,249,597,47,268,46,41,963,886,992,255,66,670,228,690,676,1868,216,90,7370,1649,688,256,380,971,44,1,598,998,678,58,84,1284,1340,681,212,967,260,263
        //     );
        return $country_list;
    }
}


if (!function_exists('get_phone_no_length')) {
    function get_phone_no_length($country_id)
    {
        $data = Countries::select('phone_no_length')->where('id',$country_id)->first();
        $phone_no_length = $data->phone_no_length;
        return !empty($phone_no_length)?$phone_no_length:0;
         
    }
}

if (!function_exists('get_profile_picture')) {
    function get_profile_picture()
    {     
        $user_details = Staffs::where('user_id',Auth::user()->id )->first();      
        $profile_photo = $user_details->profile_photo; 
        return !empty($profile_photo)?$profile_photo:0;         
    }
}


if (!function_exists('update_attendence_status')) {
    function update_attendence_status($id, $status)
    {     
        $attendence_details = Attendence::where('id', $id )->first();
        $attendence_details->status =  $status;
        $attendence_details->save();
    }
}



if (!function_exists('send_message')) {
    function send_message($mobile, $message)
    {
//        return true;

        // $message = urlencode($message);
 
        // $mobile = "919048157456"; //str_replace("+","",$mobile);

        // $instance_id = '648AACE43F6C9';// env('WA_INSTANCE_ID');
        // $access_token = '648809c688acb'; //env('WA_ACCESS_TOKEN');

        // $url = "https://mygreentick.co.in/api/send?number=$mobile&type=text&message=$message&instance_id=$instance_id&access_token=$access_token";

 
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_POST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);

        // $server_output = curl_exec($ch);
        // curl_close($ch);
        // Log::info($server_output);
        // return json_decode($server_output);

    }
}