<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_103205_trainings extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `training_category` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
            CREATE TABLE `training` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `category_id` int(11) NOT NULL,
              `name` varchar(255) NOT NULL,
              `calories` float NOT NULL,
              `description` text,
              PRIMARY KEY (`id`),
              KEY `training_category_id` (`category_id`),
              CONSTRAINT `training_category_id` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        echo "m150906_103205_trainings cannot be reverted.\n";

        return false;
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
