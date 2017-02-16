<?php
namespace Admin\Controller;
use Think\Controller;
require_once "CheckLoginController.class.php";

class LinkController extends \CheckLoginController {

    public function index(){
        //查询精选文章信息
        $mod = M("index_links");
        $res = $mod->select();
        $this->assign("msg", $res);
        $this->assignActive();
        $this->display("index");
    }

    public function edit($id) {
        $mod = M("index_links");
        $map["id"] = $id;
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        $this->display();
    }

    public function update() {
        $mod = M("index_links");
        $mod->create();
        if ($mod->save() !== false) {
            $this->success("友情链接修改成功", U("Link/index"));
        } else {
            $this->error("友情链接修改失败");
        }
    }

    public function assignActive() {
        $this->assign("active", array("","","","active","","","",""));
    }

}