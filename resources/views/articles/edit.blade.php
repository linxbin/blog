@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">发布文章</div>
                    <div class="card-body">
                        <form action="{{route('articles.update',$article->id)}}" method="post">
                            {{ method_field('PATCH') }}
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" name="title"
                                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       value="{{ $article->title }}" placeholder="标题" id="title"/>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select class="js-example-placeholder-multiple js-data-example-ajax form-control"
                                        name="topics[]"
                                        multiple="multiple">
                                    @foreach($article->topics as $topic)
                                       <option value="{{$topic->id}}" selected >{{$topic->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- 编辑器容器 -->
                                <script id="container" class="uedit-height" name="body" type="text/plain">
                                    {!! $article->body !!}
                                </script>
                                <input type="hidden"
                                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"/>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" checked type="radio" name="is_hidden" id="inlineRadio1" value="F">
                                    <label class="form-check-label" for="inlineRadio1">发布</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_hidden" id="inlineRadio2" value="T">
                                    <label class="form-check-label" for="inlineRadio2">保存</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success right" type="submit">提交</button>
                            </div>
                        </form>
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
            initialFrameHeight : 400,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        $(document).ready(function () {
            function formatTopic(topic) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel" +
                    "</div></div></div>";
            }

            function formatTopicSelection(topic) {
                return topic.name || topic.text;
            }

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 2,
                ajax: {
                    url: '/api/topics',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatTopic,
                templateSelection: formatTopicSelection,
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
        });
    </script>
@endsection
