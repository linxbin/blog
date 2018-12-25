@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">发布文章</div>
                    <div class="card-body">
                        <form action="{{route('articles.store')}}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" name="title" class="form-control" value="" placeholder="标题" id="title"/>
                            </div>
                            <div class="form-group">
                                <!-- 编辑器容器 -->
                                <script id="container" name="body" type="text/plain">
                                    {!! old('body') !!}
                                </script>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control"/>
                            </div>
                            <button class="btn btn-success right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection


