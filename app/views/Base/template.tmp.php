
@if(false)
    <p>Hello Callum</p>
@else
    <p>Hello Guest</p>
@endif



@switch('hannah') 
    @case('john')
        <p>Hello John</p>
        @break

    @case('callum')
    @case('hannah')
        <p>Hello Callum</p>
        @break
    @default
        <p>Hello Undefined</p>
@endswitch

@foreach([1,2,3,4] as $value)
    <p>row</p>
@endforeach


@unless(false)
    <p>Unless</p>
@endunless