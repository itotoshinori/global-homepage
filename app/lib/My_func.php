<?php

namespace App\Lib;

use App\Models\Article;
use Carbon\Carbon;

class My_func
{
    public function week_dis(int $num)
    {
        $week = [
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土', //6
        ];
        return $week[$num];
    }
    public function url_part(string $content)
    {
        if (strlen($content) >50) {
            $result = substr($content, 0, 49)."...";
            return $result;
        } else {
            return $content;
        }
    }
    public function request_content(Object $request)
    {
        $result=[
            'title' => $request->title,
            'body' => $request->body,
            'link' => $request->link,
            'category' => $request->category
        ];
        return $result;
    }
    public function limit_setting(string $content)
    {
        if (strlen($content)>=90) {
            $result = mb_substr($content, 0, 89, 'UTF-8')."...";
        } else {
            $result = $content;
        }
        return $result;
    }
    public function urls()
    {
        $list =  ['NG', 'company', 'business','outline','contact','adoption'];
        return $list;
    }
    public function dis_new($day)
    {
        $carbon= Carbon::now();
        $ten_day_before = $carbon->subDays(10);
        if ($day>$ten_day_before) {
            return "New!";
        }
    }
    public function main_articles()
    {
        $articles = Article::oldest()->get()->where('category', 0);
        return $articles;
    }
}
