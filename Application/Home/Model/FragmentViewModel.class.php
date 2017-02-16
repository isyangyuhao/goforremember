<?php
namespace Home\Model;
use Think\Model\ViewModel;

class FragmentViewModel extends ViewModel {

    public $viewFields = array(
        'fragment' => array('id','content','time', 'user_id', 'is_delete'),
        'user' => array( 'username', 'icon', '_on'=>'fragment.user_id = user.id'),
    );

}