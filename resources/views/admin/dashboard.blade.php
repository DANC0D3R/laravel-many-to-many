@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            {{-- Alerts --}}
            @if (session('created-allert'))
                <div class="alert alert-success" role="alert">
                    {{ session('created-allert') }}
                </div>
            @endif
            @if (session('updated-allert'))
                <div class="alert alert-success" role="alert">
                    {{ session('updated-allert') }}
                </div>
            @endif
            @if (session('deleted-allert'))
                <div class="alert alert-danger" role="alert">
                    {{ session('deleted-allert') }}
                </div>
            @endif
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Projects</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                    <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->completion_date }}</td>
                    <td><b class="rounded d-inline-block px-2 p-1 mt-1" style="background-color:{{ $project->type?->color }}; color:white">{{ $project->type?->label }}</b></td>
                    <td class="text-end">
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{route('admin.projects.destroy', $project->id)}}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-success me-2"><i class="fa-solid fa-plus"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const hasConfirmed = confirm('Il progetto sarà cancellato definitivamente, sei sicuro di volerlo eliminare?');
            if(hasConfirmed) form.submit();
        })
    })
</script>
@endsection