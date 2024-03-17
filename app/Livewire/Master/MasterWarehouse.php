<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterWarehouse as Warehouse;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterWarehouse extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $warehouse_code, $warehouse_name;

    public $warehouse_code_, $warehouse_name_;

    public function updateConfirm($id)
    {
        $data = Warehouse::where('id', $id)->first();
        $this->id  = $id;
        $this->warehouse_code_  = $data->warehouse_code;
        $this->warehouse_name_  = $data->warehouse_name;
    }

    public function update()
    {
        $this->validate([
            'warehouse_code_' => 'required',
            'warehouse_name_' => 'required'
        ]);
        try {
            Warehouse::where('id', $this->id)->update([
                'warehouse_code' => $this->warehouse_code_,
                'warehouse_name' => $this->warehouse_name_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Warehouse) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'warehouse_code' => 'required',
            'warehouse_name'  => 'required'
        ]);
        try {
            Warehouse::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Warehouse berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Warehouse) Theres an error : ' . $e->getMessage());
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
            Warehouse::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Warehouse berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Warehouse) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-warehouse', [
            'data' => Warehouse::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
