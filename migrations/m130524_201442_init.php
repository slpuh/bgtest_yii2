<?php

use yii\db\Migration;
use app\models\User;

class m130524_201442_init extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(20)->notNull()->unique(),                       
            'balance' => $this->decimal(7,2)->defaultValue(0.00),            
                ], $tableOptions);

                
                $this->batchInsert('{{%users}}', ['username'],[]); 
                
                $username = [];
                for($i = 0; $i < 100; $i++) {
                    $faker = Faker\Factory::create();
                    $model = new User();
                    $model->username = $faker->unique()->firstName;
                    $model->balance = $faker->randomFloat(2, -1000, 2000);
                    $model->save();
                }
       
    }

    public function down() {
        $this->dropTable('{{%users}}');
    }

}
