<title>Payment</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
        @if ($neworder-> status == 'COMPLETED')
        {{ __(' Pago realizado con Éxito :)') }}          
                                    @else
                                    {{ __(' Error en la transaccion. Debes intentar nuevamente.') }}  
                                    @endif
        </h2>
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
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($cartCollection as $item)
                           <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->price }}</td>   
                            <td class="px-6 py-4">${{ \Cart::get($item->id)->getPriceSum() }}</td>  
                            {{--                                <b>With Discount: </b>${{ \Cart::get($item->id)->getPriceSumWithConditions() }}--}}     
                            <td class="px-6 py-4">{{ $item->quantity }}</td> 
                        </tr>
                           @endforeach
                        </tbody>
                        <div class="col-lg-5">

                        <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>
                        </ul>
                    </div>
                </div>
                    </table>
                </div>
            </div>
                <div class="font-semibold text-s text-gray-800 leading-tight flex justify-between" >
                  
                  <br><a href="/carrito"  class="text-s bg-gray-800 text-white rounded px-4 py-2"  class="btn btn-dark">Regresa a la tienda</a><br>
                 <br> <a href="/paymentUser" class="text-s bg-gray-800 text-white rounded px-4 py-2" class="btn btn-success">Conoce tu historial de pagos</a><br>
               </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>
