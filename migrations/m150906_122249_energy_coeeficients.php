<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_122249_energy_coeeficients extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `energy_coefficient` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `type` enum('WEIGHT','AGE','SEX') NOT NULL DEFAULT 'WEIGHT',
              `value` varchar(7) NOT NULL,
              `coefficient` float NOT NULL DEFAULT '1',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }

    public function down()
    {
        echo "m150906_122249_energy_coeeficients cannot be reverted.\n";

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
