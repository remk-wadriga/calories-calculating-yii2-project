<?php

use yii\db\Schema;
use yii\db\Migration;

class m150706_074922_week_stats extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `week_stats` (
              `id` bigint(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `start_date` date NOT NULL,
              `end_date` date NOT NULL,
              `weight` float NOT NULL,
              `calories` float NOT NULL,
              `average_weight` float NOT NULL,
              `average_calories` float NOT NULL,
              `body_weight` float DEFAULT NULL,
              `days_stats` text NOT NULL,
              PRIMARY KEY (`id`),
              KEY `week_stats_user_id` (`user_id`),
              CONSTRAINT `week_stats_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        echo "m150706_074922_week_stats cannot be reverted.\n";

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
