<?php

namespace App\Livewire\Bom;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Marketing\Article;
use App\Models\Master\MasterMaterial as Material;
use App\Models\Master\MasterMaterialType as MaterialType;
use App\Models\Master\MasterProcurement as Procurement;
use App\Models\Master\MasterSatuan as Unit;
use App\Models\Bom\BomProduction as Bom;
use App\Models\Bom\BomProductionDetail as BomDetail;
use App\Models\Marketing\Marketing;
use App\Models\Master\MasterBomLevel as BomLevel;
use App\Models\Master\MasterLocation as Location;
use App\Models\Bom\BomProductionDetail;

class BomProduction extends Component
{
    public $id, $order_production_no, $po_buyer_no, $pic_name, $buyer_code, $buyer_name;

    public $article_id, $article_no, $article_no_;

    public $bomId, $bomCode, $bomName, $bomDescription, $bomStatus, $bomMaterialType, $bomArticleQuantity, $bomArticleUnit, $bomNote;
    public $bomRows = [];

    /**
     * Public Property for Edit
     */
    public $articleId;
    public $bomId_, $bomCode_, $bomName_, $bomDescription_, $bomStatus_, $bomMaterialType_;
    public $bomDetailId_, $bomDetailMaterialType_, $bomIngredient_, $bomMaterialDescription_, $bomConsumption_, $bomTotalQuantity_, $bomUnit_, $bomLocation_, $bomLevel_;
    public $bomProcurement_, $bomNote_;
    public $bomRows_ = [];
    public $bomDetails;

    public function mount()
    {
        $this->bomRows[] = [];
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

    public function addRow()
    {
        $this->bomRows[] = [];
    }    

    public function removeRow($key)
    {
        unset($this->bomRows[$key]);
    }

    public function fillIngredientDescription($key, $value, $edit)
    {
        $data = Material::where('id', $value)->first();
        if($edit === 'false') {            
            $this->bomRows[$key]['bomMaterialDescription'] = $data->description; 
        } else {
            $this->bomMaterialDescription_[$key] = $data->description;
        }          
    }

    public function fillTotalQuantity($key, $value, $edit)
    {
        $value === '' ? $getValue = 0 : $getValue = $value;
        if($edit === 'false') {
            $this->bomRows[$key]['bomQuantity'] = $getValue * $this->bomArticleQuantity;
        } else {
            $this->bomTotalQuantity_[$key] = $getValue * $this->bomArticleQuantity;
        }    
        
    }

    public function showBom($id)
    {
        if(!isset($this->bomRows)) {
            $this->mount();
        }      
        $data = Article::where('id', $id)->first();
        $this->article_id           = $id;
        $this->article_no           = $data->article->article_name;    
        $this->bomArticleQuantity   = $data->quantity; 
        $this->bomArticleUnit       = $data->unit->satuan;
        $year = Carbon::now()->year;
        $getLastNumber = Bom::where('bom_no', 'LIKE', '%/BOM/' . $year)->latest()->first();     
        if(isset($getLastNumber)) {
            $lastNumber = (int) explode('/', $getLastNumber->bom_no)[0];
            $prefix = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $prefix = '00001';
        }   
        $this->bomCode = $prefix . '/BOM/' . $year;  
    }
    public function showBomDetail($id)
    {
        $data = Article::with('bom')->where('id', $id)->first();  
        $this->articleId            = $id;    
        $this->article_no_          = $data->article->article_code;
        $this->bomId_               = $data->bom->id;
        $this->bomCode_             = $data->bom->bom_no;
        $this->bomName_             = $data->bom->bom_name;
        $this->bomDescription_      = $data->bom->description;
        $this->bomStatus_           = $data->bom->status;
        $this->bomMaterialType_     = $data->bom->material->material_type;
        $this->bomArticleQuantity   = $data->quantity;
        $this->bomArticleUnit       = $data->unit->satuan;
        $this->bomDetails           = $data->bom->details;
        foreach($data->bom->details as $d) {
            $this->bomDetailId_[$d->id]             = $d->id;
            $this->bomDetailMaterialType_[$d->id]   = $d->material_type;
            $this->bomIngredient_[$d->id]           = $d->material->id;
            $this->bomMaterialDescription_[$d->id]  = $d->material->description;
            $this->bomConsumption_[$d->id]          = $d->consumption;
            $this->bomTotalQuantity_[$d->id]        = $d->total_quantity; 
            $this->bomUnit_[$d->id]                 = $d->unit->id; 
            $this->bomLocation_[$d->id]             = $d->location->id;
            $this->bomLevel_[$d->id]                = $d->level->id;
            $this->bomProcurement_[$d->id]          = $d->procurement->id;
            $this->bomNote_[$d->id]                 = $d->note;
        }   
    }

    public function saveUpdate($id)
    {
        try {
            BomDetail::where('id', $id)->update([
                'material_type'     => $this->bomDetailMaterialType_[$id],
                'material_id'       => $this->bomIngredient_[$id],
                'consumption'       => $this->bomConsumption_[$id],
                'total_quantity'    => $this->bomTotalQuantity_[$id],
                'satuan_id'         => $this->bomUnit_[$id],
                'location_id'       => $this->bomLocation_[$id],
                'level_id'          => $this->bomLevel_[$id],
                'procurement_id'    => $this->bomProcurement_[$id],
                'note'              => $this->bomNote_[$id]
            ]);
            $this->dispatch('success', 'BOM Detail successfully updated'); 
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }        
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
                'material_type_id' => $this->bomMaterialType,
                'status' => $this->bomStatus
            ]);
            if($data) {
                foreach($this->bomRows as $row) {                    
                    BomDetail::create([
                        'bom_production_id' => $data->id,
                        'material_type' => $row['bomMaterial'],
                        'material_id' => $row['bomIngredient'],
                        'consumption' => $row['bomConsumption'],
                        'total_quantity' => $row['bomQuantity'],
                        'satuan_id' => $row['bomUnit'],
                        'location_id' => $row['bomLocation'],
                        'level_id' => $row['bomLevel'],
                        'procurement_id' => $row['bomProcurement'],
                        'note' => $row['bomNote']
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

    public function deleteUpdate($id)
    {
        BomDetail::where('id', $id)->delete();
        $this->dispatch('success', 'BOM Detail successfully deleted'); 
        $this->showBomDetail($this->articleId);
    }

    public function render()
    {
        return view('livewire.bom.bom-production', [
            'data' => Marketing::where('validate', 'Approve')->orderBy('id', 'desc')->get(),
            'articles' => Article::when(isset($this->id), function($query) {
                            $query->where('marketing_id', $this->id);
                        })->get(),  
            'materials' => Material::get(),
            'materialTypes' => MaterialType::get(),
            'procurements' => Procurement::get(),
            'locations' => Location::get(),
            'units' => Unit::get(),
            'levels' => BomLevel::get()
        ]);
    }
}
