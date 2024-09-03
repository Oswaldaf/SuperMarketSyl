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
                    <h2>Les statistiques</h2>
                </td>
                <td class="text-right">
                    <a href="" class="button primary">
                       Générer le rapport
                    </a>
                </td>
            </tr>
        </table><br />


        <ul class="alert alert-success">
            <li></li>
        </ul>


        
    </div>
    <div class="report">
    <h1>Générer un bilan des ventes</h1>
    <form action="{{ route('sales.report') }}" method="POST">
    @csrf
        <label for="start_date">Date de début:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">Date de fin:</label>
        <input type="date" id="end_date" name="end_date" required>

        <button type="submit" class="button-primary">Générer le rapport</button>
    </form>

  </div>
</div>



  
@endsection
@section('js')
<script src="{{ URL::asset('assets/chart/chart.min.js') }}" charset="utf-8"></script>
{!! $product_chart_by_category->script() !!}
{!! $chartBySale->script() !!}

@endsection