<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterRak as Rak;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterRak extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    public $id, $rak_code, $rak_name;

    public $rak_code_, $rak_name_;

    public function updateConfirm($id)
    {
        $data = Rak::where('id', $id)->first();
        $this->id  = $id;
        $this->rak_code_  = $data->rak_code;
        $this->rak_name_  = $data->rak_name;
    }

    public function update()
    {
        $this->validate([
            'rak_code_' => 'required',
            'rak_name_' => 'required'
        ]);
        try {
            Rak::where('id', $this->id)->update([
                'rak_code' => $this->rak_code_,
                'rak_name' => $this->rak_name_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Rak) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'rak_code' => 'required',
            'rak_name'  => 'required'
        ]);
        try {
            Rak::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Rak berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Rak) Theres an error : ' . $e->getMessage());
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
            Rak::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Rak berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Rak) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-rak', [
            'data' => Rak::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
