@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @foreach( $articles as $article )
                    <div class="list-group mb-4">
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <a href="{{route('articles.show',$article->id)}}"><h5
                                            class="mb-1">{{$article->title}}</h5></a>
                                <small>{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</small>
                            </div>
                            <p>
                                <small class="mr-2">作者： {{ $article->user->name }}</small>
                                <small>浏览： {{ $article->pv }}</small>
                            </p>
                            <small>
                                @foreach($article->topics as $topic)
                                    <a href="{{route('articles.topic', $topic->id)}}" class="topic"> {{$topic->name}} </a>
                                @endforeach
                            </small>
                        </div>
                    </div>
                @endforeach
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{ $articles->links() }}
                    </ul>
                </nav>
            </div>
            <div class="col-md-3">
                @include('layouts._tags')
            </div>
        </div>
    </div>
@endsection