<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipments;
use App\Models\Statuses;
use App\Models\Ships;
use App\Models\ShipsBookings;
use App\Models\Branches;
use App\Models\Agencies;
use App\Models\Drivers;
use App\Models\Staffs;
use App\Models\ShipTypes;
use Illuminate\Support\Facades\DB;

class DropdownListController extends Controller
{
    

    public function paymentMethod(){ 

        $payment_method = [ 
                            [ 
                                'id' => 'cash_payment',
                                'title' => 'Cash Payment',
                            
                            ],
                            [ 
                                'id' => 'credit',
                                'title' => 'Credit',
                            
                            ],
                            [ 
                                'id' => 'bank',
                                'title' => 'Bank',
                            
                            ]                             
                         ];
        return response()->json(['data' => $payment_method], 200);
        
    }

    public function deliveryType(){
        $delivery_type = [
                           [
                                'id'=> 'door_to_port',
                                'title'=> 'Door to Port',
                            
                            ],
                           [
                                'id'=> 'door_to_door',
                                'title'=> 'Doot to door',
                            
                           ]                           
                         ]; 
        return response()->json(['data' => $delivery_type], 200);        
    }

    public function collectedBy(){
        $delivery_type = [
                            [
                                'id'=> 'driver',
                                'title'=> 'Driver',
                            
                            ],
                            [
                                'id'=> 'staff',
                                'title'=> 'Staff',
                            
                            ]  
                         ]; 
        return response()->json(['data' => $delivery_type], 200);        
    }


    public function shippingMethods(){
        $shippingMethods = [
                                [
                                    'id'=> 1,
                                    'title'=> 'IND Air',
                                
                                ],
                                [
                                    'id'=> 2,
                                    'title'=> 'IND Sea',
                                
                                ],
                                [
                                    'id'=> 3,
                                    'title'=> 'WD Air',
                                
                                ],
                                [
                                    'id'=> 4,
                                    'title'=> 'WD Sea',
                                
                                ],
                                [
                                    'id'=> 5,
                                    'title'=> 'FCL',
                                
                                ],
                                [
                                    'id'=> 6,
                                    'title'=> 'LCL',
                                
                                ]
                          
                         ];  
        return response()->json(['data' => $shippingMethods], 200);
    }

    public function attendenceType(){ 
        $attendenceType = [
                            [
                                'id'=> 'clockin',
                                'title'=> 'Clockin',
                            
                            ],
                            [
                                'id'=> 'clockout',
                                'title'=> 'Clockout',
                            
                            ],                           
                         ];  
        return response()->json(['data' => $attendenceType], 200);
    }


    public function customerType(){ 
        $customerType = [    
            [
                'id'=> 'sender',
                'title'=> 'Sender',
            
           ],
            [
                'id'=> 'receiver',
                'title'=> 'Receiver',
            
           ]                           
                         ];  
        return response()->json(['data' => $customerType], 200);
    }


    public function custIdentifyType(){  
        $custIdentifyType = [
                                    [
                                        'id'=> 'emirates_id',
                                        'title'=> 'Emirates Id',
                                    
                                    ], 
                                    [
                                        'id'=> 'aadhar',
                                        'title'=> 'Aadhar',
                                    
                                    ],  
                                    [
                                        'id'=> 'Driving Licence',
                                        'title'=> 'Driving Licence',
                                    
                                    ],
                                    [
                                        'id'=> 'Passport',
                                        'title'=> 'Passport',
                                    
                                    ],
                                    [
                                        'id'=> 'Iqama',
                                        'title'=> 'Iqama',
                                    
                                    ],
                                    [
                                        'id'=> 'Other',
                                        'title'=> 'Other',
                                    
                                    ] 
                          
                         ];  
        return response()->json(['data' => $custIdentifyType], 200);
    }

    
    public function getAllBranches(){  
        $branches = Branches::select('id','name', 'branch_code', 'location')->get();

        return response()->json(['data' => $branches], 200);
    }

    public function getAllCourierCompany(){ 

        $agencies = Agencies::select( 'id','name','user_id','branch_id','agency_code','address','email','contact_no','gst_no','logo','active','created_by','updated_by')->whereActive(true)->get();
        return response()->json(['data' => $agencies], 200);
    }

    public function getAllDrivers(){  
        $drivers = Drivers::select( 'id','name')->whereActive(true)->orderBy('name')->get();
        return response()->json(['data' => $drivers], 200);
    }

    public function getAllStaffs(){  
        $staffs = Staffs::select( 'id','full_name')->notadmin()->orderBy('full_name')->get();
        return response()->json(['data' => $staffs], 200);
    } 

}  