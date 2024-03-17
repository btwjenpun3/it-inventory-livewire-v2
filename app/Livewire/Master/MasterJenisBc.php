<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterJenisBc as JenisBc;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterJenisBc extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $jenis_bc, $keterangan;

    public $jenis_bc_, $keterangan_;

    public function updateConfirm($id)
    {
        $data = JenisBc::where('id', $id)->first();
        $this->id           = $id;
        $this->jenis_bc_    = $data->jenis_bc;
        $this->keterangan_  = $data->keterangan;
    }

    public function update()
    {
        $this->validate([
            'jenis_bc_'    => 'required',
            'keterangan_'  => 'required'
        ]);
        try {
            JenisBc::where('id', $this->id)->update([
                'jenis_bc'    => $this->jenis_bc_,
                'keterangan'  => $this->keterangan_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Jenis BC) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'jenis_bc'    => 'required',
            'keterangan'  => 'required'
        ]);
        try {
            JenisBc::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Jenis BC berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Jenis BC) Theres an error : ' . $e->getMessage());
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
            JenisBc::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Jenis BC Type berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Jenis BC) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-jenis-bc', [
            'data' => JenisBc::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
