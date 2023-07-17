<title>Payment</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
     
        {{ __(' Historial de Compras:') }}          
                                 
        <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">          
                <div class="p-6 text-gray-900">

                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border px-4 py-2">Orden</th>
                                <th class="border px-4 py-2">Total pagado</th>
                                <th class="border px-4 py-2">Estado</th>
                                <th class="border px-4 py-2">Retry</th>
                                <th class="border px-4 py-2">Fecha</th>
                                <th class="border px-4 py-2">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($payment as $item)
                           <tr class = "border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $item->order_id }}</td>
                            <td class="px-6 py-4">{{ $item->price_sum }}</td>   
                            <td class="px-6 py-4">{{ $item->status}}</td>
                            <td class="px-6 py-4"> @if ($item->status == 'COMPLETED')
                                    {{('Finalizado')}}
                                    @else
                                    <a href="/pago"  class="text-indigo-600"  class="btn btn-dark">Retry</a>
                                    @endif
                            </td>   
                            <td class="px-6 py-4">{{ $item->created_at }}</td> 
                            <td class="px-6 py-4">
                            <form action="{{ route('payments.detailsOrder', $item) }}" >
                                    @csrf
                                    <input 
                                        type="submit"
                                        name="state"
                                        value="Details" 
                                        class="bg-gray-500 text-white rounded px-4 py-2"
                                    >
                                    <input type="hidden" name="state" class="rounded border-gray-200 w-full mb-4" value="{{ $item->id }}">  
                             </form>
                            </td> 
                        </tr>
                           @endforeach
                        </tbody>
                        <div class="col-lg-5">
                </div>
                    </table>
                </div>
            </div>
                <div class="font-semibold text-s text-gray-800 leading-tight flex justify-between" >
                  
                  <br><a href="/carrito"  class="text-s bg-gray-800 text-white rounded px-4 py-2"  class="btn btn-dark">Regresa a la tienda</a><br>
               </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>