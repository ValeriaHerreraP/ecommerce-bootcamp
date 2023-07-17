<title>User Desabled</title>
<x-app-layout>
    <x-slot name="header">
    
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GRAFICOS') }}
            </h2>

        
            <div class="py-4">
            <div class= "p-6 text-gray-900 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" >{{ $chart1->options['chart_title'] }}</h1>
                    {!! $chart1->renderHtml() !!}

                <hr />
<br>
<br>
                <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $chart3->options['chart_title'] }}</h1>
                    {!! $chart3->renderHtml() !!}

                    <hr />
                    <br>
<br>
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $chart2->options['chart_title'] }}</h1>
                    {!! $chart2->renderHtml() !!}

                    <hr />

                    <br>
<br>
               


            
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $chart5->options['chart_title'] }}</h1>
                    {!! $chart5->renderHtml() !!}

                    <hr />

                    <br>
<br>
<h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $chart6->options['chart_title'] }}</h1>
{!! $chart6->renderHtml() !!}

<br>
<br>
            </div>
            </div>

       

    </x-slot>

@section('scripts')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
{!! $chart5->renderJs() !!}
{!! $chart6->renderJs() !!}
@endsection
</x-app-layout>