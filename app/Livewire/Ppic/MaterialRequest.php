<?php

namespace App\Livewire\Ppic;

use App\Models\Bom\BomProduction;
use App\Models\Bom\BomProductionDetail;
use App\Models\Bom\BomProductionDetailSubtotal as Subtotal;
use App\Models\Marketing\Marketing;
use App\Models\Ppic\BomMaterialRequest as Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use Illuminate\Support\Facades\Log;

class MaterialRequest extends Component
{
    use WithPagination, WithoutUrlPagination; 

    public $articleNo;

    /**
     * BOM Order Production (marketings)
     */
    public $id;
    public $orderProductionNo, $orderProductionDate;

    /**
     * BOM Production 
     */
    public $bomNo = [];

    /**
     * BOM Production Details
     */
    public $bomNote;
    public $materialGroup = [];
    public $totalMaterial = [];

    /**
      * Data Dummy
      */
    public $stock;

    public function show($id)
    {
        $data = Marketing::with('articles')->where('id', $id)->first();
        $this->id = $id;  
        $this->orderProductionNo = $data->order_production_no;  
        $this->orderProductionDate = $data->order_production_date; 
        $getBom = $data->articles()->get();
        foreach($getBom as $bom) {
            $this->bomNo[] = $bom->bom;                            
        } 
        foreach($this->bomNo as $total) {
            $groupedDetails = $total->details->groupBy(['material_code']);            
            foreach ($groupedDetails as $materialCode => $details) {
                $totalQuantity = $details->sum('total_quantity');          
                $this->materialGroup[] = [
                    'material_code' => $materialCode,
                    'material_description' => $details[0]->material_description,
                    'material_unit' => $details[0]->material_unit,
                    'material_size' => $details[0]->material_size,
                    'stock' => 2000,
                    'total_quantity' => $totalQuantity,
                ];
            }
        }
        $data = $this->materialGroup;   
        $totalMaterial = [];
        foreach ($data as $item) {
            $materialCode = $item["material_code"];
            $quantity = $item["total_quantity"];
            $materialDescription = $item["material_description"];
            $materialUnit = $item["material_unit"];
            $materialStock = $item["stock"];
            $materialSize = $item['material_size'];
        
            if (!isset($totalMaterial[$materialCode][$materialSize])) {
                $totalMaterial[$materialCode] = [
                    'material_code' => $materialCode,
                    "total_quantity" => $quantity,
                    "material_description" => $materialDescription,
                    "unit" => $materialUnit,
                    'stock' => $materialStock,
                    'size' => $materialSize
                ];
            } else {
                $totalMaterial[$materialCode]["total_quantity"] += $quantity;
            }
        }
        $this->totalMaterial = $totalMaterial;   
    }

    public function save()
    {
        try {
            foreach($this->totalMaterial as $material) {
                Subtotal::create([
                    'marketing_id' => $this->id,
                    'material_code' => $material['material_code'],
                    'material_name' => $material['material_description'],
                    'material_unit' => $material['unit'],
                    'subtotal' => $material['total_quantity'],
                    'material_requested' => $material['material_requested']
                ]);
            }     
            $this->dispatch('success', 'Material Request Successfully Created');
            $this->dispatch('show-modal-close');           
        } catch (\Exception $e) {
            Log::channel('material_request')->error('(Master Account) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Theres an error. Please contact Admin');
        }
    }

    public function render()
    {
        $data = Marketing::orderby('id', 'desc')->get();
        return view('livewire.ppic.material-request', [
            'data' => $data,
            'details' => BomProduction::when(isset($this->id), function($query) {
                            $query->where('id', $this->id);
                        })->first()           
        ]);
    }
}
