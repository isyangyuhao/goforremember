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

class ShopController extends \CheckLoginController {

    public function index(){

        //加载图片轮转
        $mod = M('shop_main');
        $res = $mod->select();
        $this->assign("photo", $res);

        //加载商品信息
        $mod = M('shop_goods');
        $res = $mod->limit(3)->select();
        $this->assign('goods', $res);

        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("index");
        } else {
            $this->display("index");
        }
    }

    public function assignActive() {
        $this->assign("active", array("", "", "", "", "active"));
    }

}