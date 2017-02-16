<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class AdvertisementController extends \CheckLoginController {
    public function index(){
        //加载主页广告
        $index_avt = M("index_advertisement");
        $index_result = $index_avt->find();
        $this->assign("index_msg", $index_result);

        //加载论坛广告
        $speak_avt = M("speak_advertisement");
        $speak_result = $speak_avt->find();
        $this->assign("speak_msg", $speak_result);

        $this->assignActive();
    	$this->display("index");
    }

    public function editIndex() {
        $index_avt = M("index_advertisement");
        $index_avt->create();
        $index_avt->content = ltrim($_POST['content']);
        if ($index_avt->save() !== false) {
            $this->success("主页广告修改成功", U("Advertisement/index"));
        } else {
            $this->error("主页广告修改失败");
        }
    }

    public function editSpeak() {
        $speak_avt = M("speak_advertisement");
        $speak_avt->create();
        $speak_avt->content = ltrim($_POST['content']);
        if ($speak_avt->save() !== false) {
            $this->success("论坛广告修改成功", U("Advertisement/index"));
        } else {
            $this->error("论坛广告修改失败");
        }
    }

    public function assignActive() {
        $this->assign("active", array("","","","","","","","","active"));
    }
}