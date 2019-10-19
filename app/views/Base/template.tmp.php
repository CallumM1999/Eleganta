<h1>{{ title }}</h1>



@foreach([1,2,3,4] as $key => $value)
    <p>row: {{ key }} : {{ value }}</p>
@endforeach

