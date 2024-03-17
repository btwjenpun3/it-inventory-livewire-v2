<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterLocation as Location;
use App\Models\Master\MasterRak as Rak;
use App\Models\Master\MasterWarehouse as Warehouse;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterLocation extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $location_code, $location_name, $warehouse_id, $rak_id;

    public $location_code_, $location_name_, $warehouse_id_, $rak_id_;

    public function updateConfirm($id)
    {
        $data = Location::where('id', $id)->first();
        $this->id               = $id;
        $this->location_code_   = $data->location_code;
        $this->location_name_   = $data->location_name;
        $this->warehouse_id_    = $data->warehouse_id;
        $this->rak_id_          = $data->rak_id;
    }

    public function update()
    {
        $this->validate([
            'location_code_' => 'required',
            'location_name_' => 'required',
            'warehouse_id_' => 'required',
            'rak_id_' => 'required'
        ]);
        try {
            Location::where('id', $this->id)->update([
                'location_code' => $this->location_code_,
                'location_name' => $this->location_name_,
                'warehouse_id' => $this->warehouse_id_,
                'rak_id' => $this->rak_id_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Location) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'location_code' => 'required',
            'location_name'  => 'required',
            'warehouse_id' => 'required',
            'rak_id' => 'required'
        ]);
        try {
            Location::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Location berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Location) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-location', [
            'data' => Location::orderBy('id', 'asc')->paginate(10),
            'rak' => Rak::get(),
            'warehouse' => Warehouse::get()
        ]);
    }
}
