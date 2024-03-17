<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterAccount as Account;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterAccount extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $jenis_akun;

    public $jenis_akun_;

    public function updateConfirm($id)
    {
        $data = Account::where('id', $id)->first();
        $this->id = $id;
        $this->jenis_akun_ = $data->jenis_akun;
    }

    public function update()
    {
        $this->validate([
            'jenis_akun_' => 'required',
        ]);
        try {
            Account::where('id', $this->id)->update([
                'jenis_akun' => $this->jenis_akun_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Account) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $validate = $this->validate([
            'jenis_akun'    => 'required',
        ]);
        try {
            Account::create($validate);
            $this->reset();
            $this->dispatch('success', 'Master Data Account berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Account) Theres an error : ' . $e->getMessage());
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
            Account::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Account berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Account) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-account', [
            'data' => Account::orderBy('id', 'asc')->paginate(10)
        ]);
    }
}
