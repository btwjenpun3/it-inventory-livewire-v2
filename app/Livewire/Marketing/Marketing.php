<?php

namespace App\Livewire\Marketing;

use App\Models\Marketing\Article;
use App\Models\Master\MasterArticle;
use App\Models\Marketing\Marketing as Md;
use App\Models\Master\MasterBuyer as Buyer;
use App\Models\Master\MasterSatuan as Unit;
use App\Models\Master\MasterPic as Pic;
use App\Models\Master\MasterCurrency as Currency;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Marketing extends Component
{   
    public $id, $po_buyer_no, $po_buyer_date, $buyer_code, $buyer_name, $shipping_date, $delivery_date, $due_date, $currency, $discount, $down_payment, $tax, $pic; 
    
    public $po_buyer_no_, $po_buyer_date_, $buyer_code_, $buyer_name_, $shipping_date_, $delivery_date_, $due_date_, $articles_, $currency_, $discount_, $down_payment_, $tax_, $pic_, $validate_;

    public $no = 1;
    public $rows = [];

    protected function rules()
    {
        $rules = [
            'po_buyer_no' => 'required',
            'po_buyer_date' => 'required',
            'buyer_code' => 'required',
            'shipping_date' => 'required',
            'delivery_date' => 'required',
            'due_date' => 'required',
            'currency' => 'required',
            'discount' => 'required',
            'down_payment' => 'required',
            'tax' => 'required',
            'pic' => 'required',
        ];
        foreach ($this->rows as $key => $value) {
            $rules["rows.{$key}.article"] = 'required';
            $rules["rows.{$key}.quantity"] = 'required';
            $rules["rows.{$key}.unit"] = 'required';
        }
        return $rules;
    }


    public function mount()
    {
        $this->rows[] = array(
            'no'        => $this->no,
            'article'   => '',
            'quantity'  => '',
            'unit'      => ''
        );
    }

    public function save()
    {
        $this->validate();
        try {
            $marketing = Md::create([
                'po_buyer_no' => $this->po_buyer_no,
                'po_buyer_date' => $this->po_buyer_date,
                'buyer_id' => $this->buyer_code,
                'shipping_date' => $this->shipping_date,
                'delivery_date' => $this->delivery_date,
                'due_date' => $this->due_date,
                'discount' => $this->discount,
                'down_payment' => $this->down_payment,
                'tax' => $this->tax,
                'pic_id' => $this->pic,
                'currency_id' => $this->currency,
                'validate' => 'Waiting'
            ]);
            if($marketing) {
                foreach($this->rows as $row) {
                    Article::create([
                        'marketing_id' => $marketing->id,
                        'master_article_id' => $row['article'],
                        'quantity' => $row['quantity'],
                        'unit_id' => $row['unit']
                    ]);
                }
                $this->dispatch('success', 'Data successfully saved');
                $this->dispatch('create-modal-close');
            }
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());        
        }
    }
   

    public function fillBuyerName($id = null)
    {
        if ($id) {
            $data = Buyer::where('id', $id)->first();
            $this->buyer_name = $data->buyer_name;
        } else {
            $this->buyer_name = null;
        }        
    }

    public function addRow()
    {        
        $no = $this->no++;
        $this->rows[] = array(
            'no'        => $no,
            'article'   => '',
            'quantity'  => '',
            'unit'      => ''
        );
    }

    public function removeRow($key)
    {
        unset($this->rows[$key]);
    }

    public function show($id)
    {
        $data = Md::where('id', $id)->first();
        $this->po_buyer_no_ = $data->po_buyer_no;
        $this->po_buyer_date_ = $data->po_buyer_date;
        $this->buyer_code_ = isset($data->buyer->code_buyer) ? $data->buyer->code_buyer : null;
        $this->buyer_name_ = isset($data->buyer->buyer_name) ? $data->buyer->buyer_name : null;
        $this->shipping_date_ = $data->shipping_date;
        $this->delivery_date_ = $data->delivery_date;
        $this->due_date_ = $data->due_date;
        $this->articles_ = $data->articles;
        $this->pic_ = isset($data->pic->name) ? $data->pic->name : null;
        $this->currency_ = isset($data->currency->currency_code) ? $data->currency->currency_code : null;
        $this->discount_ = $data->discount;
        $this->down_payment_ = $data->down_payment;
        $this->tax_ = $data->tax;
        $this->validate_ = $data->validate;

    }

    public function deleteConfirm($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        try {
            Md::where('id', $this->id)->delete();
            $this->dispatch('success', 'Data successfully deleted');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage()); 
        }
    }

    public function render()
    {
        return view('livewire.marketing.marketing', [
            'data' => Md::orderBy('id', 'desc')->where('validate', 'Waiting')->paginate(10),
            'articles' => MasterArticle::get(),
            'buyers' => Buyer::get(),
            'units' => Unit::get(),
            'pics' => Pic::get(),
            'currencies' => Currency::get()
        ]);
    }
}
