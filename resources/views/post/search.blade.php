@extends("layout.main")

@section('content')
    <div class="row">

        <div class="alert alert-success" role="alert">
            下面是搜索"{{$query}}"出现的文章，共{{$posts->total()}}条
        </div>

        <div class="col-sm-8 blog-main">
            @foreach($posts as $post)
                <div class="blog-post">
                    <h2 class="blog-post-title"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                    <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} <a
                                href="/user/{{$post->user->id}}">{{$post->user->name}}</a></p>

                    {!! str_limit($post->content,100) !!}
                    <p class="blog-post-meta">赞 {{$post->zans_count}} | 评论 {{$post->comments_count}}</p>
                </div>
            @endforeach
            {{$posts->links()}}
        </div><!-- /.blog-main -->


        <div id="sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">


            <aside id="widget-welcome" class="widget panel panel-default">
                <div class="panel-heading">
                    欢迎！
                </div>
                <div class="panel-body">
                    <p>
                        欢迎来到简书网站
                    </p>
                    <p>
                        <strong><a href="/">简书网站</a></strong> 基于 Laravel5.4 构建
                    </p>
                    <div class="bdsharebuttonbox bdshare-button-style0-24" data-bd-bind="1494580268777"><a href="#"
                                                                                                           class="bds_more"
                                                                                                           data-cmd="more"></a><a
                                href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#"
                                                                                                   class="bds_renren"
                                                                                                   data-cmd="renren"
                                                                                                   title="分享到人人网"></a><a
                                href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#"
                                                                                                    class="bds_weixin"
                                                                                                    data-cmd="weixin"
                                                                                                    title="分享到微信"></a><a
                                href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#"
                                                                                                   class="bds_tqq"
                                                                                                   data-cmd="tqq"
                                                                                                   title="分享到腾讯微博"></a><a
                                href="#" class="bds_bdhome" data-cmd="bdhome" title="分享到百度新首页"></a></div>
                    <script>window._bd_share_config = {
                            "common": {
                                "bdSnsKey": {"tsina": "120473611"},
                                "bdText": "",
                                "bdMini": "2",
                                "bdMiniList": false,
                                "bdPic": "",
                                "bdStyle": "0",
                                "bdSize": "24"
                            },
                            "share": {},
                            "image": {
                                "viewList": ["tsina", "renren", "douban", "weixin", "qzone", "tqq", "bdhome"],
                                "viewText": "分享到：",
                                "viewSize": "16"
                            },
                            "selectShare": {
                                "bdContainerClass": null,
                                "bdSelectMiniList": ["tsina", "renren", "douban", "weixin", "qzone", "tqq", "bdhome"]
                            }
                        };
                        with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];</script>
                </div>
            </aside>
            <aside id="widget-categories" class="widget panel panel-default">
                <div class="panel-heading">
                    专题
                </div>

                <ul class="category-root list-group">
                    <li class="list-group-item">
                        <a href="/topic/1">旅游
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/topic/2">轻松
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/topic/5">测试专题
                        </a>
                    </li>
                </ul>

            </aside>
        </div>
    </div>    </div><!-- /.row -->
@endsection