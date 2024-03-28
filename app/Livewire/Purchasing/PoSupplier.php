<?php

namespace App\Livewire\Purchasing;

use App\Http\Controllers\GenerateNumberController as GenerateNumber;
use App\Models\Purchasing\PoSupplier as Po;
use App\Models\Marketing\Marketing;
use App\Models\Master\MasterSupplier;
use App\Models\Master\MasterCurrency;
use App\Models\Purchasing\PoSupplierDetail;
use App\Models\Bom\BomProductionDetailSubtotal as Subtotal;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class PoSupplier extends Component
{
    use WithPagination, WithoutUrlPagination; 

    /**
     * Create PO Supplier
     */
    #[Validate('required')] 
    public $opNo, $poSupplierNo, $poSupplierDate, $poSupplierGrouping;   

    /**
     * Show Create PO Supplier
     */
    public $showPoSupplierId, $showPoSupplierNo, $showPoSupplierOp, $showPoSupplierDate;
    public $materialRequiredLists;
    public $materialDetails = [];

    /**
     * Supplier Details
     */
    public $supplierCode, $supplierName, $supplierState, $supplierAddress, $supplierEmail, $supplierPhone;
    public $supplierGrouping, $supplierPaymentTerm, $supplierShipmentTerm, $supplierCurrency, $supplierEta, $supplierPic;

    /**
     * Show PO Supplier
     */
    public $showPoSupplierId_, $showPoSupplierNo_, $showPoSupplierOp_, $showPoSupplierDate_;
    public $supplierCode_, $supplierName_, $supplierState_, $supplierAddress_, $supplierEmail_, $supplierPhone_;
    public $supplierGrouping_, $supplierPaymentTerm_, $supplierShipmentTerm_, $supplierCurrency_, $supplierEta_, $supplierPic_;
    public $materialRequiredLists_;
    public $materialDetails_;

    public function mount($number)
    {        
        $this->poSupplierNo = $number;
    }

    public function savePoSupplier()
    {
        $this->validate();
        try {
            Po::create([
                'marketing_id'  => $this->opNo,
                'po_no'         => $this->poSupplierNo,
                'po_date'       => $this->poSupplierDate,
                'grouping'      => $this->poSupplierGrouping
            ]);            
            $this->dispatch('success', 'PO Supplier successfully created');
            $this->dispatch('create-modal-close');
            $this->reset();
            $this->generateNumber();
        } catch (\Exception $e) { 
            Log::channel('purchasing')->error('(PO Supplier) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Theres an error, please contact admin!');
        }
    }
    
    public function generateNumber()
    {
        $call = new GenerateNumber;
        $this->poSupplierNo = $call->generateNumber('po-supplier');
    }

    public function addMaterialRow()
    {
        $this->materialDetails[] = array(
            'materialCode' => null,
            'materialName' => null,
            'materialQuantityPurchase' => null
        );
    }

    public function removeMaterialRow($key) 
    {
        unset($this->materialDetails[$key]);
    }
    
    public function showCreatePoSupplier($id)
    {
        $this->reset('materialDetails');
        $this->addMaterialRow();
        $data = Po::find($id);
        $this->showPoSupplierId         = $id;
        $this->showPoSupplierNo         = $data->po_no;
        $this->showPoSupplierOp         = $data->op->order_production_no;
        $this->showPoSupplierDate       = $data->po_date;
        $this->materialRequiredLists    = $data->op->subTotals;        
    }

    public function fillMaterialDescriptionAndUom($key)
    {
        $data = Po::find($this->showPoSupplierId);
        $this->materialDetails[$key]['materialDescription'] = $data->op->subTotals->where('material_code', $this->materialDetails[$key]['materialCode'])->first()->material_name;
        $this->materialDetails[$key]['materialUom'] = $data->op->subTotals->where('material_code', $this->materialDetails[$key]['materialCode'])->first()->material_unit;
        $this->materialDetails[$key]['materialStock'] = 2000;
    }

    public function fillSupplierContent()
    {
        $data = MasterSupplier::where('supplier_code', $this->supplierCode)->first();
        $this->supplierName     = $data->supplier_name;
        $this->supplierState    = $data->state;
        $this->supplierAddress  = $data->address;
        $this->supplierEmail    = $data->email;
        $this->supplierPhone    = $data->phone;
    }    

    public function savePoSupplierDetails()
    {                
        $this->validate([
            'supplierCode'          => 'required',
            'supplierGrouping'      => 'required',
            'supplierPaymentTerm'   => 'required',
            'supplierShipmentTerm'  => 'required',
            'supplierCurrency'      => 'required',
            'supplierEta'           => 'required',
            'supplierPic'           => 'required',
        ]);   
        $this->validate([
            'materialDetails.*.materialCode' => 'required',
            'materialDetails.*.materialQuantityPurchase' => 'required',
            'materialDetails.*.materialUom' => 'required',
        ]);     
        try {
            $create = Po::where('id', $this->showPoSupplierId)->update([
                'supplier_code'             => $this->supplierCode,
                'supplier_name'             => $this->supplierName,
                'supplier_state'            => $this->supplierState,
                'supplier_address'          => $this->supplierAddress,
                'supplier_email'            => $this->supplierEmail,
                'supplier_phone'            => $this->supplierPhone,
                'supplier_grouping'         => $this->supplierGrouping,
                'supplier_payment_term'     => $this->supplierPaymentTerm,
                'supplier_shipment_term'    => $this->supplierShipmentTerm,
                'supplier_currency'         => $this->supplierCurrency,
                'supplier_eta'              => $this->supplierEta,
                'supplier_pic'              => $this->supplierPic,
                'status'                    => 'Completed'
            ]);
            if($create) {
                foreach($this->materialDetails as $material) {
                    PoSupplierDetail::create([
                        'po_supplier_id'        => $this->showPoSupplierId,
                        'material_code'         => $material['materialCode'],
                        'material_description'  => $material['materialDescription'],
                        'stock'                 => $material['materialStock'],
                        'purchase_quantity'     => $material['materialQuantityPurchase'],
                        'material_unit'         => $material['materialUom']
                    ]);
                    $data = Po::find($this->showPoSupplierId);
                    $result = $data->op->subTotals->where('material_code', $material['materialCode'])->first();
                    $result->update(['material_purchased' => $result->material_purchased + $material['materialQuantityPurchase']]);
                }
                $this->dispatch('success', 'PO Supplier successfully created');
            }
        } catch (\Exception $e) {
            Log::channel('purchasing')->error('(PO Supplier) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Theres an error, please contact admin!');
        }
    }

    public function showPoSupplier($id)
    {        
        $data = Po::find($id);
        $this->showPoSupplierId_         = $id;
        $this->showPoSupplierNo_         = $data->po_no;
        $this->showPoSupplierOp_         = $data->op->order_production_no;
        $this->showPoSupplierDate_       = $data->po_date;
        $this->supplierCode_             = $data->supplier_code;
        $this->supplierName_             = $data->supplier_name;
        $this->supplierState_            = $data->supplier_state;
        $this->supplierAddress_          = $data->supplier_address;
        $this->supplierEmail_            = $data->supplier_email;
        $this->supplierPhone_            = $data->supplier_phone;
        $this->supplierGrouping_         = $data->supplier_grouping;
        $this->supplierPaymentTerm_      = $data->supplier_payment_term;
        $this->supplierShipmentTerm_     = $data->supplier_shipment_term;
        $this->supplierCurrency_         = $data->supplier_currency;
        $this->supplierEta_              = $data->supplier_eta;
        $this->supplierPic_              = $data->supplier_pic;
        $this->materialRequiredLists_    = $data->op->subTotals;   
        $this->materialDetails_          = $data->poSupplierDetails;     
    }

    public function render()
    {
        return view('livewire.purchasing.po-supplier', [
            'data' => Po::orderby('id', 'desc')->paginate(10),
            'opNoLists' => Marketing::where('validate', 'Approve')->get(),
            'suppliers' => MasterSupplier::get(),
            'currencies' => MasterCurrency::get()
        ]);
    }
}
