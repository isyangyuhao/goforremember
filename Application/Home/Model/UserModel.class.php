<?php
namespace Home\Model;

use Think\Model;

class UserModel extends Model {

    //字段定义
    protected $fields = array('id', 'username', 'password', 'email', 'sex',
        'age', 'description', 'phone', 'address', 'regtime', 'token',
        'token_exptime', 'status', 'is_delete', 'icon', 'tell'
    );

    //自动完成
    protected $_auto = array (
        array('password','md5',1,'function') , // 对password/password_too字段在新增时使md5函数处理
        array('repassword', 'md5', 1, 'function'),
        array('regtime','time',1,'function'), // 对regtime字段在新增时写入当前时间戳
        array('token','getToken',1,'callback'), // 对token字段在新增时回调getToken方法
        array('token_exptime','getTokenExptime',1,'callback') // 对token_exptime字段在新增时回调getTokenExptime方法
    );

    //验证注册信息是否合法
    protected $_validate = array(
        array('username','require','用户名不能为空'),
        array('password','require','密码不能为空'),
        array('repassword','require','确认密码不能为空'),
        array('email','require','邮箱不能为空'),
        array('username','require','用户名不能为空'),
        array('username','','用户名已存在',0,'unique',1),
        array('sex',array(0,1),'sex的范围不正确！',2,'in'),
        array('repassword','password','两次输入密码不一致',0,'confirm')
    );

    //获取激活密钥
    public function getToken() {
        return md5($_POST['username'].$_POST['password'].time());
    }

    //获取密钥过期时间
    public function getTokenExptime() {
        return time() + 24 * 3600;
    }

}