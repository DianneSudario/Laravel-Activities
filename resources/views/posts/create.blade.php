@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">       
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"> 
                        @csrf
                        <div class="from-group-row">
                            <div class="col-md-6"> 

                                <label for="title">Title</label>
                                <input id="title" type="text" class="form-control" name="title" @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required  autofocus>
                                </input>
                                
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description"></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label for="img">Post Image</label>
                                <input type="file" class="form-control-file @error('img') is-invalid @enderror" name="img">

                                @error('img')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <input type="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
