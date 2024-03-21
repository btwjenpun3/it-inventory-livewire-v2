<?php

namespace App\Livewire\Ppic;

use App\Models\Bom\BomProduction;
use App\Models\Bom\BomProductionDetail;
use App\Models\Ppic\BomMaterialRequest as Request;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MaterialRequest extends Component
{
    use WithPagination, WithoutUrlPagination; 

    public $id;

    public $articleNo;

    /**
     * BOM Production
     */
    public $bomId, $bomCode, $bomName, $bomDescription, $bomStatus, $bomMaterialType, $bomArticleQuantity, $bomArticleUnit;

    /**
     * BOM Production Details
     */
    public $bomNote;
    public $quantityToStock = [];

    /**
      * Data Dummy
      */
    public $stock;

    public function show($id)
    {
        $this->reset('quantityToStock');
        $data = BomProduction::where('id', $id)->first();
        $this->id = $id;
        $this->bomCode = $data->bom_no;
        $this->bomName = $data->bom_name;
        $this->bomDescription = $data->description;
        $this->bomStatus = $data->status;
        $this->bomMaterialType = $data->materialType->material_type;
        $this->bomArticleQuantity = $data->article->quantity;
        $this->bomArticleUnit = $data->article->unit->satuan;
        $this->stock = 15000;        
    }

    public function save()
    {
        try {
            foreach($this->quantityToStock as $key => $q) {
                BomProductionDetail::where('id', $key)->update([
                    'quantity_request' => $q,
                    'status' => 1
                ]);                
            }
            $this->reset('quantityToStock');
            $this->dispatch('success', 'Berhasil');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }

    public function render()
    {
        $data = BomProduction::orderby('id', 'desc')->get();
        return view('livewire.ppic.material-request', [
            'data' => $data,
            'details' => BomProduction::when(isset($this->id), function($query) {
                            $query->where('id', $this->id);
                        })->first()
        ]);
    }
}
