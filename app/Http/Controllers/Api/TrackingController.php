<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipments;
use App\Models\Boxes;
class TrackingController extends Controller
{
    public function tracking(Request $request)
    {
        $booking_no = $request->booking_no;  
        $shipments = Shipments::where('booking_number', $booking_no)
            ->with('receiver', 'boxes', 'boxes.boxStatuses', 'boxes.boxStatuses.status')
            ->first();
    
        if (isset($shipments)) {
            $data = collect();
    
            foreach ($shipments->boxes as $j => $box) {
                $item = collect();
                $item->put('box_name', $box->box_name);
    
                $statuses = collect();
                foreach ($box->boxStatuses as $status) {
                    $list_task = collect();
                    $list_task->put('status', $status->status->name);
                    $list_task->put('comment', $status->comment);
                    $list_task->put('date', $status->updated_at->format('d-m-Y')); // Ensure all statuses' dates are added
                    $statuses->push($list_task);
                }
    
                // Handle case where no statuses exist for a box
                if ($statuses->isEmpty()) {
                    $list_task = collect([
                        'status' => $shipments->statusVal->name ?? 'Unknown',
                        'comment' => '',
                        'date' => $shipments->updated_at->format('d-m-Y'),
                    ]);
                    $statuses->push($list_task);
                }
    
                $item->put('statuses', $statuses);
                $data->push($item);
            }
    
            $comment = $shipments->boxes->firstWhere('comment', '!=', null)['comment'] ?? null;
    
            $address = collect([
                'invoice_number' => $shipments->booking_number,
                'invoice_date' => $shipments->created_at->format('d/m/Y'),
                'receiver_name' => $shipments->receiver->name ?? '',
                'receiver_address' => $shipments->receiver->address->address ?? '',
                'receiver_city_name' => $shipments->receiver->city_name ?? '',
                'receiver_district' => $shipments->receiver->address->district->name ?? '',
                'receiver_state' => $shipments->receiver->address->state->name ?? '',
                'receiver_country' => $shipments->receiver->address->country->name ?? '',
                'receiver_zip_code' => $shipments->receiver->zip_code ?? '',
                'receiver_boxes' => count($shipments->boxes) ?? '',
                'receiver_comment' => $comment ?? ''
            ]);
    
            return response()->json([
                'success' => true,
                'data' => $data,
                'address' => $address,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No data is available'
            ]);
        }
    }
    
    


}

