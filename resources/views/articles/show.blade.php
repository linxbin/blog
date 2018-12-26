@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$article->title}}</h5>
                        <p class="card-text">{{$article->body}}</p>
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($article))
                            <span class="edit"><a href="{{route('articles.edit', $article->id)}}">编辑</a></span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('layouts.userInfo')
                @include('layouts.tags')
            </div>
        </div>
    </div>
@endsection