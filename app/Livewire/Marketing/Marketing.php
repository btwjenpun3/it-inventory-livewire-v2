<?php

namespace App\Livewire\Marketing;

use App\Models\Marketing\Article;
use App\Models\Master\MasterArticle;
use App\Models\Marketing\Marketing as Md;
use App\Models\Master\MasterBuyer as Buyer;
use App\Models\Master\MasterSatuan as Unit;
use App\Models\Master\MasterPic as Pic;
use App\Models\Master\MasterCurrency as Currency;
use App\Models\Master\MasterColor as Color;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Marketing extends Component
{   
    public $id, $po_buyer_no, $po_buyer_date, $buyer_code, $buyer_name, $shipping_date, $delivery_date, $due_date, $currency, $discount, $down_payment, $tax, $pic; 
    
    public $po_buyer_no_, $po_buyer_date_, $buyer_code_, $buyer_name_, $shipping_date_, $delivery_date_, $due_date_, $articles_, $currency_, $discount_, $down_payment_, $tax_, $validate_;

    /**
     * Show PIC
     */
    public $pic_name_, $pic_title_;

    public $no = 1;
    public $rows = [];

    protected function rules()
    {
        $rules = [
            'po_buyer_no'   => 'required',
            'po_buyer_date' => 'required',
            'buyer_code'    => 'required',
            'shipping_date' => 'required',
            'delivery_date' => 'required',
            'due_date'      => 'required',
            'currency'      => 'required',
            'discount'      => 'required',
            'down_payment'  => 'required',
            'tax'           => 'required',
            'pic'           => 'required',
        ];        
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
        $this->validate([
            'rows.*.article' => 'required',
            'rows.*.color' => 'required',
            'rows.*.size' => 'required', 
            'rows.*.quantity' => 'required',
            'rows.*.unit' => 'required'
        ]);
        try {
            $pic = Pic::where('id', $this->pic)->first();
            $marketing = Md::create([
                'po_buyer_no'   => $this->po_buyer_no,
                'po_buyer_date' => $this->po_buyer_date,
                'buyer_code'    => $this->buyer_code,
                'buyer_name'    => $this->buyer_name,
                'shipping_date' => $this->shipping_date,
                'delivery_date' => $this->delivery_date,
                'due_date'      => $this->due_date,
                'discount'      => $this->discount,
                'down_payment'  => $this->down_payment,
                'tax'           => $this->tax,
                'pic_name'      => $pic->name,
                'pic_title'     => $pic->title,
                'pic_email'     => $pic->email,
                'currency'      => $this->currency,
                'validate'      => 'Waiting'
            ]);
            if($marketing) {
                foreach($this->rows as $row) {
                   $data =  MasterArticle::where('id', $row['article'])->first();
                   $unit = Unit::where('id', $row['unit'])->first();
                    Article::create([
                        'marketing_id' => $marketing->id,
                        'article_code' => $data->article_code,
                        'article_name' => $data->article_name,
                        'size'         => $row['size'],
                        'description'  => $data->description,
                        'quantity'     => $row['quantity'],
                        'color'        => $row['color'],
                        'unit'         => $unit->satuan
                    ]);
                }
                $this->dispatch('success', 'Data successfully saved');
                $this->dispatch('create-modal-close');
                $this->reset();
                $this->addRow();
            }
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());        
        }
    }
   

    public function fillBuyerName($buyerCode = null)
    {
        if ($buyerCode) {
            $data = Buyer::where('buyer_code', $buyerCode)->first();
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
        $this->buyer_code_ = $data->buyer_code;
        $this->buyer_name_ = $data->buyer_name;
        $this->shipping_date_ = $data->shipping_date;
        $this->delivery_date_ = $data->delivery_date;
        $this->due_date_ = $data->due_date;
        $this->articles_ = $data->articles;
        $this->pic_name_ = $data->pic_name;
        $this->pic_title_ = $data->pic_title;
        $this->currency_ = $data->currency;
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
            'currencies' => Currency::get(),
            'colors' => Color::get()
        ]);
    }
}
