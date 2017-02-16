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

class SimpleController extends \CheckLoginController {

    public function index(){
        $mod = M("simple");
        $map['is_delete'] = 0;
        $page = new \Think\MyPage($mod->where($map)->count(), 5);
        foreach($map as $key=>$val) {
            $page->parameter[$key] = urlencode($val);
        }
        $list = $mod->where($map)->order('time desc')->limit($page->firstRow. "," . $page->listRows)->select();
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%
        %END%');
        $this->assign("list", $list);
        $this->assign("pageinfo", $page->show());

        $this->display("index");

    }


}