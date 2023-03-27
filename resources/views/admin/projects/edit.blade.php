@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('admin.projects.update', $project->id) }}" enctype="multipart/form-data" method="POST">
    @method('PUT')
    @csrf
        <div class="input-group d-flex justify-content-between p-5">
            <div class="w-25 pe-3">
                <label class="mb-2" for="name">Nome progetto</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $project->name) }}" id="name">
            </div>
            <div class="w-25 px-3">
                <label class="mb-2" for="date">Data completamento</label>
                <input type="date" class="form-control" name="completion_date" value="{{ old('completion_date', $project->completion_date) }}" id="date">
            </div>
            <div class="w-25 px-3">
                <label class="mb-2" for="author">Autore progetto</label>
                <input type="text" class="form-control" name="author" value="{{ old('author', $project->author) }}" id="author">
            </div>
            <div class="w-25 ps-3">
                <label class="mb-2" for="type_id">Tipologia progetto</label>
                <select type="text" class="form-select" name="type_id" id="type_id">
                    <option value="">Nessuna tipologia</option>
                    @foreach ($types as $type)
                        <option @if ($project->type_id == $type->id) selected @endif value="{{ $type->id }}">{{ $type->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-between pt-0 p-5">
            <div class="w-75 pe-5">
                <label class="mb-2" for="image">Immagine progetto</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <div class="w-25 px-5">
                <img src="{{ asset('storage/' . $project->image) }}" class="img-fluid rounded" alt="{{ $project->name }}" id="preview">                
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Torna indietro</a>
            <button class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Conferma modifiche</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const fileInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const placeholder = 'https://t3.ftcdn.net/jpg/02/48/42/64/360_F_248426448_NVKLywWqArG2ADUxDq6QprtIzsF82dMF.jpg'

    fileInput.addEventListener('change', () => {
        if(fileInput.files && fileInput.files[0]){
            const reader = new FileReader();
            reader.readAsDataURL(fileInput.files[0]);
            reader.onload = e => {
                preview.src = e.target.result;
            };
        } else{
            preview.src = placeholder;
        }
    });
</script>
@endsection