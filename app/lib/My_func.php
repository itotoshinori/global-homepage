<?php

namespace App\Lib;

use App\Models\Article;
use App\Models\Info;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;

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
    public function request_info_content(Object $request)
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
        $list =  ['NG', 'mission', 'business','company','contact','adoption'];
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

    public function info_menus()
    {
        $menus = Info::oldest()->get()->where('category', 2);
        return $menus;
    }
    public function info_links()
    {
        $links = Info::oldest()->get()->where('category', 3);
        return $links;
    }
    public function info_managements()
    {
        $managements = Info::oldest()->get()->where('category', 4);
        return $managements;
    }
    public function retire_mail()
    {
        $cb = new Carbon();
        $year= $cb->year;
        $month = $cb->month;
        $day = $cb->day;
        $hour = $cb->hour;
        $min = $cb->minute;
        $sec = $cb->second;
        $str = md5(uniqid());
        return $str.$year.$month.$day.$hour.$min.$sec;
    }
    public function login_user_authority($login_user)
    {
        if ($login_user && $login_user->authority == 1) {
            $authority_user = true;
        } else {
            $authority_user = false;
        }
        return $authority_user;
    }
    public function a_tag_change($text)
    {
        $pattern = '/((?:https?|http):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1">$1</a>';
        $text = preg_replace($pattern, $replace, $text);
        return($text);
    }
}
