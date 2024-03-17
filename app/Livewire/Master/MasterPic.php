<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterPic as Pic;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterPic extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $name, $title, $email;

    public $name_, $title_, $email_;

    public function updateConfirm($id)
    {
        $data = Pic::where('id', $id)->first();
        $this->id     = $id;
        $this->name_  = $data->name;
        $this->title_ = $data->title;
        $this->email_ = $data->email;
    }

    public function update()
    {
        $this->validate([
            'name_' => 'required',
            'title_' => 'required',
            'email_' => 'required|email'
        ]);
        try {
            Pic::where('id', $this->id)->update([
                'name' => $this->name_,
                'title' => $this->title_,
                'email' => $this->email_
            ]);
            $this->dispatch('success', 'Success change PIC Data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master PIC) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'name' => 'required',
            'title' => 'required',
            'email' => 'required|email'
        ]);
        try {
            Pic::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data PIC Successfully Added');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master PIC) Theres an error : ' . $e->getMessage());
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
            Pic::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master PIC Successfully Deleted');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master PIC) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-pic', [
            'data' => Pic::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
