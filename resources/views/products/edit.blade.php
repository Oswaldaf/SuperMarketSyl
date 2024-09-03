@extends('layout.base')

@section('content')
@include('includes.sidebar')

<div class="wrap-content">
    @include('includes.appbar')

    <form action="{{ route('products.update', $product->id) }}" class="category-form" method="POST" enctype="multipart/form-data">
        @csrf

        @method("PATCH")
        <br />
        <h1>Modifier un produit</h1>

        <p>Remplir les informations du produit que vous voulez modifier.</p><br />

        <img src="/storage/images/<?= $product->image_file ?>" alt="img_produit" width="250px">


        <br>

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

        <label for="image_file"><b>Modifier image produit</b></label>

        <input type="file" id="image_file" name="image_file">
        <br>

        <label for="category"><b>Catégorie du produit</b></label>
        <select name="category_id" id="category" required>


            @foreach($categories as $category)

            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach




            <!-- @foreach($categories as $category)
            @if( $product->category_id == $category->id )
            <option value=""> {{ $category->name }} </option>
            @endif
            @endforeach
            @forelse ($categories as $category)
<<<<<<< HEAD

            <option value="{{ $category->id }}">{{ $category->name }}</option>


=======
           


            <option value="{{ $category->id }}">{{ $category->name }}</option>
            
>>>>>>> 63f98ceb707e390a881baadaee3e1005c8c88164
            @empty
            <option value="">Pas de catégorie !</option>

            @endforelse
             -->
        </select>
        <br />

        <label for="name"><b>Nom du produit</b></label>
        <input type="text" placeholder="Nom du produit ..." id="name" minlength="3" maxlength="128" name="name" required value="{{ $product->name }}" />
        <br />

        <table width="100%">
            <tr>
                <td>
                    <label for="price"><b>Prix en F CFA</b></label>
                    <input type="text" min="0" max="1000000" placeholder="Prix ..." id="price" name="price" required value="{{ $product->price }}" />
                </td>
                <td>
                    <label for="quantity"><b>Quantité</b></label>
                    <input type="number" min="1" max="1000000" placeholder="quantité ..." id="quantity" name="quantity" required value="{{ $product->quantity }}" />
                </td>
            </tr>
        </table><br />

        <label for="short_description"><b>Courte description</b> [Facultatif]</label>
        <textarea name="short_description" id="short_description" rows="3" placeholder="Saisir une courte description ...">{{ $product->short_description }}</textarea><br /><br />

        <label for="summernote"><b>Longue description</b> [Facultatif]</label><br /><br />
        <textarea name="long_description" id="summernote" rows="8" placeholder="Saisir une longue description ...">{{ $product->long_description }}</textarea><br />

        <button type="submit" class="button w-100 primary">Soumettre</button>
    </form><br /><br /><br /><br />

</div>

@endsection
<<<<<<< HEAD

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
=======
>>>>>>> 63f98ceb707e390a881baadaee3e1005c8c88164
