<?php


use App\Models\Attendence;
use App\Models\Branches;
use App\Models\Agencies;

if (!function_exists("breadcrumbs")) {
    function breadcrumbs(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];
        $breadcrumb3 = Route::getCurrentRoute()->getActionMethod();
        $breadcrumb2Url = str_replace($breadcrumb3, "index", $route);


        return '<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="' . route('super-admin.dashboard') . '">Home</a></li>
                                    <li class="breadcrumb-item"><a href="' . route($breadcrumb2Url) . '">' . ucfirst($breadcrumb2) . '</a></li>
                                    <li class="breadcrumb-item active">' . ucfirst($breadcrumb3) . '</li>

                                </ol>';
    }
}
if (!function_exists("create_url")) {
    function create_url(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $createUrl = str_replace($lastAction, "create", $route);
        return route($createUrl);

    }
}
if (!function_exists("edit_url")) {
    function edit_url($id): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $editUrl = str_replace($lastAction, "edit", $route);
        return route($editUrl, $id);

    }
}
if (!function_exists("show_url")) {
    function show_url($id): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $editUrl = str_replace($lastAction, "show", $route);
        return route($editUrl, $id);

    }
}

if (!function_exists("store_url")) {
    function store_url(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $storeUrl = str_replace($lastAction, "store", $route);
        return route($storeUrl);

    }
}
if (!function_exists("update_url")) {
    function update_url($id): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $updateUrl = str_replace($lastAction, "update", $route);
        return route($updateUrl, $id);

    }
}
if (!function_exists("delete_url")) {
    function delete_url($id): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $deleteUrl = str_replace($lastAction, "destroy", $route);
        return route($deleteUrl, $id);

    }
}
if (!function_exists("index_url")) {
    function index_url(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $lastAction = Route::getCurrentRoute()->getActionMethod();
        $indexUrl = str_replace($lastAction, "index", $route);
        return route($indexUrl);

    }
}

if (!function_exists("page_title")) {
    function page_title(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];
        $breadcrumb3 = Route::getCurrentRoute()->getActionMethod();
        if ($breadcrumb3 == "index") {
            $breadcrumb3 = "List";
        }
        if ($breadcrumb3 == "show") {
            $breadcrumb3 = "View";
        }
        return ucfirst($breadcrumb3) . " " . ucfirst($breadcrumb2);

    }
}

if (!function_exists("section_title")) {
    function section_title(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];

        return ucfirst($breadcrumb2);

    }
}

if (!function_exists("permission_index")) {
    function permission_index(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];

        return strtolower($breadcrumb2) . "-index";

    }
}
if (!function_exists("permission_create")) {
    function permission_create(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];

        return strtolower($breadcrumb2) . "-create";

    }
}
if (!function_exists("permission_edit")) {
    function permission_edit(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];

        return strtolower($breadcrumb2) . "-edit";

    }
}
if (!function_exists("permission_view")) {
    function permission_view(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];

        return strtolower($breadcrumb2) . "-show";

    }
}
if (!function_exists("permission_delete")) {
    function permission_delete(): string
    {
        $route = Route::getCurrentRoute()->getName();
        $breadcrumb2 = explode(".", $route);
        $breadcrumb2 = array_reverse($breadcrumb2);
        $breadcrumb2 = $breadcrumb2[1];

        return strtolower($breadcrumb2) . "-delete";

    }
}

if (!function_exists("is_superadmin")) {
    function is_superadmin(): bool
    {
        if (auth()->user()->superadmin == 1) {
            return true;
        }
        return false;

    }
}

if (!function_exists("is_agencyadmin")) {
    function is_agencyadmin(): bool
    {
        if (auth()->user()->superadmin == 2) {
            return true;
        }
        return false;

    }
}

if (!function_exists("user_role")) {
    function user_role(): string
    {
        return auth()->user()->roles->pluck('name');
    }
}

if (!function_exists("branch")) {
    function branch(): ?Branches
    {
        $user = auth()->user();
 
        if ($user->staff != null) { 
//            dd($user->staff->branch_id);
            $branch_id = $user->staff->branch_id;
            $branch = Branches::find($branch_id);
//            $branch = DB::table("branches")->get();
//            dd($branch);
            session()->put("branch_id", $branch->id);
            return $branch;
        } 

        return null;
    }
}

if (!function_exists("agency_branch")) {
    function agency_branch(): ?Branches
    {
        $user = auth()->user();
 
        if ($user->agency != null) { 
            $branch_id = $user->agency->branch_id;

            $branch = Branches::find($branch_id); 
            session()->put("branch_id", $branch->id); 
            return $branch;
        } 

        return null;
    }
}
 

if (!function_exists("is_clocked")) {

    function is_clocked($staff,$type){
        $date = date('Y-m-d');
        if ($type=="in") {
            $attendance = Attendence::where("staff_id", $staff->id)
                ->where("date", $date)
                ->where("clock_in","!=",null)
                ->first();
            return $attendance!=null;

        } else {
            $attendance = Attendence::where("staff_id", $staff->id)
                ->where("date", $date)
                ->where("clock_out","!=",null)
                ->first();
            return $attendance!=null;
        }
    }

}



if (!function_exists("is_marked_present")) {

    function is_marked_present($staff){
        $date = date('Y-m-d');
        
            $attendance = Attendence::where("staff_id", $staff->id)
                ->where("date", $date)
                ->where("present",1)
                // ->where("present","!=",null)
                ->first();
            return $attendance!=null; 
         
    }

}


if (!function_exists("is_marked_absent")) {

    function is_marked_absent($staff){
        $date = date('Y-m-d');
        
            $attendance = Attendence::where("staff_id", $staff->id)
                ->where("date", $date)
                ->where("present",0)
                // ->where("present","!=",null)
                ->first();
            return $attendance!=null; 
         
    }

}






