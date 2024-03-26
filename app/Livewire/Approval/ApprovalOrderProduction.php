<?php

namespace App\Livewire\Approval;

use App\Http\Controllers\GenerateNumberController;
use Carbon\Carbon;
use App\Models\Marketing\Marketing;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ApprovalOrderProduction extends Component
{
    use WithPagination, WithoutUrlPagination; 

    public $id, $po_buyer_no, $po_buyer_date, $buyer_code, $buyer_name, $shipping_date, $delivery_date, $due_date, $currency, $discount, $down_payment, $tax, $pic_name, $pic_title; 

    public $articles, $validate;

    public function show($id)
    {
        $data = Marketing::where('id', $id)->first();   
        $this->id = $data->id;     
        $this->articles = $data->articles;
        $this->validate = $data->validate;
        $this->po_buyer_no = $data->po_buyer_no;
        $this->po_buyer_date = $data->po_buyer_date;
        $this->buyer_code = $data->buyer_code;
        $this->buyer_name = $data->buyer_name;
        $this->shipping_date = $data->shipping_date;
        $this->delivery_date = $data->delivery_date;
        $this->due_date = $data->due_date;
        $this->pic_name = $data->pic_name;
        $this->pic_title = $data->pic_title;
        $this->currency = $data->currency;
        $this->discount = $data->discount;
        $this->down_payment = $data->down_payment;
        $this->tax = $data->tax;
    }

    public function approve()
    {
        try {           
            $call = new GenerateNumberController();
            $number = $call->generateNumber('op');
            Marketing::where('id', $this->id)->update([
                'order_production_no' => $number,
                'order_production_date' => Carbon::now(),
                'validate' => 'Approve',
                'validate_date' => Carbon::now()
            ]);
            $this->dispatch('success', 'PO Approved with OP No. ' . $number);
            $this->dispatch('show-modal-close');
        } catch (\Exception $e) {

        }
    }

    public function reject()
    {
        try {
            Marketing::where('id', $this->id)->update([
                'validate' => 'Reject'
            ]);
            $this->dispatch('error', 'PO Rejected');
        } catch (\Exception $e) {

        }
    }

    public function render()
    {
        return view('livewire.approval.approval-order-production', [
            'data' => Marketing::where('validate', 'Waiting')->paginate(10)
        ]);
    }
}
