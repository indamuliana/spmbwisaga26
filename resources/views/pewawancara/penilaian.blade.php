@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <livewire:pewawancara.form-wawancara :calon-siswa-id="request()->route('calonSiswaId')" />
</div>
@endsection
