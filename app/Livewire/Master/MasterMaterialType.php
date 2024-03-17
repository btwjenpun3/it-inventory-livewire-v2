<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterMaterialType as MaterialType;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterMaterialType extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $material_type;

    public $material_type_;

    public function updateConfirm($id)
    {
        $data = MaterialType::where('id', $id)->first();
        $this->id           = $id;
        $this->material_type_  = $data->material_type;
    }

    public function update()
    {
        $this->validate([
            'material_type_'   => 'required',
        ]);
        try {
            MaterialType::where('id', $this->id)->update([
                'material_type'    => $this->material_type_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'material_type'    => 'required',
        ]);
        try {
            MaterialType::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Material Type berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Material Type) Theres an error : ' . $e->getMessage());
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
            MaterialType::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Material Type berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Material Type) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-material-type', [
            'data' => MaterialType::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
