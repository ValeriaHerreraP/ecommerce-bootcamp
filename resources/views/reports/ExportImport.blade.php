<title>Export Import Products</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Export and Import products') }}  
            
           
        </h2>
    </x-slot>

    <div class="py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">      
                    
            @can('products.export')
            <div class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('products.export') }}" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Export Products</a>
            @if(session()->has('messag'))
            <div class="alert alert-success text-xs">
             {{ session()->get('messag') }}
             </div>
            @endif

             <a href="{{ route('products.exportdw') }}" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Export Products DW</a>

            @endcan

            @can('products.import')
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <input type="file" name="doc" class="rounded px-4 py-2 text-xs "/>
                       <button type="submit" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Import Products</button>
                       
            @endcan

            @if(session()->has('message'))
            <div class = "text-xs" >
            {{ session()->get('message') }}
            </div>
            @endif
            </form>   

            @can('products.import')
            <form action="{{ route('products.delete_import') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <input type="file" name="import" class="rounded px-4 py-2 text-xs "/>
                       <button type="submit" class="text-xs bg-gray-800 text-white rounded px-4 py-2">Delete Products and Import</button>
            @endcan

            @if(session()->has('message'))
            <div class = "text-xs" >
            {{ session()->get('message') }}
            </div>
            @endif
            </form> 

            </div>

            <br> <br> 
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h4 class="font-semibold text-s text-gray-800 leading-tight flex items-center ">
            {{ __('1. Export Products: queue') }}  
            <br> <br>
            {{ __('2. Export Products Download') }}  
            <br> <br>
            {{ __('3. Import Products queuw') }}  
            <br> <br>
            {{ __('4. Export queue') }}  
                </h4>

                <br> <br> <br>
            </div>


            </div>
          
            
 
</x-app-layout>