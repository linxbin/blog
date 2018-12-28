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
                                {{-- simplemde 容器 --}}
                                <textarea id="container" name="body" placeholder="">{!! $article->body['raw'] !!}</textarea>
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

        /**
         * 加载simplemde编辑器
         */
        let simplemde = new Simplemde({
            element: document.getElementById("container"),
        });

        /**
         * 监听拖曳图片上传动作
         */
        simplemde.codemirror.on('drop', function (editor, e) {
            if (!(e.dataTransfer && e.dataTransfer.files)) {
                _this.$message({
                    message: "该浏览器不支持操作",
                    type: 'error'
                });
                return
            }
            let dataList = e.dataTransfer.files;
            for (let i = 0; i < dataList.length; i++) {
                if (dataList[i].type.indexOf('image') === -1) {
                    _this.$message({
                        message: "仅支持Image上传",
                        type: 'error'
                    });
                    continue
                }
                let formData = new FormData();
                formData.append('file', dataList[i]);
                formData.append('_token', "{{ csrf_token() }}");
                fileUpload(formData);
            }
        });

        /**
         * 监听粘贴图片上传动作
         **/
        simplemde.codemirror.on('paste', function (editor, e) {
            console.log("codemirror on paste");

            if(!(e.clipboardData&&e.clipboardData.items)){
                alert("该浏览器不支持操作");
                return;
            }
            let dataList = e.clipboardData.items;
            for (let i = 0; i < dataList.length; i++) {
                if (dataList[i].type.indexOf('image') === -1) {

                    continue
                }
                let formData = new FormData();
                formData.append('file', dataList[i].getAsFile());
                formData.append('_token', "{{ csrf_token() }}");
                fileUpload(formData, editor);

            }
        });

        /**
         * 图片上传ajax
         * @param formData
         */
        function fileUpload(formData) {
            $.ajax({
                url: '{{route('uploads.image')}}',
                type: 'POST',
                cache: false,
                data: formData,
                timeout: 5000,
                //必须false才会避开jQuery对 formdata 的默认处理
                // XMLHttpRequest会对 formdata 进行正确的处理
                processData: false,
                //必须false才会自动加上正确的Content-Type
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    Authorization : apiToken.content
                },
                success: function (data) {
                    console.log(data);
                    console.log($('#container').text())
                    simplemde.codemirror. replaceSelection('![]({{config('app.url')}}'+data+')');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("上传出错了")
                }
            });
        }
    </script>
@endsection
