@extends('layout.base')

@section('content')
@include('includes.sidebar')

<div class="wrap-content">

    @include('includes.appbar')

    <form action="{{ route('products.store') }}" class="category-form" method="POST" enctype="multipart/form-data">
        @csrf

        <br />
        <h1>Créer un nouveau produit</h1>

        <p>Remplir les informations du produit que vous voulez créer.</p><br />

        @if ($errors->any())
        <ul class="alert alert-danger">
            {!! implode('', $errors->all('<li>:message</li>')) !!}
        </ul>
        @endif

        @if ($message = Session::get('error'))
        <ul class="alert alert-danger">
            <li>{{ $message }}</li>
        </ul>
        @endif

        @if ($message = Session::get('success'))
        <ul class="alert alert-success">
            <li>{{ $message }}</li>
        </ul>
        @endif
        <label for="image_file"><b>Image produit</b></label>

        <input type="file" id="image_file" name="image_file">

        <label for="category"><b>Catégorie du produit</b></label>
        <select name="category_id" id="category" required>
            <option value="">Sélectionner une catégorie</option>
            @forelse ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @empty
            <option value="">Pas de catégorie !</option>
            @endforelse
        </select>
        <br />

        <label for="name"><b>Nom du produit</b></label>
        <input type="text" placeholder="Nom du produit ..." id="name" minlength="3" maxlength="128" name="name" required />
        <br />

        <table width="100%">
            <tr>
                <td>
                    <label for="price"><b>Prix en F CFA</b></label>
                    <input type="text" min="0" value="100" max="1000000" placeholder="Prix ..." id="price" name="price" required />
                </td>
                <td>
                    <label for="quantity"><b>Quantité</b></label>
                    <input type="number" min="1" value="10" max="1000000" placeholder="quantité ..." id="quantity" name="quantity" required />
                </td>
            </tr>
        </table><br />

        <label for="short_description"><b>Courte description</b> [Facultatif]</label>
        <textarea name="short_description" id="short_description" rows="3" placeholder="Saisir une courte description ..."></textarea><br /><br />

        <label for="summernote"><b>Longue description</b> [Facultatif]</label><br /><br />
        <textarea name="long_description" id="summernote" rows="8" placeholder="Saisir une longue description ..."></textarea><br />

        <button type="submit" class="button w-100 primary">Soumettre</button>
    </form><br /><br /><br /><br />

</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/summernote/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: "Saisir une lingue description ...",
            height: 150
        });
    });
</script>
@endsection