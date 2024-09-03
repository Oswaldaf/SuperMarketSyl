@extends('layout.base')

@section('content')
    @include('includes.sidebar')

    <div class="wrap-content">
        @include('includes.appbar')

        <form action="{{ route('categories.store') }}" class="category-form" method="POST">
            @csrf

            <br />
            <h1>Créer une nouvelle catégorie</h1>

            <p>Remplir les informations de la catégorie que vous voulez créer.</p><br />

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
                name="name" required />
            <br /><br />
            <label for="description"><b>Description</b> [Facultatif]</label>
            <textarea name="description" id="description" rows="3" placeholder="Saisir la description ..."></textarea><br />

            <button type="submit" class="button w-100 primary">Soumettre</button>
        </form>

    </div>
@endsection
