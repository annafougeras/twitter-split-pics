@extends('app')

@section('content')
    <div class="title m-b-md">
        Laravel
    </div>

    <form method="POST" action="pics" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="pic">Select image to upload:
                <span class="text-muted">(Formats acceptés : JPEG, PNG. Taille maximale : 5 Mo)</span>
            </label>
            <input class="form-control-file" type="file" name="pic" id="pic">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection