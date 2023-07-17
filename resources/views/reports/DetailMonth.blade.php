<title>Report Month</title>
<x-app-layout>
    <x-slot name="header">
    
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Report Month') }}


                    <hr />
                    <br>
                    <br>
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $chart3->options['chart_title'] }}</h1>
                    {!! $chart3->renderHtml() !!}

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

            
        </h2>

    </x-slot>


@section('scripts')
{!! $chart3->renderChartJsLibrary() !!}

{!! $chart3->renderJs() !!}
{!! $chart5->renderJs() !!}
{!! $chart6->renderJs() !!}
@endsection
</x-app-layout>