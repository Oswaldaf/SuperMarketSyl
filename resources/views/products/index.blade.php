@extends('layout.base')

@section('content')
@include('includes.sidebar')

<div class="wrap-content">
    @include('includes.dashboard')

    <br />
    <div>
        <table width="100%">
            <tr>
                <td>
                    <h2>Liste des produits</h2>
                </td>
                <td class="text-right">
                    <a href="{{ route('products.create') }}" class="button primary">
                        Créer
                    </a>
                </td>
            </tr>
        </table><br />

        @if ($message = Session::get('success'))
        <ul class="alert alert-success">
            <li>{{ $message }}</li>
        </ul>
        @endif

        <div class="border datatable-cover">
            <table id="datatable" class="stripe">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th width="100" class="text-center">
                            Opérations
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            <img src="/storage/images<?= $product->image_file ?>" alt="img" width="50">
                        </td>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>
                            {{ number_format($product->price, 0, " ") }} F CFA
                        </td>
                        <td>
                            {{ $product->quantity }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="icon-button primary">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            &nbsp;
                            <form class="d-inline" action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer le produit {{ $product->name }} ? Cette action sera irréversible !')">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="icon-button error">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection