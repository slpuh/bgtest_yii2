<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "transfers".
 *
 * @property int $id
 * @property int $user_id
 * @property string $amount
 * @property int $to_user_id
 *
 * @property Users $toUser
 * @property Users $user
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transfers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'to_user_id', 'amount'], 'required'],
            [['user_id', 'to_user_id'], 'integer'],
            [['amount'], 'number'],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Отправитель',
            'amount' => 'Сумма',
            'to_user_id' => 'Получатель',
        ];
    }

    public function currentBalanse()
    {
        $balance = Yii::$app->user->identity->balance;
        
        return $balance;
    }

    public function isUser($data)
    {
        $isUser = User::find()->where(['username' => $data])->one();
        
        return $isUser;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}