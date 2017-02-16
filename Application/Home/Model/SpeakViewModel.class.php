<?php
namespace Home\Model;
use Think\Model\ViewModel;

class SpeakViewModel extends ViewModel {

    public $viewFields = array(
        'speak' => array('id','title','content', 'user_id', 'time', 'status', 'is_reply', 'is_delete'),
        'user' => array('id'=>'uId', 'username', 'icon', '_on'=>'speak.user_id = user.id'),
    );

}