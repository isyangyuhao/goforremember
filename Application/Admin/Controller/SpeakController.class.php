<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class SpeakController extends \CheckLoginController {
    public function index(){
        //查询用户信息
        $mod = D("Home/SpeakView");
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
        //注销用户信息
        $mod = D("Home/SpeakView");
        $map2['is_delete'] = 1;
        $page2 = new \Think\MyPage($mod->where($map2)->count(), 10);
        foreach($map2 as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
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
        $mod = M("speak");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 1;
        if ($mod->save() !== false) {
            $this->success("帖子注销成功", U("Speak/index"));
        } else {
            $this->error("帖子注销失败");
        }
    }

    public function recover($id) {
        $mod = M("speak");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_delete = 0;
        if ($mod->save() !== false) {
            $this->success("帖子恢复成功", U("Speak/index"));
        } else {
            $this->error("帖子恢复失败");
        }
    }

    public function drop($id) {
        $mod = M("speak");
        $map['id'] = $id;
        if ($mod->where($map)->delete()) {
            $this->success("帖子彻底删除成功");
        } else {
            $this->error("帖子彻底删除失败");
        }
    }

    public function set($id) {
        $mod = M("speak");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->status = 1;
        if ($mod->save() !== false) {
            $this->success("帖子加精成功", U("Speak/index"));
        } else {
            $this->error("帖子加精失败");
        }
    }

    public function cancel($id) {
        $mod = M("speak");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->status = 0;
        if ($mod->save() !== false) {
            $this->success("取消精品成功", U("Speak/index"));
        } else {
            $this->error("取消精品失败");
        }
    }

    public function open($id) {
        $mod = M("speak");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_reply = 1;
        if ($mod->save() !== false) {
            $this->success("开启评论成功", U("Speak/index"));
        } else {
            $this->error("开启评论失败");
        }
    }

    public function close($id) {
        $mod = M("speak");
        $map['id'] = $id;
        $mod->where($map)->find();
        $mod->create();
        $mod->is_reply = 0;
        if ($mod->save() !== false) {
            $this->success("禁止评论成功", U("Speak/index"));
        } else {
            $this->error("禁止评论失败");
        }
    }

    public function more($id) {
        $mod = D("Home/SpeakReplyView");
        $map['speak_id'] = $id;
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        $this->assignActive();
        $this->display("more");
    }

    public function deleteReply($id) {
        $mod = M("speak_reply");
        $map['time'] = $id;
        if ($mod->where($map)->delete()) {
            $this->success("帖子彻底删除成功");
        } else {
            $this->error("帖子彻底删除失败");
        }
    }

    public function search() {
        $search = $_POST['search'];
        //查询用户信息
        $mod = D("Home/SpeakView");
        $map['title'] = array("like", "%{$search}%");
        $map['username'] = array("like", "%{$search}%");
        $map['_logic'] = 'OR';
        $where['_complex'] = $map;
        $where['is_delete'] = 0;
        $where['_logic'] = 'AND';
        $page = new \Think\MyPage($mod->where($where)->count(), 10);
        foreach($where as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($where)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        //注销用户信息
        $mod = D("Home/SpeakView");
        $map2['title'] = array("like", "%{$search}%");
        $map2['username'] = array("like", "%{$search}%");
        $map2['_logic'] = 'OR';
        $where2['_complex'] = $map2;
        $where2['is_delete'] = 1;
        $page2 = new \Think\MyPage($mod->where($where2)->count(), 10);
        foreach($where2 as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
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
        $this->assign("active", array("","","","","","","active",""));
    }
}