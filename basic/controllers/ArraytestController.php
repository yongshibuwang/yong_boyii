<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\access;
use app\models\ling;
use QL\QueryList;
class  ArraytestController extends Controller
{
    public function actionArraytest(){
        $countries=access::find()->all();
        return $this->render('arraytest',['countries'=>$countries]);
    }
    public function actionRefresh(){
        /**************************抓取文章***************************/
        // 采集捧腹网页面文章列表中所有[文章]的超链接和超链接文本内容
        for($i=1;$i<=3;$i++){
            $data = QueryList::get('https://www.pengfue.com/xiaohua_'.$i.'.html')
                ->rules([
                    'link' => ['dl>dt>a','href'],
                    'head_img' => ['dl>dt>a>img','src'],
                    'name' => ['dl>dd>p>a','text'],
                    'title' => ['dl>dd>h1>a','text'],
                    'text' => ['dl>dd>div.content-img','text']
                ])->range('.list-item')->query()->getData();
            $data=$data->all();
            /*循环加入数据库，如果有重复则停止*/
            foreach ($data as $dkey=>$dval){
                $dval['add_time']=time()+$dkey;
                $arr['title']=$dval['title'];
                $arr['name']=$dval['name'];
                $arr['link']=$dval['link'];
                if(ling::find()->where(['text'=>$dval['text']])->one()){
                    $status = false;
                    return json_encode(['status' => $status]);
                }else{
                    $model = new Ling();
                    $model->link = $dval['link'];
                    $model->head_img = $dval['head_img'];
                    $model->name = $dval['name'];
                    $model->title = $dval['title'];
                    $model->add_time = $dval['add_time'];
                    $model->text = $dval['text'];
                    $model->insert();
                }
            }
        }
        $status = true;
        return json_encode(['status' => $status]);
        /**************************抓取文章（END）***************************/
    }
}
