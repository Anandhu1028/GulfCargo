<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Packages;
use App\Models\Shipments;
use App\Models\BoxDimensions;
use App\Models\Discount;
use App\Models\Weight;
use App\Models\Statuses;
use App\Models\Ships;
use App\Models\ShipsBookings;
use App\Models\ShipTypes;
use App\Models\MovingTypes;
use App\Models\States;
use App\Models\Boxes;
use App\Models\Drivers;
use App\Models\Staffs;
use App\Models\ShipmentsStatuses;
use App\Models\Cities;
use App\Models\Districts;
use App\Models\GoodsDetails;
use App\Models\BoxesStatuses;
use App\Models\ShipmentTransfers;
use App\Models\BookingStatus;
use App\Models\Box_sender_reciver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use App\Exports\LoadingListExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Jobs\SendWhatsAppMessage;
use Illuminate\Support\Facades\Hash;

class ShipmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index(Request $request)
    {
        $search = null;
        $fromDate = '';
        $toDate = '';
        $branchId = '';
        if ($request->has('keyword') != "") {
            $keyword = $request->keyword;
            $client_ids = Customers::where("phone", "like", "%$keyword%")
                ->orWhere("identification_number", "like", "%$keyword%")
                ->get()
                ->pluck('id');

            $shipments = Shipments::with('driver')->where('branch_id',branch()->id)->query()->paginate(10);
            if (count($client_ids) > 0) {
                $shipments = $shipments->whereIn("sender_id", $client_ids);
            }
            $shipments = $shipments->orWhere('booking_number', 'like', '%' . $keyword . '%');
            // $shipments = $shipments->where('branch_id', branch()->id);

            $shipments = $shipments->orderBy('created_at', 'desc')->get();


        } else {
            // $shipments = Shipments::latest()->where('branch_id', branch()->id)->orderBy('created_at', 'desc')->get();
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $search = $request->input('search');
            $branchId = $request->input('branch');

            $query = Shipments::with('driver', 'boxes.boxStatuses.status', 'sender', 'receiver');

            if ($branchId) {
                $query->where('branch_id', $branchId); // Adjust 'branch_id' to your actual column name
            } else {
                $query->where('branch_id', branch()->id);
            }

            if ($fromDate) {
                $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->startOfDay()->toDateString();
                $query->whereDate('created_at', '>=', $fromDate);
            }

            if ($toDate) {
                $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->endOfDay()->toDateString();
                $query->whereDate('created_at', '<=', $toDate);
            }

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('booking_number', 'like', "%$search%")
                        ->orWhereHas('sender', function ($query) use ($search) {
                            $query->where('phone', 'like', "%$search%");
                        })
                        ->orWhereHas('sender', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('sender', function ($query) use ($search) {
                            $query->where('whatsapp_number', 'like', "%$search%");
                        })
                        ->orWhereHas('receiver', function ($query) use ($search) {
                            $query->where('phone', 'like', "%$search%");
                        })
                        ->orWhereHas('receiver', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('receiver', function ($query) use ($search) {
                            $query->where('whatsapp_number', 'like', "%$search%");
                        })
                        ->orWhereHas('sender', function ($query) use ($search) {
                            $query->where('identification_number', 'like', "%$search%");
                        });
                });
            }

            $shipments = $query->latest()->orderBy('created_at', 'desc')->paginate(10);
        }

        foreach($shipments as $key => $ships) {
            foreach($ships->boxes as $status) {
                $lastStatus = collect($status->boxStatuses)->last();
                $shipments[$key]["last_status"] = (!empty($lastStatus)) ? $lastStatus->status->name : "";
            }
        }

        return view('branches.shipments.index', compact('shipments','search', 'fromDate', 'toDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // dd(branch()->id);
        $agencies = Agencies::whereActive(true)->get();
        $branches = Branches::all();
        $movingTypes = MovingTypes::whereStatus(true)->get();

        $drivers = Drivers::whereActive(true)->orderBy('name')->where('branch_id',branch()->id)->get();
        $staffs = Staffs::notadmin()->where('branch_id',branch()->id)->get();


        // $previous_sender = Customers::where('type','sender')->orderBy('name', 'asc')->first();
        // $previous_receiver = Customers::where('type','receiver')->orderBy('name', 'asc')->first();
        // $previous_receiver_state = States::where('country_id',  $previous_receiver->address->country_id )->get();
        // $previous_receiver_city = Cities::where('state_id', $previous_receiver->address->state_id )->get();

        // $previous_sender_state = States::where('country_id',  $previous_sender->address->country_id)->get();
        // $previous_sender_city = Cities::where('state_id', $previous_sender->address->state_id )->get();

        // $prev_sender_phon_length =Countries::select('phone_no_length')->where('id',  $previous_sender->address->country_id )->first();
        // $prev_receiver_phon_length =Countries::select('phone_no_length')->where('id',  $previous_receiver->address->country_id )->first();



        $ship_types = ShipTypes::all();

        $countries =  Countries::all();

        // $previous_booking = Shipments::orderBy('id', 'desc')->first();

        // $nextBookingNumber = branch()->branch_code;
        $shipment  =   Shipments::select('id','booking_number')->orderBy('id', 'desc')->first();
        $shipm = Shipments::where('branch_id', branch()->id)
            ->where(function($query) {
                $query->where('is_change_booking_no', 0)
                    ->orWhereNull('is_change_booking_no');
            })->get();

        if(!empty($shipment)){
            $bookingNum = $shipment->id+1000;
            $nextBookingNumber = branch()->branch_code ? branch()->branch_code.count($shipm)+1+1000 : $shipment->id+10000;
        }
        else{
            // $shipment =10000;
            $bookingNum = 1000;
            $nextBookingNumber = branch()->branch_code ? branch()->branch_code.$bookingNum : $bookingNum;

        }
        $previous_sender = Customers::where('type','sender')->orderBy('id', 'desc')->first();
        $previous_receiver = Customers::where('type','receiver')->orderBy('id', 'desc')->first();
        $previous_receiver_state = States::where('country_id',  $previous_receiver->address->country_id )->get();
        $previous_receiver_district = Districts::where('state_id', $previous_receiver->address->state_id )->get();

        $previous_sender_state = States::where('country_id',  $previous_sender->address->country_id )->get();
        $previous_sender_district = Districts::where('state_id', $previous_sender->address->state_id )->get();

        return view('branches.shipments.create',
            compact(
                'agencies',
                'countries',
                'nextBookingNumber',
                'drivers',
                'ship_types',
                'bookingNum',
                'staffs',
                'branches',
                'previous_sender',
                'previous_receiver',
                'previous_receiver_state',
                'previous_receiver_district',
                'previous_sender_state',
                'previous_sender_district'
            ));

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
            $shipments = new Shipments();
            if($request->booking_number == $request->new_book_no){
                $shipments->is_change_booking_no = 0;
            }
            else{
                $shipments->is_change_booking_no = 1;
            }
            $shipments->booking_number = $request->booking_number;
            // $shipments->agency_id = $request->agency_list;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;
            $shipments->receipt_number = $request->receipt_number;
            $shipments->packing_type = $request->packing_type;
            $shipments->agency_id = $request->agency_id;

            $shipments->shiping_method = $request->shiping_method;
            $shipments->created_date = $request->created_date;

            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs_create = $request->number_of_pcs;
            $shipments->status_id = $request->status_id;
            $shipments->collected_by = $request->collected_by;
            $shipments->delivery_type = $request->delivery_type;
            $shipments->time = $request->time;
            $shipments->shipping_method_id = $request->shipping_method_id;
            $shipments->value_of_goods = $request->value_of_goods;
            $shipments->special_remarks = $request->special_remarks;


            if($request->driver_id){
                $shipments->driver_id = $request->driver_id;
                $shipments->staff_id = null;

            } else {
                $shipments->staff_id = $request->staff_id;
                $shipments->driver_id = null;
            }

            $shipments->lrl_tracking_code = $request->lrl_tracking_code;

            $shipments->created_by = $request->user()->id;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = $request->branch_id;
            $shipments->origin_id = $request->branch_id;


            $shipments->grand_total_weight = $request->grand_total_weight;
            $shipments->rate_normal_weight = $request->rate_normal_weight;
            $shipments->amount_normal_weight = $request->amount_normal_weight == 0?null:$request->amount_normal_weight;

            $shipments->electronics_weight = $request->electronics_weight;
            $shipments->rate_electronics_weight = $request->rate_electronics_weight;
            $shipments->amount_electronics_weight = $request->amount_electronics_weight == 0 ? null :$request->amount_electronics_weight;

            $shipments->msic_weight = $request->msic_weight;
            $shipments->rate_msic_weight = $request->rate_msic_weight;
            $shipments->amount_msic_weight = $request->amount_msic_weight == 0 ? null : $request->amount_msic_weight;

            $shipments->insurance = $request->insurance;
            $shipments->rate_insurance = $request->rate_insurance;
            $shipments->amount_insurance = $request->amount_insurance;

            $shipments->awbfee = $request->awbfee;
            $shipments->rate_awbfee = $request->rate_awbfee;
            $shipments->amount_awbfee = $request->amount_awbfee;

            $shipments->vat_amount = $request->vat_amount;
            $shipments->rate_vat_amount = $request->rate_vat_amount;
            $shipments->amount_vat_amount = $request->amount_vat_amount;

            $shipments->volume_weight = $request->volume_weight;
            $shipments->rate_volume_weight = $request->rate_volume_weight;
            $shipments->amount_volume_weight = $request->amount_volume_weight;

            $shipments->discount_weight = $request->discount_weight;
            $shipments->rate_discount_weight = $request->rate_discount_weight;
            $shipments->amount_discount_weight = $request->amount_discount_weight;

            $shipments->amount_grand_total = $request->amount_grand_total;
            $shipments->number_of_pcs_create = $request->number_of_pcs;
            $shipments->add_pack_charge = $request->add_pack_charge;
            $shipments->rate_add_pack_charge = $request->rate_add_pack_charge;
            $shipments->amount_add_pack_charge = $request->amount_add_pack_charge;

            $shipments->save();
            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status);



            // $ship = Ships::where('branch_id',  branch()->id)->orderBy('created_at', 'desc')->first();
            // if($ship){
            //     // $shipsbooking = new ShipsBookings();
            //     // $shipsbooking->ship_id = $ship->id;
            //     // $shipsbooking->booking_id =  $shipments->id;
            //     // $shipsbooking->save();

            //     // $shipments->ship_id = $ship->id;
            //     // $shipments->save();
            // } else {
            //     toastr()->success(section_title() . 'Please create Shipment !');
            //     return redirect()->to(index_url());
            // }
            // $sender = Customers::find($request->sender_id);
            // // dd($sender->country_code_phone.$sender->whatsapp_number.",".$sender->name.",".$request->booking_number.",".$request->number_of_pcs);
            // $whatsapp_number = $sender->country_code_phone.$sender->whatsapp_number;
            // $sender_name = $sender->name??'Customer';
            // $booking_numb = $request->booking_number??'0';
            // $number_of_pcs = $request->number_of_pcs??'0';
            // $message = [
            //     "from_phone_number_id"=> "372869072582708",
            //     "phone_number"=>$whatsapp_number,
            //     "template_name" => "create_booking",
            //     "template_language" => "en",
            //     "header_field_1" => $sender_name,
            //     "field_1" => $booking_numb,
            //     "field_2" => $number_of_pcs,
            //     'contact' => [
            //         'first_name' => "ananthu",
            //         'country' => 'India',
            //         'language_code' => 'en',
            //         'groups' => 'examplegroup1,examplegroup2'
            //     ]
            // // Add more users as needed
            // ];

            //     SendWhatsAppMessage::dispatch($message);

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
        $shipment = Shipments::with('driver','movingType','boxes','boxes.ships')->findOrFail($id);
        $ship = null;
        $status = null;
        $boxId = isset($shipment->boxes[0])?$shipment->boxes[0]->id:null;
        $statusId = $shipment->status_id ;

        if (isset($shipment->boxes[0]) && $shipment->boxes[0] !== null) {
            $ship = Ships::find($shipment->boxes[0]->ship_id) ?? '';
        }

        if ($boxId != null) {
            $status = BoxesStatuses::where('box_id', $boxId)->latest('updated_at')->first();
        }

        $invStatus = Statuses::find($statusId);

        // dd($invStatus->name);
        return view('branches.shipments.show', compact('shipment','ship','status','invStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request, $id)
    {
        $password = $request->query('password');
        $correctHashedPasskey = hash('sha256', '123456');
        $shipment = Shipments::with('driver','boxes.boxStatuses')->findOrFail($id);
        $status = null;
        if ($shipment->boxes->isEmpty()) {
            $status = $shipment->status_id;
        } else {
            if($status == 15 || $status == 1 || $status == 2 || $status == null) {

                foreach ($shipment->boxes as $box) {
                    $latestStatus = $box->boxStatuses()->orderBy('id', 'desc')->first();
                    if ($latestStatus && ($latestStatus->id != 15 && $latestStatus->id != 1 && $latestStatus->id != 2)) {
                        $status = $latestStatus->status_id;
                        break;
                    }
                }
            }
            else{
                $status = $shipment->status_id;
            }

        }
        // dd($status);
        if( $status == 15 || $status == 1 || $status == 2 ||$status == null || hash_equals($correctHashedPasskey, $password??'0000')){
            $discount = Discount::first();
            $weight = Weight::first();
            $dimensions = BoxDimensions::all();


            $previous_sender = Customers::where('type','sender')->orderBy('id', 'desc')->first();
            $previous_receiver = Customers::where('type','receiver')->orderBy('id', 'desc')->first();

            $previous_receiver_state = States::where('country_id',  $previous_receiver->address->country_id )->get();
            $previous_receiver_city = Cities::where('state_id', $previous_receiver->address->state_id )->get();
            $previous_sender_state = States::where('country_id',  $previous_sender->address->country_id)->get();
            $previous_sender_city = Cities::where('state_id', $previous_sender->address->state_id )->get();
            $prev_sender_phon_length =Countries::select('phone_no_length')->where('id',  $previous_sender->address->country_id )->first();
            $prev_receiver_phon_length =Countries::select('phone_no_length')->where('id',  $previous_receiver->address->country_id )->first();

            $branches = Branches::all();
            $ship_types = ShipTypes::all();

            $bookingNum = $shipment->id+10000-1;

            if($shipment->branch_id != branch()->id) {
                toastr()->error(section_title() . 'No permission to view other branches');
                return redirect()->to(index_url());
            }
            $boxes = Boxes::with('packages')->where('shipment_id', $id)->orderBy('id', 'asc')->get();

            $agencies = Agencies::all();
            $origin_offices = Branches::all();
            $countries = Countries::all();
            // $drivers = Drivers::whereActive(true)->get();
            // $staffs = Staffs::notadmin()->get();
            $drivers = Drivers::whereActive(true)->orderBy('name')->where('branch_id',branch()->id)->get();
            $staffs = Staffs::notadmin()->where('branch_id',branch()->id)->get();

            return view('branches.shipments.edit', compact('shipment' , 'bookingNum','boxes', 'agencies', 'origin_offices', 'countries','drivers','staffs','discount','dimensions','weight', 'ship_types', 'branches', 'previous_sender', 'previous_receiver', 'previous_sender_state','previous_sender_city','previous_receiver_state', 'previous_receiver_city', 'prev_receiver_phon_length', 'prev_sender_phon_length' ));
        }
        else{
            return redirect()->back()->with('showModal', true);
        }
    }


    public function saveAsDraft(Request $request)
    {
        if($request->ajax()){
            try {
                \DB::beginTransaction();

                $shipments = Shipments::findOrFail($request->id);

                $shipments->booking_number = $request->booking_number;
                // $shipments->agency_id = $request->agency_list;
                $shipments->sender_id = $request->sender_id;
                $shipments->receiver_id = $request->receiver_id;
                $shipments->receipt_number = $request->receipt_number;
                $shipments->packing_type = $request->packing_type;
                $shipments->agency_id = $request->agency_id;
                Log::info($request->shiping_method);
                $shipments->shiping_method = $request->shiping_method;
                $shipments->payment_method = $request->payment_method;
                $shipments->number_of_pcs = $request->number_of_pcs;
                $shipments->status_id = $request->status_id;
                $shipments->delivery_type = $request->delivery_type;
                $shipments->time = $request->time;
                $shipments->shipping_method_id = $request->shiping_method;
                $shipments->value_of_goods = $request->value_of_goods;
                $shipments->special_remarks = $request->special_remarks;



                $shipments->collected_by = $request->collected_by;
                if($request->driver_id){
                    $shipments->driver_id = $request->driver_id;
                    $shipments->staff_id = null;

                } else {
                    $shipments->staff_id = $request->staff_id;
                    $shipments->driver_id = null;
                }

                $shipments->lrl_tracking_code = $request->lrl_tracking_code;
                $shipments->created_by = $request->user()->id;
                $shipments->shiping_date = date("Y-m-d");
                // $shipments->branch_id = branch()->id;
                $shipments->branch_id = $request->branch_id;
                $shipments->origin_id = $request->branch_id;

                $shipments->created_date = $request->created_date;

                $shipments->barcode = $request->barcode;
                $shipments->prev_branch_id = $request->prev_branch_id;
                $shipments->created_by = $request->user()->id;
                $shipments->packing_charge = $request->packing_charge;
                $shipments->comment_box = $request->comment_box;


                $shipments->other_charges = $request->other_charges;
                $shipments->discount = $request->discount;

                $shipments->normal_weight = $request->normal_weight;
                $shipments->rate_normal_weight = $request->rate_normal_weight;
                $shipments->amount_normal_weight = $request->amount_normal_weight == 0?null:$request->amount_normal_weight;

                $shipments->electronics_weight = $request->electronics_weight;
                $shipments->rate_electronics_weight = $request->rate_electronics_weight;
                $shipments->amount_electronics_weight = $request->amount_electronics_weight == 0 ? null :$request->amount_electronics_weight;

                $shipments->msic_weight = $request->msic_weight;
                $shipments->rate_msic_weight = $request->rate_msic_weight;
                $shipments->amount_msic_weight = $request->amount_msic_weight == 0 ? null : $request->amount_msic_weight;

                $shipments->other_weight = $request->other_weight;
                $shipments->rate_other_weight = $request->rate_other_weight;
                $shipments->amount_other_weight = $request->amount_other_weight;

                $shipments->grand_total_weight = $request->grand_total_weight;
                $shipments->rate_grand_total = $request->rate_grand_total;
                $shipments->amount_grand_total = $request->amount_grand_total;

                $shipments->add_pack_charge = $request->add_pack_charge;
                $shipments->rate_add_pack_charge = $request->rate_add_pack_charge;
                $shipments->amount_add_pack_charge = $request->amount_add_pack_charge;

                $shipments->insurance = $request->insurance;
                $shipments->rate_insurance = $request->rate_insurance;
                $shipments->amount_insurance = $request->amount_insurance;

                $shipments->awbfee = $request->awbfee;
                $shipments->rate_awbfee = $request->rate_awbfee;
                $shipments->amount_awbfee = $request->amount_awbfee;

                $shipments->vat_amount = $request->vat_amount;
                $shipments->rate_vat_amount = $request->rate_vat_amount;
                $shipments->amount_vat_amount = $request->amount_vat_amount;

                $shipments->volume_weight = $request->volume_weight;
                $shipments->rate_volume_weight = $request->rate_volume_weight;
                $shipments->amount_volume_weight = $request->amount_volume_weight;

                $shipments->discount_weight = $request->discount_weight;
                $shipments->rate_discount_weight = $request->rate_discount_weight;
                $shipments->amount_discount_weight = $request->amount_discount_weight;

                $shipments->grand_total_box_value = $request->grand_total_box_value;
                $shipments->total_freight = $request->total_freight;
                $shipments->misc_freight = $request->misc_freight;
                $shipments->document_charge = $request->document_charge;
                $shipments->grand_total = $request->grand_total;
                $shipments->package_total_amount = $request->package_total_amount;
                $shipments->package_total_quantity = $request->package_total_quantity;

                $shipments->save();

                $status = Statuses::find($request->status_id);
                $shipments->status()->attach($status);



                Boxes::where('shipment_id', $shipments->id)->delete();
                Packages::where('shipment_id', $shipments->id)->delete();
                Box_sender_reciver::where('shipment_id', $shipments->id)->delete();

                for ($i = 0; $i < $request->number_of_pcs; $i++) {
                    $j= $i+1;
                    $box = new Boxes();
                    $box->shipment_id = $shipments->id;
                    if($request->number_of_pcs == 1){
                        $box->box_name	 = $request->booking_number;
                    }
                    elseif($i == 0 && $request->booking_number == $request->input("box_name".$j))
                    {
                        $box->box_name	 = $j.$request->booking_number;
                    }
                    else
                    {
                        $box->box_name	 = $request->input("box_name".$j);

                    }
                    $box->box_dimension_id	 = $request->input("dimension".$j);
                    $box->other_length = $request->input("other_length".$j);
                    $box->other_width = $request->input("other_width".$j);
                    $box->other_height = $request->input("other_height".$j);
                    $box->other_select = $request->input("other_select".$j);
                    $box->weight = $request->input("weight".$j);
                    $box->volume = $request->input("volume".$j);


                    $box->rate = $request->input("rate".$j);
                    $box->packing = $request->input("packing".$j);
                    $box->box_packing_charge = $request->input("box_packing_charge".$j);



                    $box->unit_value = $request->input("unit_value".$j);
                    $box->total_value = $request->input("total_value".$j);

                        $box->sender_name = $request->input("sender_name".$j);
                        $box->sender_address = $request->input("sender_address".$j);
                        $box->sender_mob = $request->input("sender_mob".$j);
                        $box->sender_id_no = $request->input("sender_id_no".$j);

                        $box->receiver_name = $request->input("receiver_name".$j);
                        $box->receiver_address = $request->input("receiver_address".$j);
                        $box->receiver_mob = $request->input("receiver_mob".$j);
                        $box->receiver_id_no = $request->input("receiver_id_no".$j);

                        $box->sender_pin = $request->input("sender_pin".$j);
                        $box->receiver_pin = $request->input("receiver_pin".$j);

                        Log::info($request->file('sender_id_image'.$j));
                        if ($request->file('sender_id_image'.$j)) {
                            $fileName = auth()->id() . '_sender_' . time() . '.'. $request->file('sender_id_image'.$j)->extension();
                            // $type = $request->document->getClientMimeType();
                            // $size = $request->document->getSize();

                            $request->file('sender_id_image'.$j)->move(public_path('uploads/customer_logo'), $fileName);
                            $sender_fileName = 'uploads/customer_logo/'.$fileName;
                            $box->sender_id_image = $sender_fileName;

                        }
                        else{
                            $box->sender_id_image = $request->input("sender_id_image_value".$j);
                        }

                        if ($request->file('receiver_id_image'.$j)) {

                            $fileName = auth()->id() . '_reciver_' . time() . '.'. $request->file('receiver_id_image'.$j)->extension();
                            // $type = $request->document->getClientMimeType();
                            // $size = $request->document->getSize();

                            $request->file('receiver_id_image'.$j)->move(public_path('uploads/customer_logo'), $fileName);
                            $receiver_fileName = 'uploads/customer_logo/'.$fileName;
                            $box->receiver_id_image = $receiver_fileName;

                        }
                        else{
                            $box->receiver_id_image = $request->input("receiver_id_image_value".$j);
                        }

                        $Box_sender = new Box_sender_reciver();
                        $Box_sender->shipment_id = $shipments->id;
                        $Box_sender->name = $request->input("sender_name".$j);
                        $Box_sender->address = $request->input("sender_address".$j);
                        $Box_sender->mobile = $request->input("sender_mob".$j);
                        $Box_sender->pin = $request->input("sender_pin".$j);
                        $box->sender_id_type = $request->input("sender_id_type".$j);
                        $Box_sender->id_no = $request->input("sender_id_no".$j);
                        isset($sender_fileName) ? $Box_sender->id_image = $sender_fileName: $Box_sender->id_image = $request->input("sender_id_image_value".$j);
                        $Box_sender->type = 1;
                        $Box_sender->box_id = $request->input("box_name".$j);
                        $Box_sender->save();

                        $Box_receiver = new Box_sender_reciver();
                        $Box_receiver->shipment_id = $shipments->id;
                        $Box_receiver->name = $request->input("receiver_name".$j);
                        $Box_receiver->address = $request->input("receiver_address".$j);
                        $Box_receiver->mobile = $request->input("receiver_mob".$j);
                        $Box_receiver->pin = $request->input("receiver_pin".$j);
                        $box->receiver_id_type = $request->input("receiver_id_type".$j);
                        $Box_receiver->id_no = $request->input("receiver_id_no".$j);
                        isset($receiver_fileName) ? $Box_receiver->id_image = $receiver_fileName:$Box_receiver->id_image = $request->input("receiver_id_image_value".$j);
                        $Box_receiver->type = 0;
                        $Box_receiver->box_id = $request->input("box_name".$j);
                        $Box_receiver->save();

                        // $box->sender_id_image = $request->input("sender_id_image".$j);
                        // $box->receiver_id_image = $request->input("receiver_id_image".$j);

                    $box->save();
                }

                $box_ids = Boxes::where('shipment_id',$shipments->id)->get()->pluck('id');

                $p = 0;
                foreach( $box_ids as  $key => $id ){
                    $p = $p +1;
                    if(!empty( $request->input("description".$p) )) {
                        for ($k = 0; $k <  count($request->input("description".$p) ); $k++) {
                            $package = new Packages();
                            $package->shipment_id = $shipments->id;
                            $package->branch_id = $shipments->branch_id;
                            $package->box_id = $id;

                            $package->description = $request->input("description".$p)[$k];
                            $package->quantity = $request->input("qty".$p)[$k];
                            $package->unit_price = $request->input("unit".$p)[$k];
                            $package->subtotal =$request->input("subtotal".$p)[$k];
                            if( !empty($request->input("description".$p)[$k])){
                                $package->save();
                            }
                        }
                    }

                }
                \DB::commit();
                return "Success saved as draft";
            } catch (\Exception $e) {

                \DB::rollBack();
                Log::error($e->getMessage());
                toastr()->error($e->getMessage());
                return $e->getMessage();
            }

        }

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
                    $shipments = Shipments::findOrFail($id);

                    $shipments->booking_number = $request->booking_number;
                    // $shipments->agency_id = $request->agency_list;
                    $shipments->sender_id = $request->sender_id;
                    $shipments->receiver_id = $request->receiver_id;
                    $shipments->receipt_number = $request->receipt_number;
                    $shipments->packing_type = $request->packing_type;
                    $shipments->agency_id = $request->agency_id;
                    $request->shiping_method?$shipments->shiping_method = $request->shiping_method:'';
                    $shipments->payment_method = $request->payment_method;
                    $shipments->number_of_pcs = $request->number_of_pcs;
                    $shipments->status_id = $request->status_id;
                    $shipments->delivery_type = $request->delivery_type;
                    $shipments->time = $request->time;
                    $request->shipping_method_id?$shipments->shipping_method_id = $request->shipping_method_id:'';

                    $shipments->collected_by = $request->collected_by;
                    if($request->driver_id){
                        $shipments->driver_id = $request->driver_id;
                        $shipments->staff_id = null;

                    } else {
                        $shipments->staff_id = $request->staff_id;
                        $shipments->driver_id = null;
                    }
                    $shipments->lrl_tracking_code = $request->lrl_tracking_code;
                    $shipments->created_by = $request->user()->id;
                    $shipments->shiping_date = date("Y-m-d");
                    // $shipments->branch_id = branch()->id;
                    $shipments->branch_id = $request->branch_id;

                    $shipments->created_date = $request->created_date;

                    $shipments->barcode = $request->barcode;
                    $shipments->prev_branch_id = $request->prev_branch_id;
                    $shipments->created_by = $request->user()->id;
                    $shipments->packing_charge = $request->packing_charge;
                    $shipments->comment_box = $request->comment_box;


                    $shipments->other_charges = $request->other_charges;
                    $shipments->discount = $request->discount;
                    $shipments->normal_weight = $request->normal_weight;

                    $shipments->rate_normal_weight = $request->rate_normal_weight;
                    $shipments->amount_normal_weight = $request->amount_normal_weight == 0?null:$request->amount_normal_weight;
                    $shipments->electronics_weight = $request->electronics_weight;
                    $shipments->rate_electronics_weight = $request->rate_electronics_weight;
                    $shipments->amount_electronics_weight = $request->amount_electronics_weight == 0 ? null :$request->amount_electronics_weight;
                    $shipments->rate_msic_weight = $request->rate_msic_weight;
                    $shipments->amount_msic_weight = $request->amount_msic_weight == 0 ? null : $request->amount_msic_weight;
                    $shipments->other_weight = $request->other_weight;
                    $shipments->rate_other_weight = $request->rate_other_weight;
                    $shipments->amount_other_weight = $request->amount_other_weight;
                    $shipments->grand_total_weight = $request->grand_total_weight;
                    $shipments->rate_grand_total = $request->rate_grand_total;
                    $shipments->amount_grand_total = $request->amount_grand_total;


                    $shipments->value_of_goods = $request->value_of_goods;
                    $shipments->special_remarks = $request->special_remarks;


                    $shipments->insurance = $request->insurance;
                    $shipments->rate_insurance = $request->rate_insurance;
                    $shipments->amount_insurance = $request->amount_insurance;
                    $shipments->awbfee = $request->awbfee;
                    $shipments->rate_awbfee = $request->rate_awbfee;
                    $shipments->amount_awbfee = $request->amount_awbfee;
                    $shipments->vat_amount = $request->vat_amount;
                    $shipments->rate_vat_amount = $request->rate_vat_amount;
                    $shipments->amount_vat_amount = $request->amount_vat_amount;
                    $shipments->volume_weight = $request->volume_weight;
                    $shipments->rate_volume_weight = $request->rate_volume_weight;
                    $shipments->amount_volume_weight = $request->amount_volume_weight;
                    $shipments->discount_weight = $request->discount_weight;
                    $shipments->rate_discount_weight = $request->rate_discount_weight;
                    $shipments->amount_discount_weight = $request->amount_discount_weight;

                    $shipments->add_pack_charge = $request->add_pack_charge;
                    $shipments->rate_add_pack_charge = $request->rate_add_pack_charge;
                    $shipments->amount_add_pack_charge = $request->amount_add_pack_charge;


                    $shipments->msic_weight = $request->msic_weight;
                    $shipments->grand_total_box_value = $request->grand_total_box_value;
                    $shipments->total_freight = $request->total_freight;
                    $shipments->misc_freight = $request->misc_freight;
                    $shipments->document_charge = $request->document_charge;
                    $shipments->grand_total = $request->grand_total;
                    $shipments->package_total_amount = $request->package_total_amount;
                    $shipments->package_total_quantity = $request->package_total_quantity;

                    $shipments->save();
                    $status = Statuses::find($request->status_id);
                    $shipments->status()->attach($status);

                    Boxes::where('shipment_id', $shipments->id)->delete();
                    Packages::where('shipment_id', $shipments->id)->delete();
                    Box_sender_reciver::where('shipment_id', $shipments->id)->delete();

                    for ($i = 0; $i < $request->number_of_pcs; $i++) {
                        $j= $i+1;
                        $box = new Boxes();
                        $box->shipment_id = $shipments->id;
                        if($request->number_of_pcs == 1){
                            $box->box_name	 = $request->booking_number;
                        }
                        elseif($i == 0 && $request->booking_number == $request->input("box_name".$j))
                        {
                            $box->box_name	 = $j.$request->booking_number;
                        }
                        else
                        {
                            $box->box_name	 = $request->input("box_name".$j);

                        }
                        $box->box_dimension_id	 = $request->input("dimension".$j);

                        $box->other_length = $request->input("other_length".$j);
                        $box->other_width = $request->input("other_width".$j);
                        $box->other_height = $request->input("other_height".$j);
                        $box->other_select = $request->input("other_select".$j);

                        $box->weight = $request->input("weight".$j);
                        $box->volume = $request->input("volume".$j);

                        $box->rate = $request->input("rate".$j);
                        $box->packing = $request->input("packing".$j);
                        $box->box_packing_charge = $request->input("box_packing_charge".$j);
                        $box->unit_value = $request->input("unit_value".$j);
                        $box->total_value = $request->input("total_value".$j);
                        // $box->sender_id = $request->input("box_sender_id".$j);
                        // $box->receiver_id = $request->input("box_receiver_id".$j);

                        $box->sender_name = $request->input("sender_name".$j);
                        $box->sender_address = $request->input("sender_address".$j);
                        $box->sender_mob = $request->input("sender_mob".$j);
                        $box->sender_id_type = $request->input("sender_id_type".$j);
                        $box->sender_id_no = $request->input("sender_id_no".$j);

                        $box->receiver_name = $request->input("receiver_name".$j);
                        $box->receiver_address = $request->input("receiver_address".$j);
                        $box->receiver_mob = $request->input("receiver_mob".$j);
                        $box->receiver_id_type = $request->input("receiver_id_type".$j);
                        $box->receiver_id_no = $request->input("receiver_id_no".$j);

                        $box->sender_pin = $request->input("sender_pin".$j);
                        $box->receiver_pin = $request->input("receiver_pin".$j);

                        if ($request->file('sender_id_image'.$j)) {
                            foreach ($request->file('sender_id_image'.$j) as $i=>$file) {
                                $fileName = auth()->id() . '_sender_' . time().$i . '.'. $file->extension();
                                // $type = $request->document->getClientMimeType();
                                // $size = $request->document->getSize();

                                $file->move(public_path('uploads/customer_logo'), $fileName);
                                $sender_fileName = 'uploads/customer_logo/'.$fileName;
                                $sender_id_image[] = $sender_fileName;
                            }
                            $box->sender_id_image =  json_encode($sender_id_image);
                        }
                        else{
                            $box->sender_id_image = $request->input("sender_id_image_value".$j);
                        }

                        if ($request->file('receiver_id_image'.$j)) {
                            foreach ($request->file('receiver_id_image'.$j) as $i=>$file) {
                                $fileName = auth()->id() . '_sender_' . time().$i . '.'. $file->extension();
                                // $type = $request->document->getClientMimeType();
                                // $size = $request->document->getSize();

                                $file->move(public_path('uploads/customer_logo'), $fileName);
                                $sender_fileName = 'uploads/customer_logo/'.$fileName;
                                $receiver_id_image[] = $sender_fileName;
                            }
                            $box->receiver_id_image =  json_encode($receiver_id_image);
                        }
                        else{
                            $box->receiver_id_image = $request->input("receiver_id_image_value".$j);
                        }







                        // $Box_sender = new Box_sender_reciver();
                        // $Box_sender->shipment_id = $shipments->id;
                        // $Box_sender->name = $request->input("sender_name".$j);
                        // $Box_sender->address = $request->input("sender_address".$j);
                        // $Box_sender->mobile = $request->input("sender_mob".$j);
                        // $Box_sender->pin = $request->input("sender_pin".$j);
                        // $box->sender_id_type = $request->input("sender_id_type".$j);
                        // $Box_sender->id_no = $request->input("sender_id_no".$j);
                        // isset($sender_fileName) ? $Box_sender->id_image = $sender_fileName: $Box_sender->id_image = $request->input("sender_id_image_value".$j);
                        // $Box_sender->type = 1;
                        // $Box_sender->box_id = $request->input("box_name".$j);
                        // $Box_sender->save();
                        $senderPhone = $request->input("sender_mob" . $j);
                        $customer = Customer::where('phone', $senderPhone)->first();

                        if ($customer) {
                            $box->sender_name = $customer->name;
                            $box->sender_address = $customer->address;
                            $box->sender_mob = $customer->phone;
                            $box->sender_id_type = $customer->id_type;
                        }


                        $Box_receiver = new Box_sender_reciver();
                        $Box_receiver->shipment_id = $shipments->id;
                        $Box_receiver->name = $request->input("receiver_name".$j);
                        $Box_receiver->address = $request->input("receiver_address".$j);
                        $Box_receiver->mobile = $request->input("receiver_mob".$j);
                        $Box_receiver->pin = $request->input("receiver_pin".$j);
                        $box->receiver_id_type = $request->input("receiver_id_type".$j);
                        $Box_receiver->id_no = $request->input("receiver_id_no".$j);
                        isset($receiver_fileName) ? $Box_receiver->id_image = $receiver_fileName:$Box_receiver->id_image = $request->input("receiver_id_image_value".$j);
                        $Box_receiver->type = 0;
                        $Box_receiver->box_id = $request->input("box_name".$j);
                        $Box_receiver->save();
                        // $box->sender_id_image = $request->input("sender_id_image".$j);
                        // $box->receiver_id_image = $request->input("receiver_id_image".$j);

                        $box->save();
                    }

                    $box_ids = Boxes::where('shipment_id',$shipments->id)->get()->pluck('id');
                    $p = 0;
                    foreach( $box_ids as  $key => $id ){
                        $p = $p +1;
                        if(!empty( $request->input("description".$p) )) {
                            for ($k = 0; $k <  count($request->input("description".$p) ); $k++) {
                                $package = new Packages();
                                $package->shipment_id = $shipments->id;
                                $package->branch_id = $shipments->branch_id;
                                $package->box_id = $id;

                                $package->description = $request->input("description".$p)[$k];
                                $package->quantity = $request->input("qty".$p)[$k];
                                $package->unit_price = $request->input("unit".$p)[$k];
                                $package->subtotal =$request->input("subtotal".$p)[$k];
                                if( !empty($request->input("description".$p)[$k])){
                                    $package->save();
                                }
                            }
                        }

                    }
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


    public function createadditems($id)
    {
        $shipment = Shipments::with('driver')->findOrFail($id);
        $bookingNum = $shipment->id+10000-1;
        if($shipment->branch_id != branch()->id) {
            toastr()->error(section_title() . 'No permission to view other branches');
            return redirect()->to(index_url());
        }
        $box = Boxes::with('packages')->where('shipment_id', $id)->get();
        $agencies = Agencies::all();
        $origin_offices = Branches::all();
        $countries = Countries::all();
        $drivers = Drivers::whereActive(true)->get();
        $dimensions = BoxDimensions::all();
        $discount = Discount::first();
        $weight = Weight::first();


        return view('branches.shipments.createadditems', compact('shipment', 'bookingNum', 'box', 'agencies', 'origin_offices', 'countries','drivers','dimensions', 'discount','weight'));
    }



    public function additemsstore(Request $request)
    {

        // $request->validate([
        //     'booking_number' => 'required|unique:shipments',
        //     'status_id' => 'required',
        // //     'sender_id' => 'required',
        // //     'receiver_id' => 'required'
        // ]);

        try {
            \DB::beginTransaction();
            $shipments = Shipments::findOrFail( $request->shipment_id );
            $shipments->booking_number = $request->booking_number;
            // $shipments->agency_id = $request->agency_list;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;
            $shipments->receipt_number = $request->receipt_number;
            $shipments->packing_type = $request->packing_type;
            $shipments->agency_id = $request->agency_id;
            $shipments->shiping_method = $request->shiping_method;


            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs;
            $shipments->status_id = $request->status_id;

            $shipments->driver_id = $request->driver_id;
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;

            $shipments->created_by = $request->user()->id;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = $request->branch_id;



            $shipments->barcode = $request->barcode;
            $shipments->prev_branch_id = $request->prev_branch_id;
            $shipments->created_by = $request->user()->id;
            $shipments->packing_charge = $request->packing_charge;
            $shipments->other_charges = $request->other_charges;
            $shipments->discount = $request->discount;

            $shipments->total_weight = $request->total_weight;
            $shipments->msic_weight = $request->msic_weight;
            $shipments->grand_total_box_value = $request->grand_total_box_value;
            $shipments->total_freight = $request->total_freight;
            $shipments->misc_freight = $request->misc_freight;
            $shipments->document_charge = $request->document_charge;
            $shipments->grand_total = $request->grand_total;
            $shipments->package_total_amount = $request->package_total_amount;
            $shipments->package_total_quantity = $request->package_total_quantity;


            $shipments->save();
            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status);
            for ($i = 0; $i < $request->number_of_pcs; $i++) {
                $j= $i+1;
                $box = new Boxes();
                $box->shipment_id = $shipments->id;
                $box->length = $request->input("length".$j);
                $box->width = $request->input("width".$j);
                $box->height = $request->input("height".$j);
                $box->weight = $request->input("weight".$j);
                $box->volume = $request->input("volume".$j);
                $box->unit_value = $request->input("unit_value".$j);
                $box->total_value = $request->input("total_value".$j);


                $box->sender_name = $request->input("sender_name".$j);
                        $box->sender_address = $request->input("sender_address".$j);
                        $box->sender_mob = $request->input("sender_mob".$j);
                        $box->sender_id_no = $request->input("sender_id_no".$j);

                        $box->receiver_name = $request->input("receiver_name".$j);
                        $box->receiver_address = $request->input("receiver_address".$j);
                        $box->receiver_mob = $request->input("receiver_mob".$j);
                        $box->receiver_id_no = $request->input("receiver_id_no".$j);

                        $box->sender_pin = $request->input("sender_pin".$j);
                        $box->receiver_pin = $request->input("receiver_pin".$j);

                        if ($request->file('sender_id_image'.$j)) {
                            $fileName = auth()->id() . '_' . time() . '.'. $request->file('sender_id_image'.$j)->extension();
                            // $type = $request->document->getClientMimeType();
                            // $size = $request->document->getSize();

                            $request->file('sender_id_image'.$j)->move(public_path('uploads/customer_logo'), $fileName);
                            $fileName = 'uploads/customer_logo/'.$fileName;
                            $box->sender_id_image = $fileName;

                        }
                        else{
                            $box->sender_id_image = $request->input("sender_id_image_value".$j);
                        }

                        if ($request->file('receiver_id_image'.$j)) {
                            $fileName = auth()->id() . '_' . time() . '.'. $request->file('receiver_id_image'.$j)->extension();
                            // $type = $request->document->getClientMimeType();
                            // $size = $request->document->getSize();

                            $request->file('receiver_id_image'.$j)->move(public_path('uploads/customer_logo'), $fileName);
                            $fileName = 'uploads/customer_logo/'.$fileName;
                            $box->receiver_id_image = $fileName;

                        }
                        else{
                            $box->receiver_id_image = $request->input("receiver_id_image_value".$j);
                        }


                        // $box->sender_id_image = $request->input("sender_id_image".$j);
                        // $box->receiver_id_image = $request->input("receiver_id_image".$j);

                $box->sender_id = $request->input('box_sender_id'.$j);
                $box->receiver_id = $request->input('box_receiver_id'.$j);

                $box->save();
            }

            $box_ids = Boxes::where('shipment_id',$shipments->id)->get()->pluck('id');

            $p = 0;
            foreach( $box_ids as  $key => $id ){
                $p = $p +1;
                if(!empty( $request->input("description".$p) )) {
                    for ($k = 0; $k <  count($request->input("description".$p) ); $k++) {
                        $package = new Packages();
                        $package->shipment_id = $shipments->id;
                        $package->branch_id = $shipments->branch_id;
                        $package->box_id = $id;

                        $package->description = $request->input("description".$p)[$k];
                        $package->quantity = $request->input("qty".$p)[$k];
                        $package->unit_price = $request->input("unit".$p)[$k];
                        $package->subtotal =$request->input("subtotal".$p)[$k];
                        if( !empty($request->input("description".$p)[$k])  &&  !empty($request->input("qty".$p)[$k]) && !empty( $request->input("unit".$p)[$k])){
                            $package->save();
                        }
                    }
                }

            }


            if ($shipments->receiver) {
                $message_receiver = "Dear " . $shipments->receiver->name . ",
            Thank you for choosing Best Express Cargo!
            Your shipment SD# $shipments->booking_number has been booked!. Please share your valuable feedback
             Weblink:https://bestexpresscargo.com/";
              $phone = !empty($shipments->receiver->whatsapp_number) ? $shipments->receiver->country_code_whatsapp.$shipments->receiver->whatsapp_number :$shipments->receiver->country_code.$shipments->receiver->phone;
                send_message($phone, $message_receiver);

            }

            if ($shipments->sender) {
                $message_sender = "Dear " . $shipments->sender->name . ",
            Thank you for choosing Best Express Cargo!
            Your shipment SD# $shipments->booking_number has been booked!. Please share your valuable feedback
             Weblink: https://bestexpresscargo.com/";
              $phone = !empty($shipments->sender->whatsapp_number) ? $shipments->sender->country_code_whatsapp.$shipments->sender->whatsapp_number :$shipments->sender->country_code.$shipments->sender->phone;
                send_message($phone, $message_sender);

            }

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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function print($id){

        $shipment = Shipments::with('boxes')->with('packages')->with('agency')->with('receiver')->with('sender')->findOrFail($id);
        return view('branches.shipments.printview', compact('shipment'));
    }

    public function single_print($id){
        $item = Boxes::with('packages')->with('shipment')->with('receiver')->with('sender')->findOrFail($id);
        return view('branches.shipments.single_CoustomsPrint', compact('item'));
    }

    public function exportImage(Request $request)
    {
        $imageData = $request->input('imageData');

        // Extract base64 image data
        list($type, $data) = explode(';', $imageData);
        list(, $data)      = explode(',', $data);
        $imageData = base64_decode($data);

        // Generate unique filename
        $filename = 'exported_image_' . time() . '.png';

        // Save image on server
        file_put_contents(public_path('images/' . $filename), $imageData);

        return response()->json(['filename' => $filename]);
    }

    public function printCustomer($id){
        $shipment = Shipments::with('boxes')->with('packages')->with('agency')->with('receiver')->with('sender')->findOrFail($id);
        return view('branches.shipments.printCustomerview', compact('shipment'));
    }


    public function printall(Request $request){
            $shipments = Boxes::with('packages')->whereIn('id', $request->booking_ids)->get();
            $agency = Agencies::find($request->agency);
            $awb_no = $request->input('awb_no');
            return view('branches.shipments.printviewall', compact('shipments','agency','awb_no'));
    }

    public function loadingExport(Request $request) {
        if(!empty($request->boxId)) {
            $explode_id = explode(',', $request->boxId);
            // $datas = ShipsBookings::with('shipment','ship','shipment.boxes','shipment.bookingNumberStatus.status')->whereIn('booking_id', $explode_id)->get();
            $datas =  Boxes::with('shipment.shipmentStatus','shipment.packages','boxStatuses.status')->whereHas('shipment',function ($query) {
                $query->where('branch_id', branch()->id);
            })->where('is_transfer',0)->whereIn('id',$explode_id)->get();

        } else {
            $request->shipIds;
            $datas =  Boxes::with('shipment.shipmentStatus','shipment.packages','shipment.shipType','boxStatuses.status')->whereHas('shipment',function ($query) {
                $query->where('branch_id', branch()->id);
            })->where('is_transfer',0)->where('is_shipment',1)->where('ship_id',$request->shipIds)->get();

            // $datas = ShipsBookings::with('shipment','ship','shipment.boxes','shipment.bookingNumberStatus.status')->where('ship_id', $request->shipIds)->get();
        }
        foreach($datas as $data) {
            $shipId = $data->ship_id;
        }
        $mode = Ships::with('shipmentMethodTypes')->find($shipId);
        $excelName = "loadinglist.xlsx";
        return view('branches.shipments.loadingExportList', compact('datas','excelName','mode'));
    }

    public function collectedBy(Request $request){
        $html='';
        if($request->collected =="driver") {
            $data = Drivers::select( 'id','name')->whereActive(true)->where('branch_id',branch()->id)->orderBy('name')->get(); // Drivers::all();
            $html = "<div class='form-group'><label>Driver Name</label>
                        <select name='driver_id'  class='form-control' >";
            foreach( $data as $val ){
                $html.="<option value='".$val->id."'>".strtoupper($val->name)." </option>";
            }
            $html.="</select>";

        }else {

            $data = Staffs::notadmin()->where('branch_id',branch()->id)->orderBy('full_name')->get();
            $html = "<div class='form-group'><label>Staff Name</label>
                        <select name='staff_id'  class='form-control' >";
            foreach( $data as $val ){
                $html.="<option value='".$val->id."'>".strtoupper($val->full_name)." </option>";
            }
            $html.="</select></div>";
        }

        $datas['res'] =  $html;
        return response()->json($datas);
    }

    public function booking_code(Request $request){
        $html='';
        $code = $request->booking_code;
        $customer_details = Customers::with('address')->where('booking_ref_id', $code )->first();

        return $customer_details->id;


    }
    public function update_sender(Request $request, $id)
    {
        // Find the sender by ID
        $sender = Customers::find($id);
        $cityName = $request->input('cities');
        if ($sender) {
            // Update sender's basic info
            $sender->name = $request->input('name');
            $sender->email = $request->input('email');
            $sender->phone = $request->input('phone');
            $sender->identification_number = $request->input('client_identification_number');
            $sender->identification_type = $request->input('client_identification_type');
            $sender->whatsapp_number = $request->input('whatsapp_number');
            $sender->country_code_whatsapp = $request->input('country_code_whatsapp');
            $sender->country_code_phone = $request->input('country_code_phone');
            if ($request->hasFile('document')) {
                $fileNames = [];
                foreach ($request->file('document') as $file) {
                    $fileName = auth()->id() . '_' . time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/customer_logo'), $fileName);
                    $fileNames[] = 'uploads/customer_logo/' . $fileName;
                }
            
                // Join the file names into a comma-separated string
                $sender->logo = implode(',', $fileNames);
               // $customer->save();
            }
            
            // Save the sender information
            $sender->save();
            $city = Cities::where('name', $cityName)->first();
            if (!$city) {
                // If not, create a new city
                $city = new Cities();
                $city->name = $cityName;
                $city->state_id = $request->input('state_id'); // Link to the selected state
                $city->country_id = $request->input('country_id');
                $city->save();
            }
    // Get the city ID (whether existing or newly created)
        $cityId = $city->id;
            // Update sender's address (if address exists)
            if ($sender->address) {
                $sender->address->address = $request->input('address');
                $sender->address->country_id = $request->input('country_id');
                $sender->address->state_id = $request->input('state_id');
                $sender->address->district_id = $request->input('district_id');
                $sender->address->city_id =$cityId;
                $sender->address->zip_code = $request->input('zip_code');
                $sender->address->save();
            } else {
                // Optionally handle if the sender doesn't have an address
                // You could create a new address here if necessary
            }
          //  $cityName = $request->input('city_id');

   
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $sender->name,
                    
                    'phone' => $sender->phone,
                    'address' => $sender->address->address ?? '', // Ensure it's a string
                    
                ],
            ]);
        }
    
        return response()->json(['success' => false, 'message' => 'Sender not found.']);
    }
    public function update_receiver(Request $request, $id)
    {
        // Find the sender by ID
        $receiver = Customers::find($id);
        $cityName = $request->input('cities');
        if ($receiver) {
            // Update sender's basic info
            $receiver->name = $request->input('name');
            $receiver->email = $request->input('email');
            $receiver->phone = $request->input('phone');
            $receiver->identification_number = $request->input('client_identification_number');
            $receiver->identification_type = $request->input('client_identification_type');
            $receiver->whatsapp_number = $request->input('whatsapp_number');
            $receiver->country_code_whatsapp = $request->input('country_code_whatsapp');
            $receiver->country_code_phone = $request->input('country_code_phone');
            if ($request->hasFile('document')) {
                $fileNames = [];
                foreach ($request->file('document') as $file) {
                    $fileName = auth()->id() . '_' . time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/customer_logo'), $fileName);
                    $fileNames[] = 'uploads/customer_logo/' . $fileName;
                }
            
                // Join the file names into a comma-separated string
                $receiver->logo = implode(',', $fileNames);
               // $customer->save();
            }
            
            // Save the sender information
            $receiver->save();

            $city = Cities::where('name', $cityName)->first();
            if (!$city) {
                // If not, create a new city
                $city = new Cities();
                $city->name = $cityName;
                $city->state_id = $request->input('state_id'); // Link to the selected state
                $city->country_id = $request->input('country_id');
                $city->save();
            }
    // Get the city ID (whether existing or newly created)
        $cityId = $city->id;
    
            // Update sender's address (if address exists)
            if ($receiver->address) {
                $receiver->address->address = $request->input('address');
                $receiver->address->country_id = $request->input('country_id');
                $receiver->address->state_id = $request->input('state_id');
                $receiver->address->district_id = $request->input('district_id');
                $receiver->address->city_id = $cityId;
                $receiver->address->zip_code = $request->input('zip_code');
                $receiver->address->save();
            } else {
                // Optionally handle if the sender doesn't have an address
                // You could create a new address here if necessary
            }
            // Check if the city already exists
          
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $receiver->name,
                    
                    'phone' => $receiver->phone,
                    'address' => $receiver->address->address ?? '', // Ensure it's a string
                    
                ],
            ]);
        }
    
        return response()->json(['success' => false, 'message' => 'Receiver not found.']);
    }



    public function reportList(Request $request) {
        $statuses =  Statuses::where('status',1)->where('view',1)->orWhere('view',2)->get();//status_list_admin();//
        // $query = ShipsBookings::with('shipment','shipment.shipmentStatus','shipment.bookingNumberStatus','shipment.boxes','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.branch','ship','ship.createdBy','ship.portOfOrigins','ship.shipmentTypes','ship.clearingAgents');
        $query = Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','boxStatuses.status','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('is_shipment',1);
        $shipsss = $query->orderBy('id', 'desc')->get();
        $ships = collect();
        foreach ($shipsss as $shippp) {
            if ($shippp->shipment && $shippp->shipment->branch_id == auth()->user()->staff->branch_id) {
                Log::info($shippp->shipment->branch_id . '-----' . auth()->user()->staff->branch_id);
                $ships->push($shippp);
            }
        }
        $datas = [];
        foreach($ships as  $key => $ship) {
            $getShip = Ships::with('createdBy')->where('id',$ship->ship_id)->first();
            $datas[$key]['createdDate'] = (!empty($getShip->created_date) ) ? date('d-m-Y',strtotime($getShip->created_date)) : '';
            $datas[$key]['portOfOrigins'] = (!empty($getShip->portOfOrigins) ) ? $getShip->portOfOrigins->name : '';
            $datas[$key]['clearingAgents'] = (!empty($getShip->clearingAgents) ) ? $getShip->clearingAgents->name : '';
            $datas[$key]['shipmentTypes'] = (!empty($getShip->shipmentMethodTypes) ) ? $getShip->shipmentMethodTypes->name : '';
            $datas[$key]['awb_number'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
            $datas[$key]['createdBy'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
            $datas[$key]['boxes'] = (!empty($ship->box_name) ) ? $ship->box_name : '';

            if(!empty($ship->boxStatuses)) {
                // dd(collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->last());
                if($ship->shipment ){
                    $collectedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->last();
                }
                $receivedType = collect($ship->boxStatuses)->where('status_id', 1)->last();
                $bookedType = collect($ship->boxStatuses)->where('status_id', 2)->last();
                $forwardedType = collect($ship->boxStatuses)->where('status_id', 3)->last();
                $arrivedType = collect($ship->boxStatuses)->where('status_id', 4)->last();
                $waitingType = collect($ship->boxStatuses)->where('status_id', 5)->last();
                $onHoldType = collect($ship->boxStatuses)->where('status_id', 7)->last();
                $clearedType = collect($ship->boxStatuses)->where('status_id', 8)->last();
                $arrangedType = collect($ship->boxStatuses)->where('status_id', 9)->last();
                $outType = collect($ship->boxStatuses)->where('status_id', 10)->last();
                $deliveredType = collect($ship->boxStatuses)->where('status_id', 11)->last();
                $notDeliveredType = collect($ship->boxStatuses)->where('status_id', 12)->last();
                $pendingType = collect($ship->boxStatuses)->where('status_id', 13)->last();
                $moreTrackingType = collect($ship->boxStatuses)->where('status_id', 14)->last();
                $transferType = collect($ship->boxStatuses)->where('status_id', 17)->last();
                $receivedType = collect($ship->boxStatuses)->where('status_id', 24)->last();
                $holdType = collect($ship->boxStatuses)->where('status_id', 26)->last();
                $shortType = collect($ship->boxStatuses)->where('status_id', 27)->last();

                $datas[$key]['collectedDate'] = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                $datas[$key]['receivedDate'] = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                $datas[$key]['bookedDate'] = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                $datas[$key]['forwardedDate'] = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                $datas[$key]['arrivedDate'] = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                $datas[$key]['waitingDate'] = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                $datas[$key]['onHoldDate'] = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                $datas[$key]['clearedDate'] = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                $datas[$key]['arrangedDate'] = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                $datas[$key]['outDate'] = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                $datas[$key]['deliveredDate'] = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                $datas[$key]['notDeliveredDate'] = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                $datas[$key]['pendingDate'] = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                $datas[$key]['moreTrackingDate'] = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                $datas[$key]['transferDate'] = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;
                $datas[$key]['receivedDate'] = (!empty($receivedType)) ?  date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                $datas[$key]['holdDate'] = (!empty($holdType)) ?  date('d-m-Y',strtotime($holdType->created_at)) : '' ;
                $datas[$key]['shortDate'] = (!empty($shortType)) ?  date('d-m-Y',strtotime($shortType->created_at)) : '' ;

                $status = collect($ship->boxStatuses)->last();
                if($ship->shipment){
                    $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
                }
                $datas[$key]['lastStatus'] = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;

                if($datas[$key]['lastStatus'] == "Shipment on hold") {
                    $datas[$key]['style'] = 'background-color:#ffdb00;';
                } else if($datas[$key]['lastStatus'] == "Pending") {
                    $datas[$key]['style'] = 'background-color:#ec1616e6;';
                } else {
                    $datas[$key]['style'] = 'background-color:none;';
                }
                if($ship->shipment){
                    $datas[$key]['booking_number'] = $ship->shipment->booking_number;
                }
                else{
                    $datas[$key]['booking_number'] = 'null';
                }
                $datas[$key]['shipment_id'] = $getShip->shipment_id;
                $datas[$key]['full_name'] = $getShip->createdBy->full_name??'';
                $datas[$key]['view'] = '<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm detailedView">View</a>';
            }
        }
        return view('branches.shipments.reportList',compact('statuses','datas'));
    }

    public function viewDataReport($fromDate,$toDate) {
        $query = Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','boxStatuses.status','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('is_shipment',1);
        $ships = $query->whereHas('boxStatuses', function ($q) use ($fromDate,$toDate) {
                        $q->whereBetween('boxes_statuses.created_at',[$fromDate, $toDate]);
                    })->orderBy('id','desc')->get();

        $datas = [];
        foreach($ships as  $key => $ship) {
            $getShip = Ships::with('createdBy')->where('id',$ship->ship_id)->first();
            $datas[$key]['createdDate'] = (!empty($getShip->created_date) ) ? date('d-m-Y',strtotime($getShip->created_date)) : '';
            $datas[$key]['portOfOrigins'] = (!empty($getShip->portOfOrigins) ) ? $getShip->portOfOrigins->name : '';
            $datas[$key]['clearingAgents'] = (!empty($getShip->clearingAgents) ) ? $getShip->clearingAgents->name : '';
            $datas[$key]['shipmentTypes'] = (!empty($getShip->shipmentMethodTypes) ) ? $getShip->shipmentMethodTypes->name : '';
            $datas[$key]['awb_number'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
            $datas[$key]['createdBy'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
            $datas[$key]['boxes'] = (!empty($ship->box_name) ) ? $ship->box_name : '';

            if(!empty($ship->boxStatuses)) {
                $collectedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->last();
                $receivedType = collect($ship->boxStatuses)->where('status_id', 1)->last();
                $bookedType = collect($ship->boxStatuses)->where('status_id', 2)->last();
                $forwardedType = collect($ship->boxStatuses)->where('status_id', 3)->last();
                $arrivedType = collect($ship->boxStatuses)->where('status_id', 4)->last();
                $waitingType = collect($ship->boxStatuses)->where('status_id', 5)->last();
                $onHoldType = collect($ship->boxStatuses)->where('status_id', 7)->last();
                $clearedType = collect($ship->boxStatuses)->where('status_id', 8)->last();
                $arrangedType = collect($ship->boxStatuses)->where('status_id', 9)->last();
                $outType = collect($ship->boxStatuses)->where('status_id', 10)->last();
                $deliveredType = collect($ship->boxStatuses)->where('status_id', 11)->last();
                $notDeliveredType = collect($ship->boxStatuses)->where('status_id', 12)->last();
                $pendingType = collect($ship->boxStatuses)->where('status_id', 13)->last();
                $moreTrackingType = collect($ship->boxStatuses)->where('status_id', 14)->last();
                $transferType = collect($ship->boxStatuses)->where('status_id', 17)->last();
                $receivedType = collect($ship->boxStatuses)->where('status_id', 24)->last();
                $holdType = collect($ship->boxStatuses)->where('status_id', 26)->last();
                $shortType = collect($ship->boxStatuses)->where('status_id', 27)->last();

                $datas[$key]['collectedDate'] = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                $datas[$key]['receivedDate'] = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                $datas[$key]['bookedDate'] = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                $datas[$key]['forwardedDate'] = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                $datas[$key]['arrivedDate'] = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                $datas[$key]['waitingDate'] = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                $datas[$key]['onHoldDate'] = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                $datas[$key]['clearedDate'] = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                $datas[$key]['arrangedDate'] = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                $datas[$key]['outDate'] = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                $datas[$key]['deliveredDate'] = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                $datas[$key]['notDeliveredDate'] = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                $datas[$key]['pendingDate'] = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                $datas[$key]['moreTrackingDate'] = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                $datas[$key]['transferDate'] = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;
                $datas[$key]['receivedDate'] = (!empty($receivedType)) ?  date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                $datas[$key]['holdDate'] = (!empty($holdType)) ?  date('d-m-Y',strtotime($holdType->created_at)) : '' ;
                $datas[$key]['shortDate'] = (!empty($shortType)) ?  date('d-m-Y',strtotime($shortType->created_at)) : '' ;

                $status = collect($ship->boxStatuses)->last();
                $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
                $datas[$key]['lastStatus'] = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;

                if($datas[$key]['lastStatus'] == "Shipment on hold") {
                    $datas[$key]['style'] = 'background-color:#ffdb00;';
                } else if($datas[$key]['lastStatus'] == "Pending") {
                    $datas[$key]['style'] = 'background-color:#ec1616e6;';
                } else {
                    $datas[$key]['style'] = 'background-color:none;';
                }
                $datas[$key]['booking_number'] = $ship->shipment->booking_number;
                $datas[$key]['shipment_id'] = $getShip->shipment_id;
                $datas[$key]['full_name'] = $getShip->createdBy->full_name;
                $datas[$key]['view'] = '<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm detailedView">View</a>';
            }
        }
        return response()->json($datas);
    }

    public function viewStatusDataReport($status) {
        $query = Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','boxStatuses.status','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('is_shipment',1);
        if($status == 15) {
            $ships = $query->orderBy('id','desc')->get();
        } else {
            $ships = $query->whereHas('boxStatuses', function ($q) use ($status) {
                $q->where('boxes_statuses.status_id',$status);
            })->orderBy('id','desc')->get();
        }
        $datas = [];
            foreach($ships as  $key => $ship) {
                $getShip = Ships::with('createdBy')->where('id',$ship->ship_id)->first();
                $datas[$key]['createdDate'] = (!empty($getShip->created_date) ) ? date('d-m-Y',strtotime($getShip->created_date)) : '';
                $datas[$key]['portOfOrigins'] = (!empty($getShip->portOfOrigins) ) ? $getShip->portOfOrigins->name : '';
                $datas[$key]['clearingAgents'] = (!empty($getShip->clearingAgents) ) ? $getShip->clearingAgents->name : '';
                $datas[$key]['shipmentTypes'] = (!empty($getShip->shipmentMethodTypes) ) ? $getShip->shipmentMethodTypes->name : '';
                $datas[$key]['awb_number'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
                $datas[$key]['createdBy'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
                $datas[$key]['boxes'] = (!empty($ship->box_name) ) ? $ship->box_name : '';

                if(!empty($ship->boxStatuses)) {
                    $collectedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->last();
                    $receivedType = collect($ship->boxStatuses)->where('status_id', 1)->last();
                    $bookedType = collect($ship->boxStatuses)->where('status_id', 2)->last();
                    $forwardedType = collect($ship->boxStatuses)->where('status_id', 3)->last();
                    $arrivedType = collect($ship->boxStatuses)->where('status_id', 4)->last();
                    $waitingType = collect($ship->boxStatuses)->where('status_id', 5)->last();
                    $onHoldType = collect($ship->boxStatuses)->where('status_id', 7)->last();
                    $clearedType = collect($ship->boxStatuses)->where('status_id', 8)->last();
                    $arrangedType = collect($ship->boxStatuses)->where('status_id', 9)->last();
                    $outType = collect($ship->boxStatuses)->where('status_id', 10)->last();
                    $deliveredType = collect($ship->boxStatuses)->where('status_id', 11)->last();
                    $notDeliveredType = collect($ship->boxStatuses)->where('status_id', 12)->last();
                    $pendingType = collect($ship->boxStatuses)->where('status_id', 13)->last();
                    $moreTrackingType = collect($ship->boxStatuses)->where('status_id', 14)->last();
                    $transferType = collect($ship->boxStatuses)->where('status_id', 17)->last();
                    $receivedType = collect($ship->boxStatuses)->where('status_id', 24)->last();
                    $holdType = collect($ship->boxStatuses)->where('status_id', 26)->last();
                    $shortType = collect($ship->boxStatuses)->where('status_id', 27)->last();

                    $datas[$key]['collectedDate'] = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                    $datas[$key]['receivedDate'] = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                    $datas[$key]['bookedDate'] = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                    $datas[$key]['forwardedDate'] = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                    $datas[$key]['arrivedDate'] = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                    $datas[$key]['waitingDate'] = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                    $datas[$key]['onHoldDate'] = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                    $datas[$key]['clearedDate'] = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                    $datas[$key]['arrangedDate'] = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                    $datas[$key]['outDate'] = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                    $datas[$key]['deliveredDate'] = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                    $datas[$key]['notDeliveredDate'] = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                    $datas[$key]['pendingDate'] = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                    $datas[$key]['moreTrackingDate'] = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                    $datas[$key]['transferDate'] = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;
                    $datas[$key]['receivedDate'] = (!empty($receivedType)) ?  date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                    $datas[$key]['holdDate'] = (!empty($holdType)) ?  date('d-m-Y',strtotime($holdType->created_at)) : '' ;
                    $datas[$key]['shortDate'] = (!empty($shortType)) ?  date('d-m-Y',strtotime($shortType->created_at)) : '' ;

                    $status = collect($ship->boxStatuses)->last();
                    $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
                    $datas[$key]['lastStatus'] = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;

                    if($datas[$key]['lastStatus'] == "Shipment on hold") {
                        $datas[$key]['style'] = 'background-color:#ffdb00;';
                    } else if($datas[$key]['lastStatus'] == "Pending") {
                        $datas[$key]['style'] = 'background-color:#ec1616e6;';
                    } else {
                        $datas[$key]['style'] = 'background-color:none;';
                    }
                    $datas[$key]['booking_number'] = $ship->shipment->booking_number;
                    $datas[$key]['shipment_id'] = $getShip->shipment_id;
                    $datas[$key]['full_name'] = $getShip->createdBy->full_name;
                    $datas[$key]['view'] = '<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm detailedView">View</a>';
                }
            }
        return response()->json($datas);
    }

    public function detailed(Request $request)
    {
       $shipmentNumber = $request->shipmentNumber;
       $boxNumber = $request->bookingNumber;
       $querys = Boxes::with('boxStatuses','boxStatuses.status')
                                    ->where('box_name',$boxNumber)->first();
        $boxeses = $querys;
        foreach($querys->boxStatuses as $key => $status) {
            $boxeses['boxStatuses'][$key]['dated'] = date('d-m-Y',strtotime($status->created_at));
        }
        return response()->json($boxeses);
    }

    public function update_origin_id()
    {

            try {
                \DB::beginTransaction();

                $shipments = Shipments::all();
                foreach($shipments as $key => $shipment) {
                    $shipments = Shipments::findOrFail($shipment->id);
                    $shipments->origin_id = $shipments->branch_id;
                    $shipments->save();

                }
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

    public function transferGoods(Request $request) {


        // $shipment_ids = explode(',', $request->sel_goods_id);
        // if(!empty($shipment_ids)){
        //     foreach( $shipment_ids as $shipment ){

        //         $shipments = explode('-', $shipment);

        //          $shipment_id = $shipments[0];
        //             echo  $shipment_id ;

        //          $invoice_number = $shipments[1];
        //             echo    $invoice_number;

        //     }
        // }

        // dd("sasa");
        // return false;

        if($request->sel_goods_id != NULL){
            $shipment_ids = explode(',', $request->sel_goods_id);
            if(!empty($shipment_ids)){
                foreach( $shipment_ids as $shipment ){

                    $shipments = explode('-', $shipment);

                     $box_id = $shipments[0];
                     $invoice_number = $shipments[1];


                    $box = Boxes::with('boxStatuses')->findOrFail($box_id);

                    $status         = collect($box->boxStatuses)->last();
                    $lastStausId    = $status->id;
                    $lastStatusName = (!empty($status)) ? $status->status->name :'' ;


                    $shipments = Shipments::findOrFail( $box->shipment_id );
                    // $shipments->status_id =  17;
                    // $shipments->save();

                    $box->is_transfer =  1;
                    $box->transfer_status =  'pending';
                    $box->save();
                    // ADD ONE STATUS TO BOX STATUS TABLE FOR TRACKING PURPOSE
                    $bookings = new BoxesStatuses();
                    $bookings->status_id = 17; // Transfer status id
                    $bookings->box_id = $box_id;
                    $bookings->created_at =  date('Y-m-d');
                    $bookings->save();



                    $goods_details = new GoodsDetails();

                    $goods_details->sort_order = $shipments->sort_order;
                    $goods_details->tracking_number = $shipments->booking_number;
                    $goods_details->invoice_number = $invoice_number;
                    $goods_details->box_id = $box_id;

                    $goods_details->agency_id = $shipments->agency_id;
                    $goods_details->current_status_id = $lastStausId; // last status id
                    $goods_details->status = $lastStatusName; // status name
                    $goods_details->sender_id = $shipments->sender_id;
                    $goods_details->receiver_id = $shipments->receiver_id;
                    $goods_details->company_id = $shipments->company_id;
                    $goods_details->branch_id = $request->transfer_to;

                    $goods_details->origin_id = $shipments->origin_id;
                    $goods_details->is_transfer = $shipments->is_transfer;
                    $goods_details->transfer_status = 'pending';
                    $goods_details->prev_branch_id = $shipments->prev_branch_id;
                    $goods_details->driver_id = $shipments->driver_id;
                    $goods_details->staff_id = $shipments->staff_id;
                    $goods_details->created_by = $shipments->created_by;
                    $goods_details->updated_by = $shipments->updated_by;
                    $goods_details->shiping_date = $shipments->shiping_date;
                    $goods_details->receipt_number = $shipments->receipt_number;
                    $goods_details->packing_type = $shipments->packing_type;
                    $goods_details->courier_company = $shipments->courier_company;
                    $goods_details->shiping_method = $shipments->shiping_method;
                    $goods_details->payment_method = $shipments->payment_method;
                    $goods_details->payment_status = $shipments->payment_status;
                    $goods_details->number_of_pcs = 1;

                    $goods_details->other_charges = $shipments->other_charges;
                    $goods_details->discount = $shipments->discount;
                    $goods_details->total_amount = $shipments->total_amount;
                    $goods_details->barcode = $shipments->barcode;
                    $goods_details->date = $shipments->date;
                    $goods_details->tracking_url = $shipments->tracking_url;
                    $goods_details->created_date = $shipments->created_date;
                    $goods_details->shipping_method_id = $shipments->shipping_method_id;
                    $goods_details->lrl_tracking_code = $shipments->lrl_tracking_code;
                    $goods_details->normal_weight = $shipments->normal_weight;
                    $goods_details->rate_normal_weight = $shipments->rate_normal_weight;
                    $goods_details->amount_normal_weight = $shipments->amount_normal_weight;
                    $goods_details->electronics_weight = $shipments->electronics_weight;
                    $goods_details->rate_electronics_weight = $shipments->rate_electronics_weight;
                    $goods_details->amount_electronics_weight = $shipments->amount_electronics_weight;
                    $goods_details->rate_msic_weight = $shipments->rate_msic_weight;
                    $goods_details->amount_msic_weight = $shipments->amount_msic_weight;
                    $goods_details->other_weight = $shipments->other_weight;
                    $goods_details->rate_other_weight = $shipments->rate_other_weight;
                    $goods_details->amount_other_weight = $shipments->amount_other_weight;
                    $goods_details->grand_total_weight = $shipments->grand_total_weight;
                    $goods_details->rate_grand_total = $shipments->rate_grand_total;
                    $goods_details->amount_grand_total = $shipments->amount_grand_total;
                    $goods_details->msic_weight = $shipments->msic_weight;
                    $goods_details->grand_total_box_value = $shipments->grand_total_box_value;
                    $goods_details->total_freight = $shipments->total_freight;
                    $goods_details->misc_freight = $shipments->misc_freight;
                    $goods_details->document_charge = $shipments->document_charge;
                    $goods_details->grand_total = $shipments->grand_total;
                    $goods_details->package_total_amount = $shipments->package_total_amount;
                    $goods_details->package_total_quantity = $shipments->package_total_quantity;
                    $goods_details->ship_id = $shipments->ship_id;
                    $goods_details->collected_by = $shipments->collected_by;
                    $goods_details->delivery_type = $shipments->delivery_type;
                    $goods_details->comment_box = $shipments->comment_box;
                    $goods_details->time = $shipments->time;


                    $goods_details->weight = $box->weight;
                    $goods_details->rate = $box->rate;
                    $goods_details->packing_charge = $box->box_packing_charge;

                    $goods_details->length = $box->boxDimension->length;
                    $goods_details->width = $box->boxDimension->width;
                    $goods_details->height = $box->boxDimension->height;

                    $goods_details->transfer_date =  $request->transfer_date;
                    // $goods_details->received_date =  ;

                    $goods_details->save();



                    $shipmentTransfer = new ShipmentTransfers();
                    $shipmentTransfer->goods_details_id = $goods_details->id;
                    $shipmentTransfer->box_id = $box->id;
                    $shipmentTransfer->tracking_number = $shipments->booking_number;
                    $shipmentTransfer->invoice_number = $invoice_number;
                    $shipmentTransfer->transfer_from = $request->transfer_from;
                    $shipmentTransfer->transfer_to = $request->transfer_to;
                    $shipmentTransfer->driver_id = $request->driver_id;
                    $shipmentTransfer->transferred_status =  'pending';

                    $shipmentTransfer->save();

                    $goods_details->shipment_transfer_id = $shipmentTransfer->id;
                    $goods_details->save();




                }


                return response()->json([
                    'success' => true, 'message' => 'Transferred Successfully'
                ]);
            }
            }
            else {
                return response()->json([
                    'success' => true, 'message' => 'No Goods selected !'
                ]);
            }


    }


    public function transferredGoods(Request $request) {

        // $querys = GoodsDetails::with('shipmentTransfer','shipmentTransfer.transferFrom', 'shipmentTransfer.transferTo')
        //                     ->where('origin_id',branch()->id)
        //                     ->where('is_transfer', 1);

        // $goods = $querys->get();

        $goods = Boxes::with('boxTransfer','boxTransfer.transferTo', 'boxTransfer.transferFrom')->where('is_transfer', 1)->get();
        // dd($goods);

        return view('branches.shipments.transferred_goods',compact( 'goods' ));

    }

    public function pendingGoods(Request $request) {

        $querys = GoodsDetails::with('shipmentTransfer','shipmentTransfer.transferFrom', 'shipmentTransfer.transferTo')
                            ->where('branch_id',branch()->id)
                            ->where('transfer_status', 'pending');

        $goods = $querys->get();

        return view('branches.shipments.pending_goods',compact( 'goods' ));

    }


    public function transferConfirm(Request $request) {

        if($request->sel_goods_id != NULL){
            $goods_ids = explode(',', $request->sel_goods_id);
            if(!empty($goods_ids)){
                foreach( $goods_ids as $goods ){
                    $goods_details = GoodsDetails::findOrFail($goods);

                        $shipmentTransfer = ShipmentTransfers::findOrFail( $goods_details->shipment_transfer_id );
                        $shipmentTransfer->transferred_status =  'confirmed';
                        $shipmentTransfer->save();

                    $goods_details->transfer_status =  'confirmed';

                    $goods_details->received_date = date('Y-m-d H:i:s');
                    $goods_details->save();

                }

                return response()->json([
                    'success' => true, 'message' => 'Transfer Confirmed Successfully'
                ]);
            }}
            else {
                return response()->json([
                    'success' => true, 'message' => 'No Goods selected !'
                ]);
            }


    }
    public function allGoods(Request $request) {


        if ($request->has('keyword') != "") {
            // $keyword = $request->keyword;
            // $client_ids = Customers::where("phone", "like", "%$keyword%")
            //     ->orWhere("identification_number", "like", "%$keyword%")
            //     ->get()
            //     ->pluck('id');

            // $shipments = GoodsDetails::where('branch_id',branch()->id)->query();
            // if (count($client_ids) > 0) {
            //     $shipments = $shipments->whereIn("sender_id", $client_ids);
            // }
            // $shipments = $shipments->orWhere('booking_number', 'like', '%' . $keyword . '%');

            // $shipments = $shipments->orderBy('created_at', 'desc')->get();
            $goods = GoodsDetails::where('branch_id',branch()->id)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->get();


        } else {
            $goods = GoodsDetails::where('branch_id',branch()->id)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->get();
        }

        return view('branches.shipments.allgoods', compact('goods'));


    }

    public function updateSortOrder(Request $request){
        print_r( $request->id);
        echo "sasas";
        die;
    }

    public function shipmentlistReport(Request $request) {

        return view('branches.shipments.shipmentsReportList',compact('statuses','datas'));

    }

    public function getBoxData(Request $request){
        $boxName = $request->query('box_name');
        $boxData = Boxes::where('box_name', $boxName)->first();

        if ($boxData) {
            return response()->json(['success' => true, 'data' => $boxData]);
        } else {
            return response()->json(['success' => false, 'message' => 'Box not found']);
        }
    }
    public function exportView(Request $request)
    {

        // Get input data
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $search = $request->input('search');
        $branchId = $request->input('branch');

        // Create a query
        $query = Shipments::with('driver', 'sender', 'receiver')->where('branch_id', branch()->id);

        // Apply filters
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($fromDate) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->startOfDay()->toDateString();
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->endOfDay()->toDateString();
            $query->whereDate('created_at', '<=', $toDate);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('booking_number', 'like', "%$search%")
                    ->orWhereHas('sender', function ($query) use ($search) {
                        $query->where('phone', 'like', "%$search%");
                    })
                    ->orWhereHas('receiver', function ($query) use ($search) {
                        $query->where('phone', 'like', "%$search%");
                    });
            });
        }

        // Get all data
        $shipments = $query->latest()->get();
        return view("superadmin.shipments.report", compact("shipments"));

    }


}
