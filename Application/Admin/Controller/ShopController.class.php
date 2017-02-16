<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class ShopController extends \CheckLoginController {

    public function index(){
        //查询轮播广告信息
        $mod = M("shop_main");
        $page = new \Think\MyPage($mod->count(), 10);
        $list = $mod->order('id asc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //查询推荐商家信息
        $mod = M("shop_goods");
        $page2 = new \Think\MyPage($mod->count(), 10);
        $list = $mod->order('id asc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page2->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("good", $list);
        $this->assign("pageinfo2", $page->show());
        $this->assignActive();
        $this->display("index");
    }

    public function add() {
        $this->assignActive();
        $this->display("add");
    }

    public function insert() {
        $mod = M("shop_main");
        $mod->create();
        $mod->time = time();
        if ($mod->add()) {
            $this->success("极简文章添加成功", U("Shop/index"));
        } else {
            $this->error("极简文章添加失败");
        }
    }

    public function edit($id) {
        $mod = M("shop_main");
        $map["id"] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        $this->display();
    }

    public function editGood($id) {
        $mod = M("shop_goods");
        $map["id"] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        $this->display();
    }

    public function update() {
        $mod = M("shop_main");
        $mod->create();
        if ($mod->save() !== false) {
            $this->success("轮播广告修改成功", U("Shop/index"));
        } else {
            $this->error("轮播广告修改失败");
        }
    }
    public function updateGood() {
        $mod = M("shop_goods");
        $mod->create();
        if ($mod->save() !== false) {
            $this->success("推荐商家广告修改成功", U("Shop/index"));
        } else {
            $this->error("推荐商家广告修改失败");
        }
    }



    public function assignActive() {
        $this->assign("active", array("","","","","","","","active","",""));
    }

}