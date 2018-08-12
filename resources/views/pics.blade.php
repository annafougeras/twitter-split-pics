@extends('app')

@section('content')
    <h1>Pictures</h1>

    <h2>Mobile Twitter / Tweetdeck</h2>
    <div class="pic-group mobile-group">
        @for ($i = 0; $i < 4; $i++)
            <div><img src="uploads/{{ $rand }}-{{ $i }}.jpg"></div>
        @endfor
    </div>

    <h2>Desktop Twitter</h2>
    <div class="pic-group desktop-group">
        @for ($i = 4; $i < 8; $i++)
            <div><img src="uploads/{{ $rand }}-{{ $i }}.jpg"></div>
        @endfor
    </div>

@endsection