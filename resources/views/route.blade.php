<div class="alert alert-{{ $background }} p-0">
    <div class="d-flex align-items-center cursor-pointer  p-1"
         data-bs-toggle="collapse"
         data-bs-target="#route-info-{{ $index }}"
         aria-expanded="false"
         aria-controls="route-info-{{ $index }}"
    >
        <div class="badge bg-{{ $background }} method-badge">{{ $route['methods'][0] }}</div>
        <div class="p-1 text-dark">{{ !Str::startsWith($route['uri'], '/') ? '/' : '' }}{{ $route['uri'] }}</div> @if($route['auth_required']) <div class="badge bg-info">auth</div> @endif
    </div>
    <div class="collapse" id="route-info-{{ $index }}">
        <div>
            @include('larapie::description', compact('route'))
        </div>
        @if($route['middlewares'])
            <div>
                @include('larapie::middlewares', compact('route'))
            </div>
        @endif
        @if ($route['rules'])
            <div>
                @include('larapie::parameters', compact('route'))
            </div>
        @endif
    </div>
</div>