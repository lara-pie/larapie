<h5 class="field-header">
    @if(in_array(mb_strtolower($route['methods'][0]), ['get', 'head'])) Query parameters @else Request body @endif
    {{ '('.mb_strtoupper($route['methods'][0]).')' }}
</h5>
<div class="px-3 parameters-table-block">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Rules</th>
        </tr>
        </thead>
        <tbody>
        @foreach($route['rules']->getRules() as $key => $rules)
            <tr>
                <th scope="row">{{ $key }}</th>
                <td>{{ implode(', ', $rules)  }}</td>
            </tr>@endforeach
        </tbody>
    </table>
</div>