<h1>{{ title }}</h1>



@foreach([1,2,3,4] as $key => $value)
    <p>row: {{ key }} : {{ value }}</p>
@endforeach


@for($i=1;$i<101;$i++)
    <p>Num: {{ i }}</p>

    @if($i >= 10)
        @break
    @endif
    
@endfor

