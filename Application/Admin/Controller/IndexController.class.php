<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
        //注册返回普通用户登录界面入口
        $this->assign("normalUrl", U("Home/Index/userLogin"));
    	$this->display("index");
    }

    public function login() {
        $mod = M("admin");
        $name = $_POST['name'];
        $password = md5($_POST['password']);
        $map['name'] = $name;
        $map['password'] = $password;
        $map['_logic'] = "AND";
        if ($mod->where($map)->find()) {
            $_SESSION['admin'] = $name;
            $this->success("后台管理登陆成功", U("User/index"));
        } else {
            $this->error("账号或密码输入有误，请重新输入!");
        }
    }

    public function back() {
        session_unset();
        session_destroy();
        redirect(U("Index/index"), 0, '');
    }

}