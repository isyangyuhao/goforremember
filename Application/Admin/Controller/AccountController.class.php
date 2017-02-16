<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class AccountController extends \CheckLoginController {

    public function index(){
        $mod = M("admin");
        $page = new \Think\MyPage($mod->count(), 10);
        $list = $mod->order('id asc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("msg", $list);
        $this->assign("pageinfo", $page->show());
        $this->assignActive();
        $this->display("index");
    }

    public function add() {
        $this->assignActive();
        $this->display("add");
    }

    public function insert() {
        $mod = M("admin");
        $mod->create();
        $mod->password = md5($_POST['password']);
        if ($mod->add()) {
            $this->success("管理员账号添加成功", U("Account/index"));
        } else {
            $this->error("管理员账号添加失败");
        }
    }

    public function drop($id) {
        $mod = M("admin");
        $map['id'] = $id;
        if ($mod->where($map)->delete()) {
            $this->success("管理员删除成功", U("Account/index"));
        } else {
            $this->error("管理员删除失败");
        }
    }

    public function assignActive() {
        $this->assign("active", array("","","","","","","","","","","active"));
    }

}