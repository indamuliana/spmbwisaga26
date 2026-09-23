<?php

namespace App\Livewire\Admin;

use App\Models\Jurusan;
use Livewire\Component;

class ManajemenJurusan extends Component
{
    public $jurusans;
    public $jurusan_id;
    public $kode_jurusan;
    public $nama_jurusan;
    public $is_active = true;
    public $isModalOpen = false;

    public function render()
    {
        $this->jurusans = Jurusan::latest()->get();
        return view('livewire.admin.manajemen-jurusan');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->jurusan_id = '';
        $this->kode_jurusan = '';
        $this->nama_jurusan = '';
        $this->is_active = true;
    }

    public function store()
    {
        $this->validate([
            'kode_jurusan' => 'required|max:50|unique:jurusan,kode_jurusan,' . $this->jurusan_id,
            'nama_jurusan' => 'required|max:255',
            'is_active' => 'boolean',
        ]);

        Jurusan::updateOrCreate(['id' => $this->jurusan_id], [
            'kode_jurusan' => $this->kode_jurusan,
            'nama_jurusan' => $this->nama_jurusan,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->jurusan_id ? 'Jurusan berhasil diperbarui.' : 'Jurusan berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $this->jurusan_id = $id;
        $this->kode_jurusan = $jurusan->kode_jurusan;
        $this->nama_jurusan = $jurusan->nama_jurusan;
        $this->is_active = $jurusan->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        Jurusan::find($id)->delete();
        session()->flash('message', 'Jurusan berhasil dihapus.');
    }
}
