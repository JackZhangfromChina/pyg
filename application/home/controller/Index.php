<?php
namespace app\home\controller;

class Index
{
    public function index()
    {

        $es = \Elasticsearch\ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();
        $params = [
            'index' => 'test_index',
            'type' => 'test_type',
            'id' => 100,
        ];

        $r = $es->delete($params);
        dump($r);die;

//        $es = \Elasticsearch\ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();
//        $params = [
//            'index' => 'test_index',
//            'type' => 'test_type',
//            'id' => 100,
//            'body' => [
//                'doc' => ['id'=>100, 'title'=>'ES从入门到精通', 'author' => '张三1']
//            ]
//        ];
//        $r = $es->update($params);
//        dump($r);die;

//        $es = \Elasticsearch\ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();
//        $params = [
//            'index' => 'test_index',
//            'type' => 'test_type',
//            'id' => 100,
//            'body' => ['id'=>100, 'title'=>'PHP从入门到精通', 'author' => '张三']
//        ];
//        $r = $es->index($params);
//        dump($r);die;

//        $es = \Elasticsearch\ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();
//        $params = [
//            'index' => 'test_index'
//        ];
//        $r = $es->indices()->create($params);
//        dump($r);die;
//        halt(encrypt_password('123456'));
//        exit();
        return view();
    }
}
