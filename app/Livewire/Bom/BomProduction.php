<?php

namespace App\Livewire\Bom;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Marketing\Article;
use App\Models\Master\MasterMaterialType as MaterialType;
use App\Models\Master\MasterSatuan as Unit;
use App\Models\Bom\BomProduction as Bom;
use App\Models\Bom\BomProductionDetail as BomDetail;
use App\Models\Marketing\Marketing;

class BomProduction extends Component
{
    public $id, $order_production_no, $po_buyer_no, $pic_name, $buyer_code, $buyer_name;

    public $article_id, $article_no, $article_no_;

    public $bomId, $bomCode, $bomName, $bomDescription, $bomStatus, $bomMaterialType;
    public $bomRows = [];

    public $bomId_, $bomCode_, $bomName_, $bomDescription_, $bomStatus_, $bomMaterialType_;
    public $bomDetails;

    public function mount()
    {
        $this->bomRows[] = array(
            'bomMaterial' => '',
            'bomIngredient' => '',
            'bomQuantity' => '',
            'bomUnit' => '',
            'bomLevel' => ''
        );
    }

    public function show($id)
    {
        $data = Marketing::where('id', $id)->first();
        $this->id = $id;
        $this->order_production_no = $data->order_production_no;
        $this->po_buyer_no = $data->po_buyer_no;
        $this->pic_name = $data->pic->name;
        $this->buyer_code = $data->buyer->code_buyer;
        $this->buyer_name = $data->buyer->buyer_name;
    }

    public function showBom($id)
    {
        $data = Article::where('id', $id)->first();
        $this->article_id = $id;
        $this->article_no = $data->article;          
    }
    public function showBomDetail($id)
    {
        $data = Article::where('id', $id)->first();
        $this->article_no_ = $data->article;
        $this->bomId_ = $data->bom->id;
        $this->bomCode_ = $data->bom->bom_no;
        $this->bomName_ = $data->bom->bom_name;
        $this->bomDescription_ = $data->bom->description;
        $this->bomDetails = $data->bom->details;
    }

    public function addRow()
    {
        $this->bomRows[] = array(
            'bomMaterial' => '',
            'bomIngredient' => '',
            'bomQuantity' => '',
            'bomUnit' => '',
            'bomLevel' => ''
        );
    }

    public function removeRow($key)
    {
        unset($this->bomRows[$key]);
    }
    
    public function save()
    {
        $this->validate([
            'bomCode' => 'required',
            'bomName' => 'required',
            'bomDescription' => 'required',
            'bomStatus' => 'required',
            'bomMaterialType' => 'required'
        ]);
        try {
            $data = Bom::create([
                'article_id' => $this->article_id,
                'bom_no' => $this->bomCode,
                'bom_name' => $this->bomName,
                'bom_date' => Carbon::now(),
                'description' => $this->bomDescription,
            ]);
            if($data) {
                foreach($this->bomRows as $row) {                    
                    BomDetail::create([
                        'bom_production_id' => $data->id,
                        'material' => $row['bomMaterial'],
                        'ingredient' => $row['bomIngredient'],
                        'quantity' => $row['bomQuantity'],
                        'unit' => $row['bomUnit'],
                        'level' => $row['bomLevel']
                    ]);                 
                } 
                $this->reset();
                $this->dispatch('success', 'BOM Detail successfully created');      
                $this->dispatch('bom-modal-close'); 
            }
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.bom.bom-production', [
            'data' => Marketing::where('validate', 'Approve')->orderBy('id', 'desc')->get(),
            'articles' => Article::when(isset($this->id), function($query) {
                            $query->where('marketing_id', $this->id);
                        })->get(),
            'materialTypes' => MaterialType::get(),
            'units' => Unit::get()
        ]);
    }
}
