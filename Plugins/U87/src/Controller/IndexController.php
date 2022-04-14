<?php
namespace App\Plugins\U87\src\Controller;

use App\CodeFec\Annotation\RouteRewrite;
use App\Plugins\Topic\src\Handler\Topic\ShowTopic;
use App\Plugins\Topic\src\Models\Topic;
use App\Plugins\Core\src\Models\Report;
use Gregwar\Captcha\CaptchaBuilder;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;

#[Controller]
class IndexController
{
     #[RouteRewrite(route:"/")]
    public function index(): \Psr\Http\Message\ResponseInterface
    {
        $title = null;
        $page = Topic::query(true)
            ->where("status",'publish')
            ->with("tag","user")
            ->orderBy("topping","desc")
            ->orderBy("id","desc")
            ->paginate(get_options("topic_home_num",15));
        if(request()->input("query")==="hot"){
            $page = Topic::query()
                ->where("status",'publish')
                ->with("tag","user")
                ->orderBy("view","desc")
                ->orderBy("id","desc")
                ->paginate(get_options("topic_home_num",15));
            $title = "热度最高的帖子";
        }
        if(request()->input("query")==="likes"){
            $page = Topic::query()
                ->where("status",'publish')
                ->with("tag","user")
                ->orderBy("like","desc")
                ->orderBy("id","desc")
                ->paginate(get_options("topic_home_num",15));
            $title = "点赞最多的帖子";
        }
        if(request()->input("query")==="updated_at"){
            $page = Topic::query()
                ->where("status",'publish')
                ->with("tag","user")
                ->orderBy("updated_at","desc")
                ->paginate(get_options("topic_home_num",15));
            $title = "最后更新";
        }
        if(request()->input("query")==="essence"){
            $page = Topic::query()
                ->where([["essence",">",0],["status",'publish']])
                ->with("tag","user")
                ->orderBy("updated_at","desc")
                ->paginate(get_options("topic_home_num",15));
            $title = "精华主题";
        }
        if(request()->input("query")==="topping"){
            $page = Topic::query()
                ->where([["topping",">",0],["status",'publish']])
                ->with("tag","user")
                ->orderBy("updated_at","desc")
                ->paginate(get_options("topic_home_num",15));
            $title = "置顶主题";
        }
        $topic_menu = [
            [
                "name" => "精华",
                'icon'=>'<svg width="24" height="24" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="icon w-3 h-3 me-1 d-none d-md-block"><g stroke-width="3" fill-rule="evenodd"><path fill="#fff" fill-opacity=".01" d="M0 0h48v48H0z"/><g stroke="currentColor" fill="none"><path d="M10.636 5h26.728L45 18.3 24 43 3 18.3z"/><path d="M10.636 5L24 43 37.364 5M3 18.3h42"/><path d="M15.41 18.3L24 5l8.59 13.3"/></g></g></svg>',
                "url"=> "/?".core_http_build_query(['query'=>'essence'],['page' => request()->input('page' , 1)]),
                "parameter" => "query=essence"
            ],
            [
                "name" => "热门",
                'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 d-none d-md-block" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M0 0h24v24H0z" stroke="none"/><path d="M12 12c2-2.96 0-7-1-8 0 3.038-1.773 4.741-3 6-1.226 1.26-2 3.24-2 5a6 6 0 1 0 12 0c0-1.532-1.056-3.94-2-5-1.786 3-2.791 3-4 2z"/></svg>',
                "url"=> "/?".core_http_build_query(['query'=>'hot'],['page' => request()->input('page' , 1)]),
                "parameter" => "query=hot"
            ],
            [
                "name" => "最赞",
                'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 d-none d-md-block" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path></svg>',
                "url"=> "/?".core_http_build_query(['query'=>'likes'],['page' => request()->input('page' , 1)]),
                "parameter" => "query=likes"
            ],
            [
                "name" => "回复",
				'icon'=>'<svg class="icon w-3 h-3 me-1 d-none d-md-block" width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" fill-opacity=".01" d="M0 0h48v48H0z"/><path d="M48 0H0v48h48V0z" fill="#fff" fill-opacity=".01"/><path d="M24 44c11.046 0 20-8.954 20-20S35.046 4 24 4 4 12.954 4 24s8.954 20 20 20z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M33.542 27c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7v6M33.542 15v6c-1.274-4.057-5.064-7-9.542-7-4.477 0-8.268 2.943-9.542 7" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                "url"=> "/?".core_http_build_query(['query'=>'updated_at'],['page' => request()->input('page' , 1)]),
                "parameter" => "query=updated_at"
            ],
        ];
        return view("App::index",["page" => $page,"topic_menu"=>$topic_menu,'title'=>$title]);
    }
	#[RouteRewrite(route:"/report")]
	public function report(){
	    $page = Report::query()->orderBy("created_at","desc")->paginate(15);
	    return view("App::report.index",['page' => $page]);
	}

}