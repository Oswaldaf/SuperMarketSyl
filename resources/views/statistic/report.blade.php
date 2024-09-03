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
                    <h2>Liste des ventes</h2>
                </td>
                <td class="text-right">
                    <a href="{{ route('sales.create') }}" class="button primary">
                       
                    </a>
                </td>
            </tr>
        </table><br />

        @if ($message = Session::get('success'))
        <ul class="alert alert-success">
            <li>{{ $message }}</li>
        </ul>
        @endif
    <h1>Bilan des ventes du {{ $startDate }} au {{ $endDate }}</h1>

    <!-- <table class="report-page">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix de vente</th>
                <th>Prix total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                <td>
                            {{ $sale->id }}
                        </td>
                        <td>
                            {{ $sale->customer }}
                        </td>
                        <td>
                            {{ $sale->total_amount }} F CFA
                        </td>
                        <td>
                            {{ $sale->created_at->format('d/m/Y') }}
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table> -->

    <div class="border datatable-cover">
            <table id="datatable" class="stripe">
                <thead>
                    <tr>
                        <th>numero facture</th>
                        <th>Nom client</th>
                        <th>Prix totale</th>
                        <th>Date de la facture</th>
                        <th width="100" class="text-center">
                            Opérations
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>
                            {{ $sale->id }}
                        </td>
                        <td>
                            {{ $sale->customer }}
                        </td>
                        <td>
                            {{ $sale->total_amount }} F CFA
                        </td>
                        <td>
                            {{ $sale->created_at->format('d/m/Y') }}
                        </td>

                        <td class="text-center">

                          

                            @csrf
                            <a href="{{ route('sales.show', $sale) }}" class="icon-button primary">
                                <i class="fas fa-print"></i>


                            </a>
                            &nbsp;
                            <form class="d-inline" action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer le produit {{ $sale->name }} ? Cette action sera irréversible !')">
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
@endsection