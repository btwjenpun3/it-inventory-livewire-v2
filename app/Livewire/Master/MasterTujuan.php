<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterTujuan as Tujuan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterTujuan extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $jenis_tujuan;

    public $jenis_tujuan_;

    public function updateConfirm($id)
    {
        $data = Tujuan::where('id', $id)->first();
        $this->id               = $id;
        $this->jenis_tujuan_   = $data->jenis_tujuan;
    }

    public function update()
    {
        $this->validate([
            'jenis_tujuan_' => 'required',
        ]);
        try {
            Tujuan::where('id', $this->id)->update([
                'jenis_tujuan' => $this->jenis_tujuan_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Jenis Tujuan) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'jenis_tujuan' => 'required',
        ]);
        try {
            Tujuan::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Tujuan berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Tujuan) Theres an error : ' . $e->getMessage());
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
            Tujuan::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Tujuan berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Tujuan) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-tujuan', [
            'data' => Tujuan::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
