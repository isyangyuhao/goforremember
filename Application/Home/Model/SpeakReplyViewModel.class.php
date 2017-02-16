<?php
namespace Home\Model;
use Think\Model\ViewModel;

class SpeakReplyViewModel extends ViewModel {

    public $viewFields = array(
        'user'=>array('username', 'icon'),
        'speak_reply'=>array('id', 'content','time','user_id', 'speak_id', '_on'=>'speak_reply.user_id=user.id'),
    );

}