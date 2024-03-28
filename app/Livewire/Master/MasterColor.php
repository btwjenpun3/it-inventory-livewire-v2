<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterColor as Color;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterColor extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $color;

    public $color_;

    public function updateConfirm($id)
    {
        $data = Color::where('id', $id)->first();
        $this->id       = $id;
        $this->color_  = $data->color;
    }

    public function update()
    {
        $this->validate([
            'color_'   => 'required',
        ]);
        try {
            Color::where('id', $this->id)->update([
                'color'    => $this->color_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Color) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'color'    => 'required',
        ]);
        try {
            Color::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Color berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Color) Theres an error : ' . $e->getMessage());
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
            Color::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Color berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Color) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-color', [
            'data' => Color::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
