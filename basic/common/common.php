<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/26
 * Time: 10:37
 */
namespace app\common;
class common
{
    /**  * 分页及显示函数
     * $countpage 全局变量，照写
     * $url 当前url
     * 输出：
     *  $web=Db::table('web')->where('status=1')->order('sort desc,add_time desc')->select();//数据
    foreach($web as &$val){
    $val['img']=request()->domain().'/'.$val['img'];
    }
    $count =Db::table('web')->where('status=1')->order('sort desc,add_time desc')->count();//总条数
    $pagesize=10;
    $url=$this->request->domain().'/zhyong/Oftenweb/web';
    if(isset($_GET['page'])){
    $p = $_GET['page']?$_GET['page']:1;
    }else{
    $p =1;
    }
    $data=page_array($pagesize,$p,$web,0);
    $countpage=ceil($count/$pagesize);
    $article = show_array($countpage,$url);
    $this->assign('web',$data);
    $this->assign('article',$article);
     *  *  */
    function show_array($countpage,$url,$num=6){
        $page=empty($_GET['page'])?1:$_GET['page'];
        if($page > 1){
            $uppage=$page-1;
        }else{
            $uppage=1;
        }
        if($page < $countpage){
            $nextpage=$page+1;
        }else{
            $nextpage=$countpage;
        }
        if($countpage){
            $str='<div style="border:1px; width:100%; height:30px; color:#fff">';
//    $str.="<span style=''><a href='javascript:;'>共 {$countpage} 页 / 第 {$page} 页</a></span>";
            $str.="<span style=''><a href='$url?page=1'>   首页  </a></span>";
//    $str.="<span style=''><a href='$url?page={$uppage}'> 上一页  </a></span>";
            $str.=pagebar($countpage, $page,$num,$url);
//    $str.="<span style=''><a href='$url?page={$nextpage}'>下一页  </a></span>";
            $str.="<span style=''><a href='$url?page={$countpage}'>尾页  </a></span>"; $str.='</div >';
        }else{
            $str="";
        }
        return $str;
    }
    /**
     * $count 总页数
     * $page 当前页号
     * $num 显示的页码数
     * $url 链接地址
     **/
    function pagebar($count, $page, $num,$url) {
        $num = min($count, $num); //处理显示的页码数大于总页数的情况
        if($page > $count || $page < 1) return; //处理非法页号的情况
        $end = $page + floor($num/2) <= $count ? $page + floor($num/2) : $count; //计算结束页号
        $start = $end - $num + 1; //计算开始页号
        if($start < 1) { //处理开始页号小于1的情况
            $end -= $start - 1;
            $start = 1;
        }
        $str="";
        for($i=$start; $i<=$end; $i++) { //输出分页条，请自行添加链接样式
            if($i == $page)
                $str.= "<span><a style='background-color:#337ab7;' href='$url?page={$i}'> {$i}  </a></span>";
            else
                $str.= " <span><a href='$url?page={$i}'> {$i}  </a></span> ";
        }
        return $str;
    }
    /**
     * 数组分页函数  核心函数  array_slice
     * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
     * $count   每页多少条数据
     * $page   当前第几页
     * $array   查询出来的所有数组
     * order 0 - 不变     1- 反序
     */
    function page_array($count,$page,$array,$order){
        global $countpage; #定全局变量
        $page=(empty($page))?'1':$page; #判断当前页面是否为空 如果为空就表示为第一页面
        $start=($page-1)*$count; #计算每次分页的开始位置
        if($order==1){
            $array=array_reverse($array);
        }
        $totals=count($array);
        $countpage=ceil($totals/$count); #计算总页面数
        $pagedata=array();
        $pagedata=array_slice($array,$start,$count);
        return $pagedata;  #返回查询数据
    }
}