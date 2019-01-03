<div class="card mb-4 border-bottom-0">
    <div class="card-header">标签</div>
    @if(count($topics))
        <ul class="list-group">
        @foreach($topics as $topic)
            <li class="list-group-item d-flex justify-content-between align-items-center border-right-0 border-left-0">
                <a href="{{route('articles.topic', $topic->id)}}">
                    {{ $topic->name }}
                </a>
                <a href="{{route('articles.topic', $topic->id)}}">
                    <span class="badge badge-primary badge-pill">{{ $topic->articles_count }}</span>
                </a>
            </li>
        @endforeach
        </ul>
        @else
        <div class="card-body">
            暂时还没有标签哦~~~
        </div>
    @endif
</div>