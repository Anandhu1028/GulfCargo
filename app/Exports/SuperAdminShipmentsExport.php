<?php

namespace App\Exports;

use App\Models\Shipments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
class SuperAdminShipmentsExport implements FromCollection, WithHeadings
{
    protected $fromDate;
    protected $toDate;
    protected $search;
    protected $branchId;

    public function __construct($fromDate, $toDate, $search, $branchId)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->search = $search;
        $this->branchId = $branchId;
    }

    public function collection()
    {
        $query = Shipments::with(['driver', 'sender', 'receiver', 'branch']);

        if ($this->branchId) {
            $query->where('branch_id', $this->branchId);
        }

        if ($this->fromDate) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $this->fromDate)->startOfDay()->toDateString();
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($this->toDate) {
            $toDate = Carbon::createFromFormat('d/m/Y', $this->toDate)->endOfDay()->toDateString();
            $query->whereDate('created_at', '<=', $toDate);
        }

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('booking_number', 'like', "%{$this->search}%")
                    ->orWhereHas('sender', function ($query) {
                        $query->where('phone', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('receiver', function ($query) {
                        $query->where('phone', 'like', "%{$this->search}%");
                    });
            });
        }

        $shipments = $query->get();

        // Format the collection to match the headings
        $formattedShipments = $shipments->map(function ($shipment, $index) {
            return [
                'SL NO' => $index + 1,
                'INVOICE NUMBER' => $shipment->invoice_number,
                // 'SHIPPING METHOD' => $shipment->shipMethType->name,
                'STATE' => $shipment->receiver->address->state->name,
                'PAYMENT MODE' => $shipment->payment_method,
                'NO OF PCS' => $shipment->number_of_pcs,
                'WEIGHT' => $shipment->grand_total_weight,
                'UNIT RATE' => $shipment->rate_normal_weight,
                'PACKING CHARGES' => $shipment->amount_msic_weight,
                'ADD PACKING CHARGES' => $shipment->amount_add_pack_charge,
                'AWB CHARGE' => $shipment->amount_awbfee,
                'DUTY' => $shipment->amount_electronics_weight,
                // 'OTHER CHARGES' => $shipment->other_charges,
                'DISCOUNT' => $shipment->amount_discount_weight,
                'TOTAL' => $shipment->amount_grand_total,
                // 'PARTICULARS' => $shipment->particulars,
                // 'AMOUNT' => $shipment->amount,
            ];
        });

        return $formattedShipments;
    }

    public function headings(): array
    {
        return [
            'SL NO',
            'INVOICE NUMBER',
            // 'SHIPPING METHOD',
            'STATE',
            'PAYMENT MODE',
            'NO OF PCS',
            'WEIGHT',
            'UNIT RATE',
            'PACKING CHARGES',
            'ADD PACKING CHARGES',
            'AWB CHARGE',
            'DUTY',
            // 'OTHER CHARGES',
            'DISCOUNT',
            'TOTAL',
            // 'PARTICULARS',
            // 'AMOUNT'
        ];
    }
}
