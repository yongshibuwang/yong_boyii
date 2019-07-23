<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>花开成海，思念成灾</title>
    <script src="static/home/js/jquery.min.js"> </script>
    <script src="static/home/js/amazeui.min.js"> </script>
    <script src="static/home/js/layer/layer.js"> </script>
    <link rel="stylesheet" type="text/css" href="static/home/css/wap.css">
    <link rel="stylesheet" type="text/css" href="static/home/css/amazeui.min.css">
    <link rel="stylesheet" type="text/css" href="css/site.css">
</head>
<body style="background:#ececec">
<div class="pet_mian" id="top" style="position: relative;">
    <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{"directionNav":false}' >
        <ul class="am-slides">
            <li>
                <img src="static/home/img/fl01.png">
                <div class="pet_slider_font">
                    <span class="pet_slider_emoji">好想给你打一辈子辅助</span>
                    <span class="pet_slider_emoji" style="font-size: 14px;">人头是你的、兵线是你的、buff是你的、塔是你的</span>
                    <span>所有经济都是你的，我什么都不要，只要你活着</span>
                </div>
                <div class="pet_slider_shadow"></div>
            </li>
        </ul>
    </div>
    <span class="refresh-ac" onclick="ref()" style="position: absolute;z-index: 9999;top: 0;color: #a92db7;
                font-size: 12px;
                background-color: #0ba4ea;padding: 3px 6px;border-radius: 4px;
                ">再来一批</span>
    <a href="http://www.zhyong.top/index/index/index/mobile/1" style="position: absolute;z-index: 9999;top: 0;right:0;color: #a92db7;
                font-size: 12px;
                background-color: #0ba4ea;padding: 3px 6px;border-radius: 4px;
                ">返回首页</a>
</div>
<div class="pet_mian"  style="">
    <div class="pet_content pet_content_list">
        <div class="pet_article_like">
            <div class="pet_content_main pet_article_like_delete">
                <div data-am-widget="list_news" class="am-list-news am-list-news-default am-no-layout">
                    <div class="am-list-news-bd">
                        <ul class="am-list">
                            <!--缩略图在标题右边-->
                            <?php foreach ($models as $model): ?>
                                <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-right pet_list_one_block">
                                    <div class="pet_list_one_info" style="margin-bottom: 0;">
                                        <div class="pet_list_one_info_l">
                                            <div class="pet_list_one_info_ico"><img src=" <?= $model['head_img']; ?>" alt=""></div>
                                            <div class="pet_list_one_info_name"><?= $model['name']; ?></div>
                                        </div>
                                    </div>
                                    <div class=" am-u-sm-8 am-list-main pet_list_one_nr" style="width: 100%;font-size: 16px;">
                                        <?= $model['text']; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

            </div>
            <style>
                #page ul li a {
                    border: 1px solid #ddd;
                    height: 16px;
                    line-height: 17px;
                    margin: 0 3px;
                    padding: 4px 12px;
                    font-size: 12px;
                    color: #337ab7;
                }
                #page ul li span {
                    border: 1px solid #ddd;
                    height: 16px;
                    line-height: 17px;
                    margin: 0 3px;
                    padding: 4px 12px;
                    font-size: 12px;
                    color: #337ab7;
                }
                #page .active a{
                    background-color: #337ab7;
                    color: #000;
                }
                #page li {
                    float:left; /* 往左浮动 */
                }

            </style>
            <div  id="page" style="margin: 0;" class="pet_article_footer_info">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);?>
            </div>
        </div>
        <div class="pet_article_footer_info">一个很有趣的油腻大叔(内容来源网络，如有侵权，请联系删除)</div>
    </div>
</div>
<div id="_show" style="    position: absolute;
    width: 100%;height: 100%;left: 0;top: 0;
    background-color: rgba(0,0,0,0.6);display: none"" >
    <div style="position: fixed;z-index: 999;top: 30%;left: 30%";>
        <img src="static/home/img/auto.gif" alt="" style="">
        <div style="color: #fff;width: 100%;text-align: center;">努力爬取中</div>
    </div>
</div>

<script>
    function ref(){
        $('#_show').show(function () {
            $.ajax({
                url:"<?= Url::toRoute('arraytest/refresh');?>",
                type:'post',
                data:{'id':2,_csrf:"<?=Yii::$app->request->getCsrfToken()?>"},
                dataType : 'json',
                async : false,
                success : function(data){
                    if(data.status){
                        layer.msg('更新成功！',{time:1000},function(){
                            window.location.reload();
                        })
                    }else{
                        layer.msg("小姐姐，已经是最新的了哦",{time:2000},function(){
                            window.location.reload();
                        });
                    }
                },
                error:function (){
                    layer.msg("捧腹网请求超时");
                }
            });
        });
    }
</script>
</body>
</html>