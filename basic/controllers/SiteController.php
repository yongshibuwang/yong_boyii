<?php

namespace app\controllers;
use app\models\access;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
class SiteController extends Controller
{
    /**
     * 显示捧腹笑话
     * Index action.
     * @author 勇☆贳&卟☆莣
     * @return Response|string
     */
    public function actionIndex()
    {

        $connection = \Yii::$app->db;
//        dump(111);die;
        //获取用户访问ip
        if($this->getIp()){
            $user_ip['ip']=$this->getIp();
        }else{
            $user_ip['ip']="127.0.0.1";
        }
        $user_ip['access_time']=time();
        $user_ip['access_date']=date('Ymd',time());
        $user_ip['access_web']="捧腹笑话";
        $sql1 = "select * from access where ip = '".$user_ip['ip']."' order by access_time desc";
        $id = $connection->createCommand($sql1)->queryAll();

        if($id){
            if(date('Ymd',$id[0]['access_time'])==date('Ymd',time())){

                $num=$id[0]['access_num']+1;
                $sql2 = "update access set access_web = '捧腹笑话',access_time='".time()."',access_num='".$num."' where id= ".$id[0]['id'];
                $connection->createCommand($sql2)->query();
            }else{
                $sql3="insert into access (ip,access_time,access_date,access_web) values ('".$user_ip['ip']."','".time()."','".date('Ymd',time())."','捧腹笑话')";

                $connection->createCommand($sql3)->query();
            }
        }else{
            $sql3="insert into access (access_time,access_date,access_web) values ('".time()."','".date('Ymd',time())."','捧腹笑话')";
            $connection->createCommand($sql3)->query();
        }

        //链接数据库

        $sql = "SELECT * FROM ling order by add_time desc";
        $rows = $connection->createCommand($sql)->queryAll();
        $pagination = new Pagination(['totalCount' => count($rows), 'defaultPageSize' => 20]);
        $models = $connection->createCommand($sql." limit ".$pagination->limit." offset ".$pagination->offset."")->queryAll();
//        return $this->render('index',[
//            'models' => $models,
//            'pagination' => $pagination,
//        ]);
        return $this->renderPartial('index',compact('models','pagination'));
    }
    /**
     * 获取用户真实ip
     * @author 勇☆贳&卟☆莣
     * */
    public function getIp(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip= $_SERVER['HTTP_CLIENT_IP'];
        }
//ip是否来自代理
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip= $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
//ip是否来自远程地址
        else{
            $ip= $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
