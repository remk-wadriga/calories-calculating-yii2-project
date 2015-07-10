<?php

use yii\db\Schema;
use yii\db\Migration;

class m150710_090012_product_proteins_fats_carbohydrates extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `product` ADD COLUMN `protein` float DEFAULT NULL;
            ALTER TABLE `product` ADD COLUMN `fat` float DEFAULT NULL;
            ALTER TABLE `product` ADD COLUMN `carbohydrate` float DEFAULT NULL;
        ");
    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `product` DROP COLUMN `protein`;
            ALTER TABLE `product` DROP COLUMN `fat`;
            ALTER TABLE `product` DROP COLUMN `carbohydrate`;
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
