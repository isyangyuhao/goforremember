<?php
namespace Home\Model;

use Think\Model;

class SpeakLikeModel extends Model {


    //自动完成
    protected $_auto = array (
        //array('time','time',1,'function'), // 对regtime字段在新增时写入当前时间戳
    );

    //验证注册信息是否合法
    protected $_validate = array(
        array('speak_id','','该帖子已收藏',0,'unique',1)
    );


}