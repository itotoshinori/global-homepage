<?php

namespace App\Lib;

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
    public function categories()
    {
        $list = array('会社概要', '事業内容', '取引先');
        return $list;
    }
    public function dis_new($day)
    {
        $ten_day_before = new Carbon('-10 days');
        if ($day>$ten_day_before) {
            return "New!";
        }
    }
}
