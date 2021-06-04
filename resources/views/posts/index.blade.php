@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card"><br>       
                <a class="btn btn-info pull-right" style="font-size: 15px;color: #000000;text-align: center; height: 40px;
        width: 200px;margin: 0px auto;padding-top: 10px; margin-top:40px;" href="/posts/create">Create New</a>
                    <div class="card-body">

                        
                        <table class="table">
                            <thead>
                                    <tr>
                                        <th> ID </th>
                                        <th> TITLE </th>
                                        <th> DESCRIPTION </th>
                                        <th>  </th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($post as $post)
                                <tr>
                                        <td> {{ $post->id }} </td>
                                        <td> {{ $post->title }} </td>
                                        <td> {{ $post->description }} </td>
                                        <td> <a  href="/posts/{{$post->id}}" class="btn btn-warning" style="width:100px"> View </a> </td>
                                        <td> <a  href="/posts/{{$post->id}}/edit" class="btn btn-success"style="width:100px"> Edit </a> </td>
                                        <td> 
                                            <form action="{{route('posts.destroy', $post ->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button type="submit" class="btn btn-danger" style="width:100px">Delete</button>
                                            </form>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection