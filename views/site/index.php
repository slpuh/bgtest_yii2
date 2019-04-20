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
            'username',
            ['attribute'=>'balance',
                'headerOptions' => ['width' => '200']                
            ],                        
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
