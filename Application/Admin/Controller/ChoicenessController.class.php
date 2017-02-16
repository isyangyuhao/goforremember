<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class ChoicenessController extends \CheckLoginController {

    public function index(){
        //查询精选文章信息
        $mod = M("index_article");
        $map['is_delete'] = 0;
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //查询注销精选文章信息
        //查询精选文章信息
        $mod = M("index_article");
        $map2['is_delete'] = 1;
        $page2 = new \Think\MyPage($mod->where($map2)->count(), 10);
        foreach($map2 as $key=>$val) {
            $page2->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map2)->order('time desc')->limit($page2->firstRow. "," . $page2->listRows)->select();
        $page2->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("delete", $list);
        $this->assign("pageinfo2", $page2->show());
        $this->assignActive();
        $this->display("index");
    }

    public function add() {
        $this->assignActive();
        $this->display("add");
    }

    public function insert() {
        $mod = M("index_article");
        if (empty($_POST['title'])) {
            $this->error("标题不可以为空");
        }
        if (empty($_POST['description'])) {
            $this->error("概述不可以为空");
        }
        if (empty($_POST['content'])) {
            $this->error("内容不可以为空");
        }
        $mod->create();
        $mod->time = time();
        if ($mod->add()) {
            $this->success("精选文章添加成功", U("Choiceness/index"));
        } else {
            $this->error("精选文章添加失败");
        }
    }

    public function edit($id) {
        $mod = M("index_article");
        $map["id"] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        $this->display();
    }

    public function update() {
        $mod = M("index_article");
        $mod->create();
        if ($mod->save() !== false) {
            $this->success("精选文章修改成功", U("Choiceness/index"));
        } else {
            $this->error("精选文章修改失败");
        }
    }

    public function delete($id) {
        $mod = M("index_article");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 1;
        if ($mod->save() !== false) {
            $this->success("账号注销成功", U("Choiceness/index"));
        } else {
            $this->error("账号注销失败");
        }
    }

    public function recover($id) {
        $mod = M("index_article");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 0;
        if ($mod->save() !== false) {
            $this->success("账号恢复成功", U("Choiceness/index"));
        } else {
            $this->error("账号恢复失败");
        }
    }

    public function drop($id) {
        $mod = M("index_article");
        $map['id'] = $id;
        if ($mod->where($map)->delete()) {
            $this->success("账号彻底删除成功");
        } else {
            $this->error("账号彻底删除失败");
        }
    }

    public function search() {
        $search = $_POST['search'];
        //查询精选文章信息
        $mod = M("index_article");
        $map['is_delete'] = 0;
        $map['title'] = array("like", "%{$search}%");
        $map['_logic'] = "AND";
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //查询注销精选文章信息
        //查询精选文章信息
        $mod = M("index_article");
        $map2['is_delete'] = 1;
        $map2['title'] = array("like", "%{$search}%");
        $page2 = new \Think\MyPage($mod->where($map2)->count(), 10);
        foreach($map2 as $key=>$val) {
            $page2->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map2)->order('time desc')->limit($page2->firstRow. "," . $page2->listRows)->select();
        $page2->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("delete", $list);
        $this->assign("pageinfo2", $page2->show());
        $this->assignActive();
        $this->display("index");
    }

    public function assignActive() {
        $this->assign("active", array("","","active","","","","",""));
    }

}