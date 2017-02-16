<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class UserController extends \CheckLoginController {
    public function index(){
        //查询用户信息
        $mod = M("user");
        $map['is_delete'] = 0;
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('regtime desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //统计用户信息
        $userNumber = $mod->count();  //用户数
        $manNumber = $mod->where('sex = 0')->count();  //男性用户数
        $womenNumber = $mod->where('sex = 1')->count();  //女性用户数
        $stutus1Number = $mod->where('status = 1')->count();  //状态1的用户数
        $stutus2Number = $mod->where('status = 2')->count();  //状态2的用户数
        $stutus3Number = $mod->where('status = 3')->count();  //状态3的用户数
        $tokenNumber = $mod->where('status = 0')->count();  //未激活用户数
        $deleteNumber = $mod->where('is_delete = 1')->count();  //注销用户数
        $this->assign("userNumber", $userNumber);
        $this->assign("manNumber", round(($manNumber / $userNumber * 100), 2) . '%');
        $this->assign("womenNumber", round(($womenNumber / $userNumber * 100), 2) . '%');
        $this->assign("status1Number", round(($stutus1Number / $userNumber * 100), 2) . '%');
        $this->assign("status2Number", round(($stutus2Number / $userNumber * 100), 2) . '%');
        $this->assign("status3Number", round(($stutus3Number / $userNumber * 100), 2) . '%');
        $this->assign("tokenNumber", $tokenNumber);
        $this->assign("deleteNumber", $deleteNumber);
        //注销用户信息
        $mod = M("user");
        $map2['is_delete'] = 1;
        $page2 = new \Think\MyPage($mod->where($map2)->count(), 10);
        foreach($map2 as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map2)->order('regtime desc')->limit($page2->firstRow. "," . $page2->listRows)->select();
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
        $mod = D("Home/User");
        if (!$mod->create()) {
            $this->error("用户添加失败!");
        }
        if ($mod->add()) {
            $this->success("用户添加成功!", U("User/Index"));
        } else {
            $this->error("用户添加失败!");
        }
    }

    public function edit($id) {
        $mod = M("user");
        $map['id'] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        $this->display("edit");
    }

    public function update() {
        $mod = M("User");
        $mod->create();
        if ($mod->save() !== false) {
            $this->success("用户信息修改成功", U("User/index"));
        } else {
            $this->error("用户信息修改失败");
        }
    }

    public function delete($id) {
        $mod = M("User");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 1;
        if ($mod->save() !== false) {
            $this->success("账号注销成功", U("User/index"));
        } else {
            $this->error("账号注销失败");
        }
    }

    public function recover($id) {
        $mod = M("User");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 0;
        if ($mod->save() !== false) {
            $this->success("账号恢复成功", U("User/index"));
        } else {
            $this->error("账号恢复失败");
        }
    }

    public function drop($id) {
        $mod = M("user");
        $map['id'] = $id;
        if ($mod->where($map)->delete()) {
            $this->success("账号彻底删除成功");
        } else {
            $this->error("账号彻底删除失败");
        }
    }

    public function search() {
        $search = $_POST['search'];
        //查询用户信息
        $mod = M("user");
        $map['id'] = $search;
        $map['username'] = array("like", "%{$search}%");
        $map['email'] = array("like", "%{$search}%");
        $map['_logic'] = 'OR';
        $where['_complex'] = $map;
        $where['is_delete'] = 0;
        $where['_logic'] = 'AND';
        $page = new \Think\MyPage($mod->where($where)->count(), 10);
        foreach($where as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($where)->order('regtime desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //统计用户信息
        $userNumber = $mod->count();  //用户数
        $manNumber = $mod->where('sex = 0')->count();  //男性用户数
        $womenNumber = $mod->where('sex = 1')->count();  //女性用户数
        $stutus1Number = $mod->where('status = 1')->count();  //状态1的用户数
        $stutus2Number = $mod->where('status = 2')->count();  //状态2的用户数
        $stutus3Number = $mod->where('status = 3')->count();  //状态3的用户数
        $tokenNumber = $mod->where('status = 0')->count();  //未激活用户数
        $deleteNumber = $mod->where('is_delete = 1')->count();  //注销用户数
        $this->assign("userNumber", $userNumber);
        $this->assign("manNumber", round(($manNumber / $userNumber * 100), 2) . '%');
        $this->assign("womenNumber", round(($womenNumber / $userNumber * 100), 2) . '%');
        $this->assign("status1Number", round(($stutus1Number / $userNumber * 100), 2) . '%');
        $this->assign("status2Number", round(($stutus2Number / $userNumber * 100), 2) . '%');
        $this->assign("status3Number", round(($stutus3Number / $userNumber * 100), 2) . '%');
        $this->assign("tokenNumber", $tokenNumber);
        $this->assign("deleteNumber", $deleteNumber);
        //注销用户信息
        $mod = M("user");
        $map2['id'] = $search;
        $map2['username'] = array("like", "%{$search}%");
        $map2['email'] = array("like", "%{$search}%");
        $map2['_logic'] = 'OR';
        $where2['_complex'] = $map2;
        $where2['is_delete'] = 1;
        $page2 = new \Think\MyPage($mod->where($where2)->count(), 10);
        foreach($where2 as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($where2)->order('regtime desc')->limit($page2->firstRow. "," . $page2->listRows)->select();
        $page2->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("delete", $list);
        $this->assign("pageinfo2", $page2->show());
        $this->assignActive();
        $this->display("search");
    }

    public function assignActive() {
        $this->assign("active", array("active","","","","","","",""));
    }
}