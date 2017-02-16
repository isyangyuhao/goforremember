<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/3/14
 * Time: 12:49
 */
namespace Home\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class PersonController extends \CheckLoginController {

    public function index(){
        //调取个人基本信息
        $mod = M("User");
        $map['id'] = $_SESSION['id'];
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        if ($res['sex'] == 0) {
            $this->assign("sex", "男");
        } else {
            $this->assign("sex", "女");
        }
        //调取用户最近的三条发帖记录
        $mod = M("speak");
        $map1['user_id'] = $_SESSION['id'];
        $res = $mod->where($map1)->order('time desc')->limit(3)->select();
        $this->assign("mySpeak", $res);

        //调取用户最近的三条收藏记录
        $mod = D('SpeakLikeView');
        $map2['user_id'] = $_SESSION['id'];
        $res = $mod->where($map2)->order('time desc')->limit(3)->select();
        $this->assign("myLike", $res);
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("index");
        } else {
            $this->display("index");
        }
    }

    public function edit() {
        $mod = M("User");
        $map['id'] = $_SESSION['id'];
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("edit");
        } else {
            $this->display("edit");
        }
    }

    public function update() {
        //更新用户数据
        $mod = M("User");
        $mod->create();
        //$mod->icon = $icon;
        if (!empty($_POST['password'])) {
            $mod->password = md5($_POST['password']);
        } else {
            $mod->password = $_SESSION['password'];
        }
        if (empty($_POST['email'])) {
            $this->error("邮箱不可以更改为空!");
        }
        if ($mod->save() !== false) {
            $this->success("设置成功", U("Person/index"));
            redirect(U("Person/index"), 0, '账号信息设置成功');
        } else {
            $this->error("账号信息设置失败<br>" . $mod->getError());
        }

    }

    public function upload() {
        //头像上传处理
        $upload = new \Think\Upload();  //实例化上传类
        $upload->autoSub = false;  //上传文件不自动生成子文件夹
        $upload->replace = true;  //允许同名文件覆盖
        $upload->saveExt = "jpg";  //设置文件后缀
        $upload->maxSize = 3145728;  //设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');  //设置附件上传类型
        $upload->rootPath  = "/Public/upload/";  //设置附件上传根目录
        $upload->saveName = "icon_" . $_SESSION['id'];
        $info = $upload->uploadOne($_FILES['icon']);
        $icon = $info['savename'];
        //检测用户是否上传过头像
        if (empty($icon)) {
            $icon = "default.jpg";
        }
        $mod = M("User");
        $mod->create();
        $mod->icon = $icon;
        if ($mod->save() !== false) {
            $this->success("头像上传成功", U("Person/index"));
        } else {
            echo $upload->getError();
            $this->error("头像上传失败");
        }
    }

    public function delete() {
        $mod = M("User");
        $mod->is_delete = 1;
        $map['id'] = $_SESSION['id'];
        $res = $mod->where($map)->save();
        if ($res) {
            $this->success("账号注销成功", U("Index/exitLogin"));
        } else {
            $this->error("账号注销失败!" . $mod->getError());
        }
    }

    public function write() {
        //显示最近的五条日记
        $mod = M("person_write");
        $map['user_id'] = $_SESSION['id'];
        $res = $mod->where($map)->order("time desc")->limit(5)->select();
        $this->assign("msg", $res);
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("write");
        } else {
            $this->display("write");
        }
    }

    public function like() {
        //分页调取我的收藏贴
        $mod = D('SpeakLikeView');
        $map['user_id'] = $_SESSION['id'];
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key]   =   urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("list", $list);
        $this->assign("pageinfo", $page->show());
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("like");
        } else {
            $this->display("like");
        }
    }

    public function notLike($speak_id) {
        $mod = M('speak_like');
        $map['speak_id'] = $speak_id;
        $mod->where($map)->delete();
        $this->success("取消收藏成功!", U("Person/like"));
    }

    public function mySpeak() {
        //分页调取我的贴子
        $mod = M('Speak');
        $map['user_id'] = $_SESSION['id'];
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach($map as $key=>$val) {
            $page->parameter[$key]   =   urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("list", $list);
        $this->assign("pageinfo", $page->show());
        if ($_SESSION['sex'] == 1) {
            $this->theme('women')->display("mySpeak");
        } else {
            $this->display("mySpeak");
        }
    }

    public function add() {
        $mod = M("person_write");
        $mod->create();

        //对用户的日记进行加密存储
        $key = md5($_SESSION['password'].time());
        $str = $_POST['content'];
        $token = $this->encrypt($str, "E", $key);
        $mod->content = $token;

        $mod->time = time();
        $mod->user_id = $_SESSION['id'];

        $map['user_id'] = $_SESSION['id'];
        if ($res = $mod->where($map)->select()) {
            foreach ($res as $key => $value) {
                if (time() < $value['time'] + 24 * 3600 ) {
                    $this->error("您写日记速度频繁，请您明天再来写吧 ~");
                }
            }
        }

        if ($mod->add()) {
            redirect(U("Person/write"), 0, "提交成功");
        } else {
            $this->error("提交失败");
        }
    }

    public function more($id) {
        $mod = M("person_write");
        $map['id'] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        //对日记进行解密
        $key = md5($_SESSION['password'].$res['time']);
        $token = $this->encrypt($res['content'], "D", $key);
        $this->assign("content", $token);
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("more");
        } else {
            $this->display("more");
        }
    }

    //加密函数
    function encrypt($string, $operation, $key = ''){
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D'?base64_decode($string):substr(md5($string.$key), 0, 8).$string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++){
            $rndkey[$i] = ord($key[$i%$key_length]);
            $box[$i] = $i;
        }
        for($j = $i = 0; $i < 256; $i++){
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for($a = $j = $i = 0; $i < $string_length; $i++){
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if($operation == 'D'){
            if(substr($result, 0, 8) == substr(md5(substr($result, 8).$key), 0, 8)){
                return substr($result, 8);
            }else{
                return'';
            }
        }else{
            return str_replace('=', '', base64_encode($result));
        }
    }

}