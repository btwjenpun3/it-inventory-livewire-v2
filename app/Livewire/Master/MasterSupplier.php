<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterSupplier as Supplier;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterSupplier extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $supplier_code, $supplier_name, $state, $email, $phone, $address;

    public $supplier_code_, $supplier_name_, $state_, $email_, $phone_, $address_;

    public function updateConfirm($id)
    {
        $data = Supplier::where('id', $id)->first();
        $this->id               = $id;
        $this->supplier_code_   = $data->supplier_code;
        $this->supplier_name_   = $data->supplier_name;
        $this->state_           = $data->state;
        $this->email_           = $data->email;
        $this->phone_           = $data->phone;
        $this->address_         = $data->address;
    }

    public function update()
    {
        $this->validate([
            'supplier_code_' => 'required',
            'supplier_name_' => 'required',
            'state_' => 'required',
            'email_' => 'required|email',
            'phone_' => 'required',
            'address_' => 'required'
        ]);
        try {
            Supplier::where('id', $this->id)->update([
                'supplier_code' => $this->supplier_code_,
                'supplier_name' => $this->supplier_name_,
                'state' => $this->state_,
                'email' => $this->email_,
                'phone' => $this->phone_,
                'address' => $this->address_,
            ]);
            $this->dispatch('success', 'Data Successfully Changed');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'supplier_code' => 'required',
            'supplier_name' => 'required',
            'state' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required'
        ]);
        try {
            Supplier::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Supplier Successfully Added');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());
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
            Supplier::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Supplier Successfully Deleted');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Supplier) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-supplier', [
            'data' => Supplier::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
