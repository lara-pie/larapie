<h5 class="field-header m--1">Description</h5>
<div class="px-3 description-body">
    URI: <span class="font-weight-bold">/{{ $route['uri'] }}</span>
    <br>
    Authentication required: <span
            class="text-{{ $route['auth_required'] ? 'primary' : 'danger' }}">{{ $route['auth_required'] ? 'Yes' : 'No' }}</span>
    @if($route['path_variables'])
        <div class="path-variables">Path variables:
        <ul>
            @foreach($route['path_variables']->getPathVariables() as $variable)
                <li>
                    {{ $variable }}
                </li>@endforeach
        </ul>
        </div>
    @endif
</div>