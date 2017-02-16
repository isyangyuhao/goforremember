<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/3/10
 * Time: 21:42
 */
namespace Home\Controller;
use Think\Controller;
use SensitiveWordFilter;
require_once "CheckLoginController.class.php";
require_once VENDOR_PATH . "SensitiveWordFilter.php";

class SpeakController extends \CheckLoginController {

    public function index(){

        //调取精品帖子
        $mod = D("SpeakView");
        $map['status'] = 1;
        $res = $mod->where($map)->select();
        $this->assign("perfect", $res);

        //调取普通帖子并分页显示
        $mod = D("SpeakView");
        $map['status'] = 0;
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("normal", $list);
        $this->assign("pageinfo", $page->show());

        //加载论坛广告
        $avt = M("speak_advertisement");
        $avt_map['status'] = 1;
        $avt_result = $avt->where($avt_map)->find();
        if (empty($avt_result) == false) {
            $this->assign("avt_msg", $avt_result);
            $this->assign("avt_status", 1);
        } else {
            $this->assign("avt_status", 0);
        }

        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("index");
        } else {
            $this->display("index");
        }
    }

    public function add() {
        $mod = M("speak");
        $mod->create();
        $mod->user_id = $_SESSION['id'];
        $mod->time = time();
        //对用户输入的敏感词进行过滤
        $title = $_POST['title'];
        if (empty($title)){
            $this->error("标题不可以为空!");
        }
        $filter = new SensitiveWordFilter(VENDOR_PATH . "filter_words.txt");
        $title = $filter->filter($title, 10);
        $mod->title = $title;
        $content = $_POST['content'];
        if (empty($content)) {
            $this->error("内容不可以为空!");
        }
        $content = $filter->filter($content, 10);
        $mod->content = $content;
        //防止恶意刷屏,半小时内无法提交
        $map['user_id'] = $_SESSION['id'];
        if ($res = $mod->where($map)->select()) {
            foreach ($res as $key => $value) {
                if (time() < $value['time'] + 1800) {
                    $this->error("您操作的过于频繁,请您稍后再试~");
                }
            }
        }
        if ($mod->add()) {
            redirect(U("Speak/index"), 0, "提交成功");
        } else {
            $this->error("提交失败");
        }
        //print_r($_POST);
    }

    public function more() {

        //调取帖子信息
        $mod = D("SpeakView");
        $map['id'] = $_GET['id'];
        $speak = $mod->where($map)->find();
        $this->assign("msg", $speak);

        //调取回帖信息并分页
        $mod = D('SpeakReplyView');
        $map1['speak_id'] = $_GET['id'];
        $page = new \Think\MyPage($mod->where($map1)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key]   =   urlencode($val);
        }
        $list = $mod->where($map1)->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("list", $list);
        $this->assign("pageinfo", $page->show());
        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("more");
        } else {
            $this->display("more");
        }

        //调取回帖信息
/*        $mod = D('SpeakReplyView');
        $map1['speak_id'] = $_GET['id'];
        $reply = $mod->where($map1)->select();
        $this->assign('reply', $reply);
        $this->display("more");*/
    }

    public function reply() {
        $mod = M("speak_reply");
        $mod->create();
        $mod->time = time();
        $username = $_POST['username'];
        $findName = M('user');
        $map['username'] = $username;
        $res = $findName->where($map)->find();
        $user_id = $res['id'];
        $mod->user_id = $user_id;
        $content = $_POST['content'];
        if (empty($content)) {
            $this->error("回帖内容不能为空!");
        }
        $filter = new SensitiveWordFilter(VENDOR_PATH . "filter_words.txt");
        $content = $filter->filter($content, 10);
        $mod->content = $content;
        if ($mod->add()) {
            redirect(U("Speak/more?id={$_POST['speak_id']}"), 0, "提交成功");
        } else {
            $this->error("提交失败");
        }
    }

    public function setLike($speak_id) {
        $mod = M('speak_like');
        $mod->create();
        $mod->time = time();
        $mod->user_id = $_SESSION['id'];
        $mod->speak_id = $speak_id;

        //判断是否已被收藏
        $map['user_id'] = $_SESSION['id'];
        $map['speak_id'] = $speak_id;
        $map['_logic'] = "AND";
        if ($mod->where($map)->find()) {
            $this->error("您已收藏过本帖,无需再次收藏!");
        }

        if ($mod->add()) {
            $this->success("收藏成功!", U("Speak/index"));
        } else {
            $this->error("收藏失败!");
        }
    }

    public function assignActive() {
        $this->assign("active", array("", "", "", "active"));
    }

}