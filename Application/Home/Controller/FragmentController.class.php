<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/3/10
 * Time: 19:30
 */
namespace Home\Controller;
use SensitiveWordFilter;
use Think\Controller;
require_once "CheckLoginController.class.php";
require_once VENDOR_PATH . "SensitiveWordFilter.php";


class FragmentController extends \CheckLoginController {

    public function index(){

        $mod = D("FragmentView");
        $res = $mod->order("time desc")->limit(16)->select();
        $this->assign("msg", $res);

        $this->assignActivre();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("index");
        } else {
            $this->display("index");
        }
    }

    public function add() {
        $mod = M("fragment");
        $mod->create();
        $mod->user_id = $_SESSION['id'];
        $mod->time = time();

        //对接收来的信息进行敏感词过滤
        $content = $_POST['content'];
        if (empty($content)) {
            $this->error("内容不能为空!");
        }
        $filter = new SensitiveWordFilter(VENDOR_PATH . "filter_words.txt");
        $content = $filter->filter($content, 10);
        $mod->content = $content;

        //防止恶意刷屏,半小时内无法重复提交
        $map['user_id'] = $_SESSION['id'];
        if ($res = $mod->where($map)->select()) {
            foreach ($res as $key => $value) {
                if (time() < $value['time'] + 1800) {
                    $this->error("您操作的过于频繁,请您稍后再试~");
                }
            }
        }

        if ($mod->add()) {
            redirect(U("Fragment/index"), 0, "提交成功");
        } else {
            $this->error("提交失败");
        }

    }

    public function assignActivre() {
        $this->assign("active", array("", "", "active", ""));
    }


}