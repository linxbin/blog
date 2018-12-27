@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="btn-group mb-4 " role="group" aria-label="Basic example">
                    <a href="{{ route('articles.index') }}">
                        <button type="button" class="btn btn-secondary active">全部</button>
                    </a>
                    <button type="button" class="btn btn-secondary">按时间</button>
                    <button type="button" class="btn btn-secondary">按热度</button>
                </div>
                @if(Auth::check())
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <a href="{{route('articles.drafts')}}">
                            <button type="button" class="btn btn-primary">草稿箱</button>
                        </a>
                    </div>
                    <div class="btn-group mr-2 float-right" role="group" aria-label="Basic example">
                        <a href="{{route('articles.create')}}">
                            <button type="button" class="btn btn-success">写文章</button>
                        </a>
                    </div>
                @endif
                @foreach( $articles as $article )
                    <div class="list-group mb-4">
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <a href="{{route('articles.show',$article->id)}}"><h5
                                            class="mb-1">{{$article->title}}</h5></a>
                                <small>{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</small>
                            </div>
                            <small>作者： {{ $article->user->name }}</small>
                            <div class="mb-2 mt-2">{!! str_limit($article->body['html'],$limit = 100, $end = '...') !!}</div>
                            <small>
                                @foreach($article->topics as $topic)
                                    <a href="topic/{{$topic->id}}" class="topic"> {{$topic->name}} </a>
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
            <div class="col-md-4">
                @include('layouts.userInfo')
                @include('layouts.tags')
            </div>
        </div>
    </div>
@endsection