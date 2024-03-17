<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterCurrency as Currency;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MasterCurrency extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $currency_code, $currency_name;

    public $currency_code_, $currency_name_;

    public function import()
    {
        $response = Http::get('https://v6.exchangerate-api.com/v6/' . env('EXCHANGERATE_API_KEY') . '/codes');
        foreach ($response['supported_codes'] as $response) {
            Currency::create([
                'currency_code' => $response[0],
                'currency_name' => $response[1]
            ]);
        }
        $this->dispatch('success', 'Currencies Import success');
        $this->dispatch('import-modal-close');
    }

    public function updateConfirm($id)
    {
        $data = Currency::where('id', $id)->first();
        $this->id               = $id;
        $this->currency_code_   = $data->currency_code;
        $this->currency_name_   = $data->currency_name;    }

    public function update()
    {
        $this->validate([
            'currency_code_' => 'required',
            'currency_name_' => 'required',
        ]);
        try {
            Currency::where('id', $this->id)->update([
                'currency_code' => $this->currency_code_,
                'currency_name' => $this->currency_name_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Currency) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'currency_code' => 'required',
            'currency_name' => 'required'
        ]);
        try {
            Currency::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Currency berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Currency) Theres an error : ' . $e->getMessage());
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
            Currency::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Currency berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Currency) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-currency', [
            'data' => Currency::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
