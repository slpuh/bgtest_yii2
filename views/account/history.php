<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'My Yii Application';
?>
<div class="site-index">

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [            
            ['attribute'=>'user_id',
                'value'=>'user.username'                                
            ],
            ['attribute'=>'to_user_id',                 
                'value'=>'toUser.username'                
            ],            
            ['attribute'=> 'amount' ,
                'headerOptions' => ['width' => '200'],                                
            ],                                              
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>