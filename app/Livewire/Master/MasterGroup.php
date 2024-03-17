<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterGroup as Group;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterGroup extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $group;

    public $group_;

    public function updateConfirm($id)
    {
        $data = Group::where('id', $id)->first();
        $this->id     = $id;
        $this->group_  = $data->group;
    }

    public function update()
    {
        $this->validate([
            'group_'   => 'required',
        ]);
        try {
            Group::where('id', $this->id)->update([
                'group'    => $this->group_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Group) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'group'    => 'required',
        ]);
        try {
            Group::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Group berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Group) Theres an error : ' . $e->getMessage());
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
            Group::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Group berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Group) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-group', [
            'data' => Group::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
