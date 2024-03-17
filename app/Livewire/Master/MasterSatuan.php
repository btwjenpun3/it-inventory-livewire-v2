<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterSatuan as Satuan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterSatuan extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $satuan, $description;

    public $satuan_, $description_;

    public function updateConfirm($id)
    {
        $data = Satuan::where('id', $id)->first();
        $this->id       = $id;
        $this->satuan_  = $data->satuan;
        $this->description_ = $data->description;
    }

    public function update()
    {
        $this->validate([
            'satuan_'   => 'required',
            'description_' => 'required'
        ]);
        try {
            Satuan::where('id', $this->id)->update([
                'satuan'    => $this->satuan_,
                'description' => $this->description_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Satuan) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'satuan'    => 'required',
            'description' => 'required'
        ]);
        try {
            Satuan::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Satuan berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Satuan) Theres an error : ' . $e->getMessage());
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
            Satuan::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Satuan berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Satuan) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-satuan', [
            'data' => Satuan::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
