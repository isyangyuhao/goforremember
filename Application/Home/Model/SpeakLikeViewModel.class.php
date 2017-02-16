<?php
namespace Home\Model;
use Think\Model\ViewModel;

class SpeakLikeViewModel extends ViewModel {

    public $viewFields = array(
        'speak'=>array('id', 'content', 'title'),
        'speak_like'=>array( 'speak_id', 'user_id', 'time', '_on'=>'speak_like.speak_id=speak.id'),
    );

}