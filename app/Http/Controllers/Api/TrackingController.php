<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipments;
use App\Models\Boxes;
class TrackingController extends Controller
{
    public function tracking(Request $request) {
        $booking_no = $request->booking_no;
        $shipments = Shipments::where('booking_number', $booking_no)->with('receiver')->first();

        if (isset($shipments)) {
            $querys = [];
            foreach ($shipments->boxes as $i => $shipment) {
                $querys[$i] = Boxes::with('boxStatuses', 'boxStatuses.status')
                    ->where('box_name', $shipment->box_name)->first();
            }

            $boxeses = $querys;
            $data = collect();
            foreach ($querys as $j => $query) {
                $item = collect();
                $item->put('box_names', $query->box_name);

                $statuses = collect();
                if (isset($query->boxStatuses[0])) {
                    foreach ($query->boxStatuses as $k => $status) {
                        $list_task = collect();
                        $list_task->put('status', $status->status->name);
                        $list_task->put('comment', $status->comment);
                        $list_task->put('date', $status->updated_at->format('d-m-Y'));
                        $statuses->put($k, $list_task);
                    }
                    $item->put('statuses', $statuses);
                } else {
                    $list_task = collect();
                    $list_task->put('status', $shipments->statusVal->name);
                    $list_task->put('comment', '');
                    $list_task->put('date', $shipments->updated_at->format('d-m-Y'));
                    $item->put('statuses',array($list_task));
                }
                $data->put($j, $item);
            }
            $comment = $shipments->boxes->firstWhere('comment', '!=', null)['comment'] ?? null;
            $adress = collect([
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
                'adress' => $adress,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'no data is available'
            ]);
        }
    }


}

