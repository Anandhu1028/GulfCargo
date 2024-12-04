<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GoodsDetails;
use App\Models\BoxesStatuses;
use App\Models\ShipmentTransfers;
use App\Models\BookingStatus; 
use App\Models\Enquiries;
use App\Models\Countries;
use App\Models\Staffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use App\Exports\LoadingListExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\CustomerAddresses;
use App\Models\Customers; 
use App\Models\Cities;
use App\Models\Districts;
use App\Models\States;
use Illuminate\Support\Facades\Input;

use DataTables;

class EnquiryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
        $book_cnt       =  Enquiries::where('branch_id',branch()->id)->where('status', 'book')->count();     
        $enquiry_cnt    =  Enquiries::where('branch_id',branch()->id)->where('status', 'enquiry')->count();  
        $cancel_cnt     =  Enquiries::where('branch_id',branch()->id)->where('status', 'cancel')->count();   

        $selected_status = '';
        if( $request->status ) {
            $selected_status    = $request->status;
            $enquiries          = Enquiries::where('branch_id',branch()->id)->where('status', $request->status)->paginate(10);;  

        } else {          
            $enquiries  = Enquiries::where('branch_id',branch()->id)->paginate(10);;
        }       
        return view('branches.enquiry.index', compact('enquiries','selected_status', 'book_cnt', 'enquiry_cnt', 'cancel_cnt') );
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // send_message('989899898', 'message');

         $enquiry       =   Enquiries::select('id','code')->orderBy('id', 'desc')->first();  
         $country_code  =   Countries::select('phonecode')->orderBy('id', 'desc')->get();  
         $countries     =  Countries::all(); 

         
         if(!empty($enquiry)){
             $bookingNum = $enquiry->id+10000;  
             $nextBookingNumber = branch()->branch_code ?branch()->branch_code.$enquiry->id+10000 : $enquiry->id+10000;
         }       
         else{
             // $enquiry =10000;
             $bookingNum = 10000;  
             $nextBookingNumber = branch()->branch_code ?branch()->branch_code.$bookingNum : $bookingNum;
 
         }
         
        $staffs = Staffs::notadmin()->where('branch_id',branch()->id)->get();  
        return view('branches.enquiry.create' , compact('nextBookingNumber', 'staffs','country_code','countries'));

 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
         

        try {
            \DB::beginTransaction();
 
                $enquiry = new Enquiries(); 

                $enquiry->enquiry_type                  = $request->enquiry_type;
                $enquiry->type                          = $request->type;
                $enquiry->collected_by                  = $request->collected_by;
                $enquiry->customer_name                 = $request->customer_name;
                $enquiry->customer_email                = $request->customer_email;
                $enquiry->customer_code                 = $request->customer_code;
                $enquiry->customer_mobile               = $request->customer_mobile;
                $enquiry->state_id                      = $request->state_id;
                $enquiry->street                        = $request->street;
                $enquiry->building_name                 = $request->building_name;
                $enquiry->flat_no                       = $request->flat_no;
                $enquiry->booking_details               = $request->booking_details;
                $enquiry->date_time                     = $request->date_time;
                $enquiry->date_of_survey                = $request->date_of_survey;
                $enquiry->date_of_collection            = $request->date_of_collection;
                $enquiry->code                          = $request->code;
                $enquiry->country_code_whatsapp         = $request->country_code_whatsapp;
                $enquiry->whatsapp_number               = $request->whatsapp_number;
                $enquiry->client_identification_type    = $request->client_identification_type;
                $enquiry->client_identification_number  = $request->client_identification_number;
              
                $enquiry->country_id                    = $request->country_id;
                $enquiry->district_id                   = $request->district_id;
                $enquiry->city_id                       = $request->city_id;
                $enquiry->post                          = $request->post;
                $enquiry->zip_code                      = $request->zip_code;
                $enquiry->branch_id                     = branch()->id;
                
                // if( $request->enquiry_type == 'enquiry') {
                    $enquiry->code  =    $request->code;
                // } else {
                //     $enquiry->code  =   "B-".$request->code;
                // }

                if ($request->file('document')) {                    
                    $fileName   = auth()->id() . '_' . time() . '.'. $request->document->extension();
                    $type       = $request->document->getClientMimeType();
                    $size       = $request->document->getSize();
        
                    $request->document->move(public_path('uploads/customer_logo'), $fileName);
                    $fileName       = 'uploads/customer_logo/'.$fileName;
                    $enquiry->logo  = $fileName; 
                    
                }

                $enquiry->save();

             \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack();
            Log::error($e->getMessage());
            toastr()->error($e->getMessage());
            return redirect()->back();
        }

        toastr()->success(section_title() . ' Added Successfully');
        return redirect()->to(index_url());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $enquiry        = Enquiries::findOrFail($id);
        $country_code   = Countries::select('phonecode')->orderBy('id', 'desc')->get();  
        $countries      = Countries::all();
        $states = [];
        $cities = [];
        $districts = [];
        if(!empty($enquiry->country_id)) {
            $states         = States::where('country_id', $enquiry->country_id)->get(); 
        }
        if(!empty($enquiry->state_id)) {
            $cities         = Cities::where('state_id', $enquiry->state_id)->get();  
        }
        if(!empty($enquiry->state_id)) {
            $districts      = Districts::where('state_id', $enquiry->state_id)->get();  
        }      
   
        $staffs = Staffs::notadmin()->where('branch_id',branch()->id)->get();        
        return view('branches.enquiry.edit', compact('enquiry', 'staffs' ,'countries', 'country_code', 'states', 'districts', 'cities'));
    } 

    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        try {
            \DB::beginTransaction();

            $enquiry                                = Enquiries::findOrFail($id);
            $enquiry->enquiry_type                  = $request->enquiry_type;
            $enquiry->type                          = $request->type;
            $enquiry->collected_by                  = $request->collected_by;
            $enquiry->customer_name                 = $request->customer_name;
            $enquiry->customer_email                = $request->customer_email;
            $enquiry->customer_code                 = $request->customer_code;
            $enquiry->customer_mobile               = $request->customer_mobile;
            $enquiry->state_id                      = $request->state_id;
            $enquiry->street                        = $request->street;
            $enquiry->building_name                 = $request->building_name;
            $enquiry->flat_no                       = $request->flat_no;
            $enquiry->booking_details               = $request->booking_details;
            $enquiry->date_time                     = $request->date_time;
            $enquiry->date_of_survey                = $request->date_of_survey;
            $enquiry->date_of_collection            = $request->date_of_collection;
            $enquiry->code                          = $request->code;
            $enquiry->country_code_whatsapp         = $request->country_code_whatsapp;
            $enquiry->whatsapp_number               = $request->whatsapp_number;
            $enquiry->client_identification_type    = $request->client_identification_type;
            $enquiry->client_identification_number  = $request->client_identification_number;
          
            $enquiry->country_id                    = $request->country_id;
            $enquiry->district_id                   = $request->district_id;
            $enquiry->city_id                       = $request->city_id;
            $enquiry->post                          = $request->post;
            $enquiry->zip_code                      = $request->zip_code;
            $enquiry->branch_id                     = branch()->id;
           
            // if( $request->enquiry_type == 'enquiry') {
            //     $enquiry->code  =   "E-".$request->code;
            // } else {
            //     $enquiry->code  =   "B-".$request->code;
            // }

            if ($request->file('document')) {                    
                $fileName   = auth()->id() . '_' . time() . '.'. $request->document->extension();
                $type       = $request->document->getClientMimeType();
                $size       = $request->document->getSize();
    
                $request->document->move(public_path('uploads/customer_logo'), $fileName);
                $fileName       = 'uploads/customer_logo/'.$fileName;
                $enquiry->logo  = $fileName; 
                
                // dd( $fileName ,$enquiry );
            }

            $enquiry->save(); 
           

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack();
            Log::error($e->getMessage());
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
        toastr()->success(section_title() . ' Updated Successfully');
        return redirect()->to(index_url());

    } 


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $sel_enquiry_id     = $request->sel_enquiry_id;
        $enquiry            = Enquiries::findOrFail( $sel_enquiry_id );  
        $enquiry->status    = $request->enquiry_status;   
        $enquiry->comment    = $request->comment;   
        $enquiry->save();

        if( $request->enquiry_status == 'book') {
            
                try {
                    DB::beginTransaction();
                    // $user = new User();
                    // $user->name     = $enquiry->customer_name;
                    // $user->email    = $enquiry->customer_email;
                    // $user->email    = $enquiry->customer_email ?? $this->generateEmail($enquiry->name);
                    // $user->password = bcrypt(123456);
                    // $user->save();
                    $customer = new Customers();
                    $customer->name                     = $enquiry->customer_name;
                    $customer->country_code_phone       = $enquiry->customer_code;
                    $customer->phone                    = $enquiry->customer_mobile;
                    $customer->booking_ref_id           = $enquiry->code;                     
                    // $customer->user_id                  = $user->id;
                    $customer->branch_id                = branch()->id;
                    $customer->email                    = $enquiry->customer_email;
                    $customer->type                     = "sender";  
                    $customer->country_code_whatsapp    = $enquiry->country_code_whatsapp;
                    $customer->whatsapp_number          = $enquiry->whatsapp_number;
                    $customer->type                     = $enquiry->client_type;
                    $customer->identification_type      = $enquiry->client_identification_type;
                    $customer->identification_number    = $enquiry->client_identification_number;                   
                    $customer->logo                     = $enquiry->logo;
                    $customer->save();
 
                    $address                = new CustomerAddresses();
                    $address->customer_id   = $customer->id;
                    $address->customer_id   = $customer->id;
                    $address->country_id    = $enquiry->country_id;
                    $address->state_id      = $enquiry->state_id;
                    $address->district_id   = $enquiry->district_id;
                    $address->zip_code      = $enquiry->zip_code;
                    $address->address       = $enquiry->address;  
                    $address->address       = $enquiry->flat_no.",".$enquiry->building_name .",".$enquiry->street ; 
                    $address->save();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false, 'message' => $e->getMessage(),
                    ]);
                }
        }

        echo "<span style='color:green'>Goods Status Updated Successfully</span>"; 
    }    

}