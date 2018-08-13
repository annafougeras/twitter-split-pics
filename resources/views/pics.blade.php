@extends('app')

@section('content')
    <h1><a href=".">Twitter split pics</a></h1>
    <p><a href=".">&larr; Split another picture</a></p>
    <div class="row">
        <div class="col-xl-6">
            <h2>Mobile Twitter / Tweetdeck</h2>
            <div class="pic-group mobile-group">
                @for ($i = 0; $i < 4; $i++)
                    <div><img src="uploads/{{ $rand }}-{{ $i }}.jpg"></div>
                @endfor
            </div>
        </div>
        <div class="col-xl-6">
            <h2>Desktop Twitter</h2>
            <div class="pic-group desktop-group">
                @for ($i = 4; $i < 8; $i++)
                    <div><img src="uploads/{{ $rand }}-{{ $i }}.jpg"></div>
                @endfor
            </div>
        </div>
    </div>
@endsection