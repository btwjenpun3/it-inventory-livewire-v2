<?php

namespace App\Livewire\Master;

use App\Models\Master\MasterArticle as Article;
use App\Models\Master\MasterBuyer as Buyer;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterArticle extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $articleCode, $articleName, $description, $buyerCode;

    public $articleCode_, $articleName_, $description_, $buyerCode_;

    public function updateConfirm($id)
    {
        $data = Article::where('id', $id)->first();
        $this->id            = $id;
        $this->articleCode_  = $data->article_code;
        $this->articleName_  = $data->article_name;
        $this->description_  = $data->description;
        $this->buyerCode_    = $data->buyer_id;
    }

    public function update()
    {
        $this->validate([
            'articleCode_'   => 'required',
            'articleName_'   => 'required',
            'description_'   => 'required',
            'buyerCode_'     => 'required'
        ]);
        try {
            Article::where('id', $this->id)->update([
                'article_code'    => $this->articleCode_,
                'article_name'    => $this->articleName_,
                'description'     => $this->description_,
                'buyer_id'        => $this->buyerCode_,
            ]);
            $this->dispatch('success', 'Berhasil merubah data');
            $this->dispatch('update-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Article) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function save()
    {
        $this->validate([
            'articleCode'    => 'required',
            'articleName'    => 'required',
            'description'    => 'required',
            'buyerCode'      => 'required',
        ]);
        try {
            Article::create([
                'article_code' => $this->articleCode,
                'article_name' => $this->articleName,
                'description' => $this->description,
                'buyer_id' => $this->buyerCode
            ]);
            $this->reset();
            $this->dispatch('success', 'Master Data Article berhasil di Tambah');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Article) Theres an error : ' . $e->getMessage());
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
            Article::where('id', $this->id)->delete();
            $this->dispatch('success', 'Master Data Article berhasil di Hapus');
            $this->dispatch('delete-modal-close');
        } catch (\Exception $e) {
            Log::channel('master')->error('(Master Article) Theres an error : ' . $e->getMessage());
            $this->dispatch('error', 'Terdapat masalah, harap hubungi Admin!');
        }
    }

    public function render()
    {
        return view('livewire.master.master-article', [
            'data' => Article::orderBy('id', 'asc')->paginate(10),
            'buyers' => Buyer::get()
        ]);
    }
}
