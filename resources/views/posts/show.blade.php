@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">       
                <div class="card-body">
                    Title: {{$post -> title}} <br>
                    Description: {{$post -> description}} <br>
                    Created at: {{$post -> created_at}}<br>
                    Image:  <img src="{{ asset('/storage/img/'.$post->img) }}"> 

                    @if ($comments)
                        @foreach ($comments as $comment)
                            <div class="display-comment" >

                                <p>Comment: {{ $comment->description }}</p>
                                
                            </div>
                        @endforeach
                    @endif

                    <h6>ADD COMMENT HERE:</h6>
                    <form method="post" action="{{ route('comments.store')}}">
                        @csrf
                        <div class="form-group">
                            <textarea name="description" id="description" class="from-control" cols="40" rows="2"></textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" value="COMMENT">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection