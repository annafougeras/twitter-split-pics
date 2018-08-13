@extends('app')

@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <h1><a href="#">Twitter split pics</a></h1>
            <p>Split an image into 4 images to get a cool effect with thumbnails on Twitter.</p>
            <p>Supports mobile Twitter, Tweetdeck and desktop Twitter.</p>

            <p><img class="example" src="example.jpg"/></p>
            <form method="POST" action="pics" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="picture">Select image to upload:
                        <span class="text-muted">(Accepted : JPEG, PNG. Under 2 MB)</span>
                    </label>
                    <input class="form-control-file" type="file" name="picture" id="picture">
                </div>
                @foreach($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
                <button type="submit" class="btn btn-primary">Split image</button>
            </form>
        </div>
    </div>
@endsection