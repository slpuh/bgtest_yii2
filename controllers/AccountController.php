<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Transfer;
use app\models\SearchTransfer;

class AccountController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'rules' => [
                    [                        
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],            
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()    {       
        
        return $this->render('index');
        }    
    
    public function actionTransfers()
    {           

        $model = new Transfer();        

        if(Yii::$app->request->isPost) {
            $isUser = $model->isUser(Yii::$app->request->post()['User']['username']);                
            $model->to_user_id  = $isUser['id']; 
            if (!$isUser ) {
                Yii::$app->session->setFlash('error', "Пользователь с таким именем не существует");
                return $this->refresh(); 
            }
        } 
            
        $model->user_id = Yii::$app->user->identity->id;                    
            
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
               
            if($model->user_id ===  $model->to_user_id) {
                Yii::$app->session->setFlash('error', "Вы не можете переводить сами себе");
                return $this->refresh();
            } else if (($model->user['balance'] - $model->amount) >= - 1000)  {                            
                $model->save();    
                $model->toUser['balance'] =  ($model->toUser['balance'] + $model->amount);
                $model->toUser->save();
    
                $model->user['balance'] =  ($model->user['balance'] - $model->amount);
                $model->user->save();
                
                Yii::$app->session->setFlash('success', "Перевод суммы "
                                             . $model->amount . " пользователю "
                                             . $model->toUser->username . " успешный!"); 
    
                return $this->refresh();         
                     
            } else {                
                Yii::$app->session->setFlash('error', "Баланс не может быть меньше -1000");
                return $this->refresh();
            }
                
        }         
              
        $balance = $model->currentBalanse(); 
        return $this->render('transfers', compact('model', 'balance'));
    }

    public function actionHistory()
    {
        $searchModel = new SearchTransfer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
         ]);
    }
       
}
