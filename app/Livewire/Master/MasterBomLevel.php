<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterBomLevel as Level;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterBomLevel extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $bom_level;

    public $bom_level_;

    public function updateConfirm($id)
    {
        $data = Level::where('id', $id)->first();
        $this->id       = $id;
        $this->bom_level_  = $data->bom_level;
    }

    public function update()
    {
        $this->validate([
            'bom_level_'   => 'required',
        ]);
        try {
            Level::where('id', $this->id)->update([
                'bom_level'    => $this->bom_level_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master BOM Level) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'bom_level'    => 'required',
        ]);
        try {
            Level::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data BOM Level berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master BOM Level) Theres an error : ' . $e->getMessage());
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
            Level::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data BOM Level berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master BOM Level) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-bom-level', [
            'data' => Level::orderBy('id', 'asc')->paginate(10)
        ]);
    }    
}
