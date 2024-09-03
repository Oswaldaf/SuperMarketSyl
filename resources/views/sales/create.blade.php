@extends('layout.base')

@section('content')
@include('includes.sidebar')

<div class="wrap-content">
    @include('includes.dashboard')

    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <br />
        <div>
            @if($message = Session::get("error"))
            {{ $message }}
            @endif
            <table width="100%">
                <tr>
                    <td>
                        <h2>Vendre un produit</h2>
                    </td>
                    <td class="text-right">
                        <button type="submit" class="button primary">
                            Créer
                        </button>
                    </td>
                </tr>
            </table><br />




            <ul class="alert alert-success">
                <li></li>
            </ul>

            <div class="border datatable-cover">
                <table id="datatable" class="stripe">

                    <thead>
                        <input type="text" name="customer" id="customer" placeholder="Nom du client">
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Quantité disponible</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th width="100" class="text-center">
                                Opérations
                            </th>
                        </tr>
                    </thead>
                    <tbody id="product-list">



                    



                    </tbody>
                </table>
            </div>








            <div>


                <button type="button" id="add-product">Ajouter un produit</button>
            </div>

            <!-- <button type="submit">Generer la vente</button> -->

        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        let productId = 0;
        let instanceId = 0;

        document.getElementById('add-product').addEventListener('click', function() {

            instanceId++;

            productId++;

            const productIndex = document.querySelectorAll('product-list tr').length;
            const productTemplate = `
                 <tr>

                            <td>
                                <img id="product-image${instanceId}" src="/storage/images/téléchargement.png" alt="img" width="50" >
                            </td>
                            <td>
                                <select name="items[${productId}][product_id]" id="product${instanceId}">
                                    <option value="" selected disabled>Sélectionner un produit</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-quantity="{{ $product->quantity }}" data-price="{{ $product->price }}" data-image="{{ $product->image_file }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                            <input type="text" name="products[${productId}][quantity]" id="product-quantity${instanceId}" placeholder="" readonly>
                               
                            </td>
                            <td>
                            <input type="text" name="products[${productId}][price]" id="product-price${instanceId}" placeholder="" readonly>
                               
                            </td>
                            <td>
                                <input type="number" name="items[${productId}][quantity]" id="" min="1" value="">
                            </td>
                            <td class="text-center">

                                &nbsp;
                              
                                    

                                   
                                        <i class="fas fa-trash"></i>
                                   
                              
                            </td>

                        </tr>
            `;
            document.getElementById('product-list').insertAdjacentHTML('beforebegin', productTemplate);



            $(`#product${instanceId}`).change(function() {
                const productId = $(this).val();
                console.log(productId);
                if (productId) {

                    $(`#product-quantity${instanceId}`).attr('placeholder', $(`option:selected`, this).attr("data-quantity"));

                    $(`#product-price${instanceId}`).attr('placeholder', $(`option:selected`, this).attr("data-price"));

                    $(`#product-image${instanceId}`).attr('src', '/storage/images/' + $(`option:selected`, this).attr("data-image"));

                    // $.ajax({
                    //     url: `/products/${productId}`,
                    //     method: 'GET',

                    //     success: function(response) {

                    //         console.log("sucess");
                    //     },
                    //     error: function() {
                    //         $(`#product-price${instanceId}`).attr('placeholder', 'prix');
                    //         $(`#product-image${instanceId}`).hide();
                    //         console.log("sucess");
                    //     }
                    // });
                } else {
                    $(`#product-price${instanceId}`).text('N/A');
                    $(`#product-image${instanceId}`).hide();
                }


            });

        });
    </script>
</div>
@endsection