@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="btn-group mb-4 " role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary active">全部</button>
                    <button type="button" class="btn btn-secondary">按时间</button>
                    <button type="button" class="btn btn-secondary">按热度</button>
                </div>
                <div class="btn-group mb-4 float-right" role="group" aria-label="Basic example">
                    <a href="{{route('articles.create')}}"><button type="button" class="btn btn-success">写文章</button></a>
                </div>
                @foreach( $articles as $article )
                    <div class="list-group mb-4">
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <a href="{{route('articles.show',$article->id)}}"><h5 class="mb-1">{{$article->title}}</h5></a>
                                <small>3 days ago</small>
                            </div>
                            <p class="mb-1">{{$article->body}}</p>
                            <small>
                                <a href="/">Donec</a>
                                <a href="/">id</a>
                                <a href="/">elit</a>
                                <a href="/">non mi porta</a>
                            </small>
                        </div>
                    </div>
                @endforeach
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">上一页</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">下一页</a></li>
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