<h5 class="field-header m--1">Middlewares</h5>
<div class="px-3">
        <ul>
                @foreach($route['middlewares']->getMiddlewares() as $key => $middleware)
                        <li>{{$middleware}}</li>
                @endforeach
        </ul>
</div>