@component('mail::message')
     {{ $content['title'] }}

    {{ $content['body'] }}



    {{--@component('mail::button', ['url' => ''])--}}
        {{--{{ $content['button'] }}--}}
    {{--@endcomponent--}}


    Thanks,
    {{ config('app.name') }}

@endcomponent