<title>Details</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
     
        @if ($payment_status != '')
            {{ __(' Estado del pago:' ) }}
            {{$payment_status}}
        @endif
        <br>
        <br>

        {{ __(' Detalle de tu compra:') }}  
                                 
        <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">          
                <div class="p-6 text-gray-900">

                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border px-4 py-2">Producto</th>
                                <th class="border px-4 py-2">Precio</th>
                                <th class="border px-4 py-2">Cantidad</th>
                                <th class="border px-4 py-2">Subtotal</th>
                                <th class="border px-4 py-2">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($payment as $item)
                           <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->price}}</td>   
                            <td class="px-6 py-4">{{ $item->quantity}}</td>  
                            <td class="px-6 py-4">{{ $item->subtotal }}</td> 
                            <td class="px-6 py-4">{{$item->created_at}}</td> 
                           </tr>
                           @endforeach
                        </tbody>
                        <ul class="list-group list-group-flush">
                        </ul>
                        <div class="col-lg-5">
                </div>
                    </table>
                </div>
            </div>
                <div class="font-semibold text-s text-gray-800 leading-tight flex justify-between" >
                  
                  <br><a href="/available_products"  class="text-s bg-gray-800 text-white rounded px-4 py-2"  class="btn btn-dark">Regresa a la tienda</a><br>
               </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>