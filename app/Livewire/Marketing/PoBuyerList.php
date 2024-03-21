<?php

namespace App\Livewire\Marketing;

use App\Models\Marketing\Marketing;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PoBuyerList extends Component
{
    use WithPagination, WithoutUrlPagination; 

    public $id, $po_buyer_no, $po_buyer_date, $buyer_code, $buyer_name, $shipping_date, $delivery_date, $due_date, $currency, $discount, $down_payment, $tax, $pic;
    public $order_production_no;
    public $articles, $validate;

    public function show($id)
    {
        $data = Marketing::where('id', $id)->first();   
        $this->id = $data->id;     
        $this->articles = $data->articles;
        $this->validate = $data->validate;
        $this->po_buyer_no = $data->po_buyer_no;
        $this->po_buyer_date = $data->po_buyer_date;
        $this->buyer_code = isset($data->buyer->code_buyer) ? $data->buyer->code_buyer : null;
        $this->buyer_name = isset($data->buyer->buyer_name) ? $data->buyer->buyer_name : null;
        $this->shipping_date = $data->shipping_date;
        $this->delivery_date = $data->delivery_date;
        $this->due_date = $data->due_date;
        $this->pic = isset($data->pic->name) ? $data->pic->name : null;
        $this->currency = isset($data->currency->currency_code) ? $data->currency->currency_code : null;
        $this->discount = $data->discount;
        $this->down_payment = $data->down_payment;
        $this->tax = $data->tax;
        $this->order_production_no = $data->order_production_no;
    }

    public function render()
    {
        return view('livewire.marketing.po-buyer-list', [
            'data' => Marketing::get()
        ]);
    }
}
