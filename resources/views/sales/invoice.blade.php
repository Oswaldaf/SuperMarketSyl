<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
</head>

<body>


    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {

            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>


    <h1>Groupe N°4</h1>
    <h3>Tel: 00 00 00 00</h3>
    <hr>

    <h1>Facture {{ $sale->id }}</h1>
    <p><strong>Client:</strong> {{ $sale->customer }} </p>
    <p><strong>Date:</strong> {{ $sale->created_at->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantiter</th>
                <th>Prix</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: {{ $sale->total_amount }} Fcfa</h3>

</body>

</html>