<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $rememberMe = false;    

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username required
            [['username'], 'required'], 
            [['username'], 'string', 'max' => 20],                       
            ['username', 'validateUsername'],                        
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername()
    {
        if (!$this->getUser()) {
            
                return true;                                                         
            } 
        
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {         
        if ($this->validate() && $this->getUser()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe);
        } else if ($this->validate() && $this->validateUsername()) {            
            $newUser = new User();                
            $newUser->username = $this->username;                                 
            $newUser->save(false);
            return Yii::$app->user->login($newUser, $this->rememberMe);
        }               
        return false;
    }
    

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);            
        }
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Пользователь',           
        ];
    }
}
