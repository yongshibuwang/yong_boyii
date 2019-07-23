<?php
define("TOKEN", "zhyong");    //定义TOKEN, “peng”是自己随便定义，这一句很重要！！！
$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
//    $wechatObj->responseMsg();    //后续的有实质功能的function
}else{
    $wechatObj->valid();    //调用valid函数进行基本配置
}

class wechatCallbackapiTest
{
    private $access_token;    //定义一个access_token，用于后续调用微信接口（此篇用不到）

    public function __construct(){    //构造函数

    }
    //验证微信公众号配置
    public function valid(){    //用于基本配置的函数
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg(){
        //1.获取到微信推送过来post数据（xml格式）
        $postArr=$GLOBALS['HTTP_RAW_POST_DATA'];
        //2.处理消息类型，并设置回复类型和内容
        $postObj=simplexml_load_string($postArr);
        //判断该数据包是否是订阅de事件推送
        if(strtolower($postObj->MsgType)=='event')
        {
            //如果是关注 subscribe事件
            if(strtolower($postObj->Event)=='subscribe')
            {
                $toUser    =$postObj->FromUserName;
                $fromUser  =$postObj->ToUserName;
                $time      =time();
                $msgType   ='text';
                $content   ="Hi,欢迎关注她多好!/:#-0/:#-0/:#-0"."\n"."浮世三千，吾爱有三。/:love"."\n".
                    "日，月与卿。/:love"."\n"."日为朝，月为暮。/:love"."\n"."卿为朝朝暮暮。/:love"
                    ."\n"."也可以和我聊天哦，天气、快递、菜谱、列车、酒店，我无所不知。/::D";
                $template="<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
                $info=sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                echo $info;
            }
        }
    }
}
?>