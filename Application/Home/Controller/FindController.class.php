<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/3/10
 * Time: 20:56
 */
namespace Home\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class FindController extends \CheckLoginController {

    public static $find_id;

    public function index() {
        $mod = M("find");
        $map1['status'] = 0;
        $map2['status'] = 1;
        $res_normal = $mod->where($map1)->limit(3)->select();
        $res_hot = $mod->where($map2)->limit(2)->select();
        $this->assign("hot", $res_hot);
        $this->assign("normal", $res_normal);
        $this->assign("all", $mod->select());
        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("index");
        } else {
            $this->display("index");
        }
    }

    public function special() {
        $mod = M("find_article");
        self::$find_id = $_GET['id'];
        $map['find_id'] = self::$find_id;
        $page = new \Think\MyPage($mod->where($map)->count(), 10);
        foreach ($map as $key => $val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->limit($page->firstRow . "," . $page->listRows)->select();
        $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("list", $list);
        $this->assign("pageinfo", $page->show());
        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("special");
        } else {
            $this->display("special");
        }
    }

    public function more($id) {
        $mod = M("simple");
        $map['id'] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("more");
        } else {
            $this->display("more");
        }
    }

    //图说那年板块
    public function photo() {

        $mod = M("find_photo");
        $res = $mod->select();
        $this->assign("photo", $res);

        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("photo");
        } else {
            $this->display("photo");
        }
    }

    public function music() {

        $mod = M("find_music");
        $res = $mod->select();
        $this->assign("music", $res);

        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("music");
        } else {
            $this->display("music");
        }
    }

    public function write() {

        $mod = M("person_write");
        $map['user_id'] = $_SESSION['id'];
        $res = $mod->where($map)->select();
        $random_num = rand(0, count($res)-1);
        $random_res = $res[$random_num];
        if (empty($random_res)) {
            $this->success("您暂时还没有写过日期，去写下昨天吧~", U("Person/write"));
        } else {
            //对日记进行解密
            $key = md5($_SESSION['password'] . $random_res['time']);
            $token = $this->encrypt($random_res['content'], "D", $key);
            $this->assign("random_res", $random_res);
            $this->assign("content", $token);
            $this->assign("time", date("y-m-d h:s:i", $random_res['time']));

            $this->assignActive();
            if ($_SESSION['sex'] == 1) {
                $this->theme("women")->display("write");
            } else {
                $this->display("write");
            }
        }
    }

    public function movie() {

        $mod = M("find_movie");
        $res = $mod->limit(3)->select();
        $this->assign("msg", $res);

        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("movie");
        } else {
            $this->display("movie");
        }
    }

    public function contribute() {
        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("contribute");
        } else {
            $this->display("contribute");
        }
    }

    public function insert() {
        $mod = M("find_contribute");
        $mod->create();
        if (empty($_POST['content'])) {
            $this->error("投稿内容不能为空");
        }
        $mod->time = time();
        $mod->user_id = $_SESSION['id'];
        if ($mod->add()) {
            $this->success("恭喜您投稿成功!我们会进行后台审核，审核通过后会为您发表", U("Find/index"));
        } else {
            $this->error("投稿失败，请重试");
        }
    }

    public function article() {

        $mod = M("simple");
        $map['is_delete'] = 0;
        $page = new \Think\MyPage($mod->where($map)->count(), 5);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("article", $list);
        $this->assign("pageinfo", $page->show());

        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("article");
        } else {
            $this->display("article");
        }
    }

    public function assignActive() {
        $this->assign("active", array("", "active", "", ""));
    }

    //加密函数
    function encrypt($string, $operation, $key = '') {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }

    }
}