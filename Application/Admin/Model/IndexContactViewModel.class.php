<?php
namespace Admin\Model;
use Think\Model\ViewModel;

class IndexContactViewModel extends ViewModel {

    public $viewFields = array(
        'user'=>array('username'),
        'index_contact'=>array( 'id', 'content', 'time', 'user_id', 'is_delete', '_on'=>'user.id = index_contact
        .user_id'),
    );

}