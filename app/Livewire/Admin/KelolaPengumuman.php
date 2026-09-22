<?php

namespace App\Livewire\Admin;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class KelolaPengumuman extends Component
{
    use WithFileUploads;

    public $pengumumans;
    public $pengumuman_id;
    public $judul;
    public $konten;
    public $gambar;
    public $is_aktif = true;
    public $isModalOpen = false;

    public function render()
    {
        $this->pengumumans = Pengumuman::latest()->get();
        return view('livewire.admin.kelola-pengumuman');
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
        $this->pengumuman_id = '';
        $this->judul = '';
        $this->konten = '';
        $this->gambar = '';
        $this->is_aktif = true;
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'konten' => 'nullable',
            'gambar' => 'nullable|image|max:2048', // max 2MB
        ]);

        $imagePath = null;
        if ($this->pengumuman_id) {
            $pengumuman = Pengumuman::find($this->pengumuman_id);
            $imagePath = $pengumuman->gambar;
        }

        if ($this->gambar && !is_string($this->gambar)) {
            $imagePath = $this->gambar->store('pengumuman', 'public');
        }

        Pengumuman::updateOrCreate(['id' => $this->pengumuman_id], [
            'judul' => $this->judul,
            'konten' => $this->konten,
            'gambar' => $imagePath,
            'is_aktif' => $this->is_aktif,
        ]);

        session()->flash('message', $this->pengumuman_id ? 'Pengumuman berhasil diperbarui.' : 'Pengumuman berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $this->pengumuman_id = $id;
        $this->judul = $pengumuman->judul;
        $this->konten = $pengumuman->konten;
        $this->gambar = $pengumuman->gambar; // this will be a string (path)
        $this->is_aktif = $pengumuman->is_aktif;

        $this->openModal();
    }

    public function delete($id)
    {
        $pengumuman = Pengumuman::find($id);
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }
        $pengumuman->delete();
        session()->flash('message', 'Pengumuman berhasil dihapus.');
    }
}
