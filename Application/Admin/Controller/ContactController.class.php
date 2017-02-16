<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class ContactController extends \CheckLoginController {

    public function index(){
        //未注销留言
        $mod = D("IndexContactView");
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
        //已注销留言
        $mod = D("IndexContactView");
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

    public function delete($id) {
        $mod = M("index_contact");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 1;
        if ($mod->save() !== false) {
            $this->success("留言注销成功", U("Contact/index"));
        } else {
            $this->error("留言注销失败");
        }
    }

    public function recover($id) {
        $mod = M("index_contact");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 0;
        if ($mod->save() !== false) {
            $this->success("留言恢复成功", U("Contact/index"));
        } else {
            $this->error("留言恢复失败");
        }
    }

    public function drop($id) {
        $mod = M("index_contact");
        $map['id'] = $id;
        if ($mod->where($map)->delete()) {
            $this->success("留言删除成功", U("Contact/index"));
        }
    }

    public function search() {
        $search = $_POST['search'];
        //未注销留言
        $mod = D("IndexContactView");
        $where['is_delete'] = 0;
        $where['_string'] = "(content like '%{$search}%') OR (username like '%{$search}%')";
        $page = new \Think\MyPage($mod->where($where)->count(), 10);
        foreach($where as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($where)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //已注销留言
        $mod = D("IndexContactView");
        $where2['is_delete'] = 1;
        $where2['_string'] = "(content like '%{$search}%') OR (username like '%{$search}%')";
        $page2 = new \Think\MyPage($mod->where($where2)->count(), 10);
        foreach($where2 as $key=>$val) {
            $page2->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($where2)->order('time desc')->limit($page2->firstRow. "," . $page2->listRows)->select();
        $page2->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("delete", $list);
        $this->assign("pageinfo2", $page2->show());

        $this->assignActive();
        $this->display("search");
    }

    public function assignActive() {
        $this->assign("active", array("","active","","","","","",""));
    }
}