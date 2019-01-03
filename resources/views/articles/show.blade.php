@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{$article->title}}</h3>
                        <div class="mt-3 mb-3">
                            <small class="text-muted mr-4">作者：{{ $article->user->name }}</small>
                            <small class="text-muted mr-4">创建于：{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</small>
                            <small class="text-muted">浏览：{{ $article->pv }}</small>
                        </div>
                        <div class="markdown">
                            <p class="card-text">{!! $article->body['html'] !!}</p>
                        </div>
                        <small>
                            @foreach($article->topics as $topic)
                                <a href="{{ route('articles.topic',$topic->id) }}" class="topic"> {{$topic->name}} </a>
                            @endforeach
                        </small>
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($article))
                            <span class="edit m-2"><a href="{{route('articles.edit', $article->id)}}">编辑</a></span>
                        @endif
                        @if(Auth::check() && Auth::user()->owns($article))
                            <span class="edit m-2"><a href="{{route('articles.hidden', $article->id)}}">隐藏</a></span>
                        @endif
                        @if(Auth::check() && Auth::user()->owns($article))
                            <span class="edit m-2"><a href="{{route('articles.destroy', $article->id)}}">删除</a></span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('layouts._tags')
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        hljs.initHighlightingOnLoad();
    </script>
@endsection
