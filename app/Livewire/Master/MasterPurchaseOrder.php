<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterPurchaseOrder as PurchaseOrder;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterPurchaseOrder extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $purchase_name, $purchase_code;

    public $purchase_name_, $purchase_code_;

    public function updateConfirm($id)
    {
        $data = PurchaseOrder::where('id', $id)->first();
        $this->id               = $id;
        $this->purchase_name_   = $data->purchase_name;
        $this->purchase_code_   = $data->purchase_code;
    }

    public function update()
    {
        $this->validate([
            'purchase_name_'   => 'required',
            'purchase_code_'   => 'required'
        ]);
        try {
            PurchaseOrder::where('id', $this->id)->update([
                'purchase_name' => $this->purchase_name_,
                'purchase_code' => $this->purchase_code_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Purchase Order) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'purchase_name' => 'required',
            'purchase_code' => 'required'
        ]);
        try {
            PurchaseOrder::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Purchase Order berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Purchase Order) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function deleteConfirm($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        try {
            PurchaseOrder::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Purchase Order berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Purchase Order) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-purchase-order', [
            'data' => PurchaseOrder::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
