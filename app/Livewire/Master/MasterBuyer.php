<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterBuyer as Buyer;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterBuyer extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $code_buyer, $buyer_name, $state, $email, $phone;

    public $code_buyer_, $buyer_name_, $state_, $email_, $phone_;

    public function updateConfirm($id)
    {
        $data = Buyer::where('id', $id)->first();
        $this->id           = $id;
        $this->code_buyer_  = $data->code_buyer;
        $this->buyer_name_   = $data->buyer_name;
        $this->state_        = $data->state;
        $this->email_        = $data->email;
        $this->phone_        = $data->phone;
    }

    public function update()
    {
        $this->validate([
            'code_buyer_'   => 'required',
            'buyer_name_'   => 'required',
            'state_'        => 'required',
            'email_'        => 'nullable|email',
            'phone_'        => 'nullable'
        ]);
        try {
            Buyer::where('id', $this->id)->update([
                'code_buyer'    => $this->code_buyer_,
                'buyer_name'    => $this->buyer_name_,
                'state'         => $this->state_,
                'email'         => $this->email_,
                'phone'         => $this->phone_
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'code_buyer'    => 'required',
            'buyer_name'    => 'required',
            'state'         => 'required',
            'email'         => 'email|nullable',
            'phone'         => 'nullable'
        ]);
        try {
            Buyer::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Buyer berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());
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
            Buyer::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Buyer berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Buyer) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-buyer', [
            'data' => Buyer::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
