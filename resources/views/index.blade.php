@extends('larapie::layout')

@section('content')
    @include('larapie::navbar')
    <div class="larapie-container">
        @foreach($routes as $index => $route)
            @include('larapie::route', [
                'route' => $route,
                'background' => \Larapie\Larapie\Services\RouteViewService::guessBackground($route['methods'][0]),
                'index' => $index,
            ])
        @endforeach
    </div>
    <style>
        .larapie-container {
            width: 100%;
            max-width: 1460px;
            margin: 0 auto;
            padding: 40px 20px 80px;
            font-size: 14px;
        }

        .method-badge {
            font-size: 16px;
            height: 32px;
            line-height: 30px;
            padding: 0;
            width: 90px;
            margin-right: 10px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .field-header {
            background: hsla(0, 0%, 100%, .8);
            padding: 8px 20px;
            min-height: 50px;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .parameters-table-block {
            font-size: 14px;
        }

        .description-body {
            font-size: 14px;
            line-height: 1.75;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .path-variables {
            margin-top: 10px;
        }
    </style>
@endsection