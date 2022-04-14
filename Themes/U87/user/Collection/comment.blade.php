<div class="border-0 card card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-auto">
                    <span class="avatar" style="background-image: url({{super_avatar($comment->user)}})"></span>
                </div>
                <div class="col text-truncate">
                    <a style="white-space:nowrap;" href="/users/{{$comment->user->username}}.html" class="text-body text-truncate">{{$comment->user->username}}</a>
                    <br>
                    <small data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{$comment->created_at}}" class="text-muted text-truncate mt-n1">发表于:{{$comment->created_at}}</small>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="hr-text" style="margin-bottom:5px;margin-top:15px">评论摘要</div>
        </div>
        <div class="col-md-12 markdown vditor-reset">
            {{\Hyperf\Utils\Str::limit(remove_bbCode(strip_tags($comment->content)),100)}}
        </div>
    </div>
</div>