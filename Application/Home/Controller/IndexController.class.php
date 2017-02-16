<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/3/9
 * Time: 15:00
 */
namespace Home\Controller;
use SaeMail;
use Swift_IoException;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Think\Controller;

require_once VENDOR_PATH . "/swiftmailer-master/lib/swift_required.php";

class IndexController extends Controller {

    public function index(){
        $this->assignActive();
        if (empty($_SESSION['username'])) {
            redirect(U("Index/userLogin"), 0, '亲爱的访客，请您先登录体验完整功能');
        } else {
            $this->getThatYearDay();
            $this->assign("status", $_SESSION['status']);
            $this->assign("info", $_SESSION);
            //加载首页文章
            $mod = M("index_article");
            $map['is_delete'] = 0;
            $res = $mod->where($map)->select();
            $this->assign("article", $res);
            //加载首页友情链接
            $mod = M("index_links");
            $map['is_delete'] = 0;
            $res = $mod->where($map)->select();
            $this->assign("links", $res);
            //根据日期加载不同属性颜色图片
            $mod = M("index_photo");
            $week = date("w");
            $map1['status'] = $week;
            $res = $mod->where($map1)->find();
            $this->assign("photo", $res);
            //注册后台管理入口
            $this->assign("adminUrl", U("Admin/Index/index"));
            //加载主页广告
            $avt = M("index_advertisement");
            $avt_map['status'] = 1;
            $avt_result = $avt->where($avt_map)->find();
            if (empty($avt_result) == false) {
                $this->assign("avt_msg", $avt_result);
                $this->assign("avt_status", 1);
            } else {
                $this->assign("avt_status", 0);
            }
        }
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("index");
        } else {
            $this->display("index");
        }
    }

    public function userLogin() {
        $this->display("userLogin");
    }

    public function assignActive() {
        $this->assign("active", array("active", "", "", ""));
    }

    public function register() {
        $act = $_GET['act'];
        $mod = D('User');
        if (!$mod->create()) {
            $this->error($mod->getError());
        } else {
/*            //使用qq邮箱发送邮件
            //配置邮件服务器，得到传输对象
            $transport = Swift_SmtpTransport::newInstance('smtp.qq.com',25);
            //设置登陆帐号和密码
            $transport->setUsername('1101632336@qq.com');
            $transport->setPassword("******************");
            //得到发送邮件对象Swift_Mailer对象
            $mailer=Swift_Mailer::newInstance($transport);
            //得到邮件信息对象
            $message=Swift_Message::newInstance();
            //设置管理员的信息
            $message->setFrom(array('1101632336@qq.com'=>'那年管理员'));
            //$message->setReturnPath("1101632336@qq.com");
            //将邮件发给谁
            $message->setTo(array($_POST['email']=>'user'));
            //设置邮件主题
            $message->setSubject('激活邮件');*/

            $token = $mod->getToken();
            //$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?act=active&token={$token}";
            $url="http://".$_SERVER['HTTP_HOST'] . __CONTROLLER__ . "/activate" ."?token={$token}";
            $urlencode = urlencode($url);
            $username = $_POST['username'];
            $str=<<<EOF
		亲爱的{$username}您好~！感谢您注册那年
		请点击此链接激活帐号即可登陆！
		{$url}
		如果点此链接无反映，可以将其复制到浏览器中来执行。
EOF;
/*            $message->setBody("{$str}",'text/html','utf-8');
            try{
                if($mailer->send($message)){
                }else{
                    $this->error("注册失败");
                }
            }catch(Swift_IoException $e){
                echo '邮件发送错误'.$e->getMessage();
            }*/

            $mail = new SaeMail();
            $ret = $mail->quickSend($_POST['email'], "那年激活账号", $str, "goforremember@sina.com", "goforremember233");
            //发送失败时输出错误码和错误信息
            if ($ret === false) {
                var_dump($mail->errno(), $mail->errmsg());
                $this->error("邮件发送失败!");
            }

        }
        if ($mod->add()) {
            $this->success("用户注册成功~ 请到您的邮箱中激活您的账户!", U("Index/userLogin"));
        } else {
            $this->error("用户注册失败!");
        }
    }

    //激活账号并登录
    public function activate() {
        $token = $_GET['token'];
        $mod = M("User");
        //$now = time();
        $map['token'] = $token;
        $map['status'] = 0;
        $res = $mod->where($map)->find();
        /*if ($now > $res["token_exptime"]) {
            $map['id'] = $res['id'];
        $mod->delete($res['id']+0);
            $this->error("密钥已过期，请重新注册账户!", U("Index/userLogin"));
        } else {*/
            if ($res["age"] > 40 && $res["age"] < 60) {
                $status = 2;
            } else if ($res['age'] >= 60) {
                $status = 3;
            } else {
                $status = 1;
            }
            $mod->status = $status;
            $map['token'] = $token;
            $mod->where($map)->save();
            $_SESSION['id'] = $res['id'];
            $_SESSION['username'] = $res['username'];
            $_SESSION['email'] = $res['email'];
            $_SESSION['sex'] = $res['sex'];
            $_SESSION['age'] = $res['age'];
            $_SESSION['status'] = $res['status'];
            $_SESSION['password'] = $res['password'];
            $this->success("恭喜您，账号激活成功", U("Index/index"));

    }
    //}

    public function login() {
        $mod = M("User");
        $name = $_POST['name'];
        $password = md5($_POST['password']);
        $map['username'] = $name;
        $map['password'] = $password;
        $map['_logic'] = 'AND';
        $res = $mod->where($map)->find();
        //print_r($res);
        if ($res) {
            if ($res['status'] == 0) {
                $this->error("该账号尚未激活，请先激活账号!");
            } else if ($res['is_delete'] == 1) {
                $this->error("该账号已被注销，有疑问请联系管理员!");
            } else {
                $_SESSION['id'] = $res['id'];
                $_SESSION['username'] = $res['username'];
                $_SESSION['email'] = $res['email'];
                $_SESSION['sex'] = $res['sex'];
                $_SESSION['age'] = $res['age'];
                $_SESSION['status'] = $res['status'];
                $_SESSION['password'] = $res['password'];
                redirect(U("Index/index"), 0, '登陆成功!');
            }
        } else {
            $this->error("登陆失败，请检查用户账号或密码是否输入有误");
        }
    }

    public function exitLogin() {
        session_unset();
        session_destroy();
        redirect(U("Index/userLogin"), 0, '退出登录中...');
    }

    public function contact() {
        $mod = M("index_contact");
        $mod->create();
        $mod->time = time();
        //同一个用户一天只能发送一条留言
        $map['user_id'] = $_SESSION['id'];
        if ($res = $mod->where($map)->select()) {
            foreach ($res as $key => $value) {
               if (time() < $value['time'] + 24*3600) {
                   $this->error("您的操作过于频繁，请您一天后再给我们留言 ~ ");
               }
            }
        }
        if ($mod->add()) {
            $this->success("留言成功 ~", U("Index/index"));
        } else {
            $this->error("留言失败");
        }
    }

    public function more($id) {
        $mod = M("index_article");
        $map['id'] = $id;
        $map['is_delete'] = 0;
        $map['_logic'] = "AND";
        $res = $mod->where($map)->find();
        $this->assign("msg", $res);
        $this->assignActive();
        if ($_SESSION['sex'] == 1) {
            $this->theme("women")->display("more");
        } else {
            $this->display("more");
        }
    }

    //获取历史上的今天API
    public function getThatYearDay() {
        $link = "http://api.juheapi.com/japi/toh";
        $version = "1.0";
        $month = date("m");
        $day = date("d");
        $key = "85546571e1faf22ef6fbfb317fe9a6b9";
        $api = $link . "?v=" . $version . "&month=" . $month . "&day=". $day . "&key=" . $key;
        $handle = fopen($api, "rb");
        $content = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $res = json_decode($content);
        $res = (array) $res;
        $res = $res['result'];
        $news = array();
        foreach ($res as $key => $val) {
            $res[$key] = (array) $res[$key];
            $news[$key] = $res[$key]['des'];
        }
        $this->assign("news", $news);
    }

}