<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterMaterial as Material;
use App\Models\Master\MasterMaterialType as MaterialType;
use App\Models\Master\MasterSatuan as Satuan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterMaterial extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $material_code, $description, $material_type_id, $satuan_id;

    public $material_code_, $description_, $material_type_id_, $satuan_id_;

    public function updateConfirm($id)
    {
        $data = Material::where('id', $id)->first();
        $this->id                   = $id;
        $this->material_code_       = $data->material_code;
        $this->description_         = $data->description;
        $this->material_type_id_    = $data->material_type_id;
        $this->satuan_id_           = $data->satuan_id;
    }

    public function update()
    {
        $this->validate([
            'material_code_'    => 'required',
            'description_'      => 'required',
            'material_type_id_' => 'required',
            'satuan_id_'        => 'nullable'
        ]);
        try {
            Material::where('id', $this->id)->update([
                'material_code'     => $this->material_code_,
                'description'       => $this->description_,
                'material_type_id'  => $this->material_type_id_,
                'satuan_id'         => $this->satuan_id_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Material) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'material_code'     => 'required|unique:master_materials,material_code',
            'description'       => 'required',
            'material_type_id'  => 'required',
            'satuan_id'         => 'required',
        ]);
        try {
            Material::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Material berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Material) Theres an error : ' . $e->getMessage());
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
            Material::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Material berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Material) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-material', [
            'data' => Material::orderBy('id', 'asc')->paginate(10),
            'material' => MaterialType::get(),
            'satuan' => Satuan::get()
        ]);
    }
}
