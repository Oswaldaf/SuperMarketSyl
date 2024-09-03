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
                    <h2>Liste des catégories</h2>
                </td>
                <td class="text-right">
                    <a href="{{ route('categories.create') }}" class="button primary">
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
                        <th>Nom</th>
                        <th>Description</th>
                        <th width="100" class="text-center">
                            Opérations
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            {!! $category->description == null
                            ? "<span class='text-muted'>Pas de description.</span>"
                            : $category->description !!}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('categories.edit', $category->id) }}" class="icon-button primary">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            &nbsp;
                            <form class="d-inline" action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer la catégorie {{ $category->name }} ? Cette action sera irréversible !')">
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