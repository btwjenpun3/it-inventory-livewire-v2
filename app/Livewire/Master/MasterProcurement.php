<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterProcurement as Procurement;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterProcurement extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $procurement;

    public $procurement_;

    public function updateConfirm($id)
    {
        $data = Procurement::where('id', $id)->first();
        $this->id       = $id;
        $this->procurement_  = $data->procurement;
    }

    public function update()
    {
        $this->validate([
            'procurement_'   => 'required',
        ]);
        try {
            Procurement::where('id', $this->id)->update([
                'procurement'    => $this->procurement_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Procurement) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'procurement'    => 'required',
        ]);
        try {
            Procurement::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Procurement berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Procurement) Theres an error : ' . $e->getMessage());
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
            Procurement::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Procurement berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Procurement) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-procurement', [
            'data' => Procurement::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
