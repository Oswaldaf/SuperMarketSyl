@extends('layout.base')

@section('content')
    @include('includes.sidebar')

    <div class="wrap-content">
        @include('includes.appbar')

        <form action="{{ route('categories.update', $category->id) }}" class="category-form" method="POST">
            @csrf
            
            @method("PATCH")
            <br />
            <h1>Modifier une catégorie</h1>

            <p>Remplir les informations de la catégorie que vous voulez modifier.</p><br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    {!! implode('', $errors->all('<li>:message</li>')) !!}
                </ul>
            @endif

            @if ($message = Session::get("error"))
                <ul class="alert alert-danger">
                    <li>{{ $message }}</li>
                </ul>
            @endif

            @if ($message = Session::get("success"))
                <ul class="alert alert-success">
                    <li>{{ $message }}</li>
                </ul>
            @endif

            <label for="name"><b>Nom de la catégorie</b></label>
            <input type="text" placeholder="Nom de la catégorie ..." id="name" minlength="3" maxlength="128"
                name="name" required value="{{ $category->name }}" />
            <br /><br />
            <label for="description"><b>Description</b> [Facultatif]</label>
            <textarea name="description" id="description" rows="3" placeholder="Saisir la description ...">{{ $category->description }}</textarea><br />

            <button type="submit" class="button w-100 primary">Soumettre</button>
        </form>

    </div>
@endsection
