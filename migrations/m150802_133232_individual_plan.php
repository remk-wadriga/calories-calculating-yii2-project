<?php

use yii\db\Schema;
use yii\db\Migration;

class m150802_133232_individual_plan extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `plan` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `start_date` date NOT NULL,
              `end_date` date NOT NULL,
              `direction` enum('drying','weight','preservation') NOT NULL DEFAULT 'preservation',
              PRIMARY KEY (`id`),
              KEY `plan_user_id` (`user_id`),
              CONSTRAINT `plan_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `menu` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `plan_id` int(11) DEFAULT NULL,
              `name` varchar(255) NOT NULL,
              `description` text,
              PRIMARY KEY (`id`),
              KEY `menu_plan_id` (`plan_id`),
              CONSTRAINT `menu_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `menu_products` (
              `menu_id` int(11) NOT NULL,
              `product_id` int(11) NOT NULL,
              `weight` float NOT NULL,
              PRIMARY KEY (`menu_id`,`product_id`),
              KEY `menu_products_product_id` (`product_id`),
              CONSTRAINT `menu_products_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `menu_products_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `menu_recipes` (
              `menu_id` int(11) NOT NULL,
              `recipe_id` int(11) NOT NULL,
              `weight` float NOT NULL,
              PRIMARY KEY (`menu_id`,`recipe_id`),
              KEY `menu_recipes_recipe_id` (`recipe_id`),
              CONSTRAINT `menu_recipes_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `menu_recipes_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `menu_portions` (
              `menu_id` int(11) NOT NULL,
              `portion_id` int(11) NOT NULL,
              `count` float NOT NULL,
              PRIMARY KEY (`menu_id`,`portion_id`),
              KEY `menu_portions_portion_id` (`portion_id`),
              CONSTRAINT `menu_portions_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `menu_portions_portion_id` FOREIGN KEY (`portion_id`) REFERENCES `portion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        echo "m150802_133232_individual_plan cannot be reverted.\n";

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
