<?php

namespace App\Livewire\Purchasing;

use App\Http\Controllers\GenerateNumberController as GenerateNumber;
use App\Models\Purchasing\PoSupplier as Po;
use App\Models\Marketing\Marketing;
use App\Models\Master\MasterSupplier;
use App\Models\Master\MasterCurrency;
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
     * Show PO Supplier
     */
    public $showPoSupplierId, $showPoSupplierNo, $showPoSupplierOp, $showPoSupplierDate;
    public $materialRequiredLists;
    public $materialDetails = [];

    /**
     * Supplier Details
     */
    public $supplierCode, $supplierName, $supplierState, $supplierAddress, $supplierEmail, $supplierPhone;
    public $supplierGrouping, $supplierPaymentTerm, $supplierShipmentTerm, $supplierCurrency, $supplierEta, $supplierPic;

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
    
    public function showPoSupplier($id)
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

    public function fillMaterialDescription($key)
    {
        $data = Po::find($this->showPoSupplierId);
        $this->materialDetails[$key]['materialName'] = $data->op->subTotals->where('material_code', $this->materialDetails[$key]['materialCode'])->first()->material_name;
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
                'supplier_pic'              => $this->supplierPic
            ]);
        } catch (\Exception $e) {
            Log::channel('purchasing')->error('(PO Supplier) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Theres an error, please contact admin!');
        }
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
