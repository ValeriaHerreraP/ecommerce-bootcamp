<title>Cart</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Cart') }}  
            @if(count($cartCollection)>0)
                <div class="col-lg-5">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Total a pagar: </b>${{ \Cart::getTotal() }}</li>
                        </ul>
                    </div>
                </div>
            @endif
            @if(count($cartCollection)>0)
                    <form action="{{ route('cart.clear') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="text-xs bg-gray-800 text-white rounded px-4 py-2" onclick="return confirm('Desea eliminar todos los productos del carrito?')">Borrar Carrito</button> 
                    </form>
            @endif
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">          
                <div class="p-6 text-gray-900">

                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border px-4 py-2">Product</th>
                                <th class="border px-4 py-2">Price</th>
                                <th class="border px-4 py-2">Subtotal</th>
                                <th class="border px-4 py-2">Quantity</th>
                                <th class="border px-4 py-2">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($cartCollection as $item)
                           <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->price }}</td>   
                            <td class="px-6 py-4">${{ \Cart::get($item->id)->getPriceSum() }}</td>  
                            {{--                                <b>With Discount: </b>${{ \Cart::get($item->id)->getPriceSumWithConditions() }}--}}     
                            <td class="px-6 py-4">
                            <form action="{{ route('cart.update') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <input type="hidden" value="{{ $item->id}}" id="id" name="id"  >
                                        <input type="number"  value="{{ $item->quantity }}"
                                               id="quantity" name="quantity" style="width: 70px; margin-right: 10px;">
                                        <button class="text-indigo-600">Update</button>
                                    </div>
                               
                            </td> 
                            <td class="px-6 py-4">
                            </form>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="bg-red-800 text-white rounded px-4 py-2"
                                        onclick="return confirm('Desea eliminar el producto?')"style="margin-right: 10px;">Delet Product</button>
                                </form>
                            </td> 
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                   <div class="text-xs bg-gray-500 text-white rounded px-4 py-2"  >
                    @if(\Cart::getTotalQuantity()>0)
                    {{ \Cart::getTotalQuantity()}} Producto(s) en el carrito<br>
                    @else
                    <h4>No Product(s) In Your Cart</h4><br>
                    <a href="/carrito" class="text-xs bg-gray-800 text-white rounded px-4 py-2" class="btn btn-dark">Continue en la tienda</a>
                @endif
                   </div>
                </div>
                
                @if(count($cartCollection)>0)
                <div class="font-semibold text-s text-gray-800 leading-tight flex justify-between" >
                  
                    <br><a href="/carrito"  class="text-s bg-gray-800 text-white rounded px-4 py-2"  class="btn btn-dark">Continue en la tienda</a><br>
                   <br> <a href="/pago" class="text-s bg-gray-800 text-white rounded px-4 py-2" class="btn btn-success">Proceder al Checkout</a><br>
                </div>
                <br>
            @endif
            
            </div>
            <hr>
    </div>
</x-app-layout>
 
                
              
     


