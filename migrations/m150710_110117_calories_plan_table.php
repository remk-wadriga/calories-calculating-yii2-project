<?php

use yii\db\Schema;
use yii\db\Migration;

class m150710_110117_calories_plan_table extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `calories_plan` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
              `user_id` bigint(11) NOT NULL,
              `calories` int(5) NOT NULL,
              `date` date NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        $this->execute("
            DROP TABLE `calories_plan`;
        ");
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
