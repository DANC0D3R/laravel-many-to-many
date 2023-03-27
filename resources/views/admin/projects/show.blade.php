@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto p-5">
            <div class="card overflow-hidden" style="min-width:20rem; max-height:32rem; max-width: @if($project->image) 45rem; @else 20rem; @endif ">
                <div class=" d-flex">
                    <div class="@if($project->image) w-25 @else w-100 @endif">
                        <div class="card-header">
                            <b>Nome progetto:</b><br>{{ $project->name }}
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Data di completamento:</b><br>{{ $project->completion_date }}</li>
                            <li class="list-group-item"><b>Autore:</b><br>{{ $project->author }}</li>
                            @if ($project->type)
                            <li class="list-group-item">
                                <b>Tipologia:</b>
                                <br>
                                <b class="rounded d-inline-block px-2 p-1 mt-1" style="background-color:{{ $project->type->color }}; color:white">{{ $project->type->label }}</b>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @if ($project->image)
                    <div class="w-75">
                        <figure class="m-0 p-0 w-100 h-100">
                            <img src="{{ asset('storage/' . $project->image) }}" class="w-100 rounded-end" alt="...">
                        </figure>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Torna alla dashboard</a>
    </div>
</div>
@endsection