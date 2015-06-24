<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_172437_create_tables extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `user` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(255) NOT NULL,
              `password_hash` varchar(500) NOT NULL,
              `first_name` varchar(255) DEFAULT NULL,
              `last_name` varchar(255) DEFAULT NULL,
              `phone` varchar(126) DEFAULT NULL,
              `avatar` varchar(500) DEFAULT NULL,
              `status` int(2) NOT NULL DEFAULT '0',
              `role` varchar(24) NOT NULL DEFAULT 'USER',
              `last_login_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `product_category` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `recipe_category` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `product` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `category_id` int(11) DEFAULT NULL,
              `name` varchar(255) NOT NULL,
              `calories` float NOT NULL,
              `description` text,
              PRIMARY KEY (`id`),
              KEY `product_category_id` (`category_id`),
              CONSTRAINT `product_category_id` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

            CREATE TABLE `recipe` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `category_id` int(11) NOT NULL,
              `name` varchar(255) NOT NULL,
              `description` text,
              PRIMARY KEY (`id`),
              KEY `recipe_category_id` (`category_id`),
              CONSTRAINT `recipe_category_id` FOREIGN KEY (`category_id`) REFERENCES `recipe_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `recipe_products` (
              `recipe_id` int(11) NOT NULL,
              `product_id` int(11) NOT NULL,
              `weight` float NOT NULL,
              PRIMARY KEY (`recipe_id`,`product_id`),
              KEY `recipe_products_product_id` (`product_id`),
              CONSTRAINT `recipe_products_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `recipe_products_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `portion` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `description` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `portion_recipes` (
              `portion_id` int(11) NOT NULL,
              `recipe_id` int(11) NOT NULL,
              `weight` float NOT NULL,
              PRIMARY KEY (`portion_id`,`recipe_id`),
              KEY `portion_recipes_recipe_id` (`recipe_id`),
              CONSTRAINT `portion_recipes_portion_id` FOREIGN KEY (`portion_id`) REFERENCES `portion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `portion_recipes_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `calculating` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `date` date NOT NULL,
              PRIMARY KEY (`id`),
              KEY `calculating_user_id` (`user_id`),
              CONSTRAINT `calculating_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

            CREATE TABLE `calculating_products` (
              `calculating_id` int(11) NOT NULL,
              `product_id` int(11) NOT NULL,
              `weight` float NOT NULL,
              PRIMARY KEY (`calculating_id`,`product_id`),
              KEY `calculating_product_product_id` (`product_id`),
              CONSTRAINT `calculating_product_calculating_id` FOREIGN KEY (`calculating_id`) REFERENCES `calculating` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `calculating_product_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `calculating_recipes` (
              `calculating_id` int(11) NOT NULL,
              `recipe_id` int(11) NOT NULL,
              `weight` float NOT NULL,
              PRIMARY KEY (`calculating_id`,`recipe_id`),
              KEY `calculating_recipes_recipe_id` (`recipe_id`),
              CONSTRAINT `calculating_recipes_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `calculating_recipescalculating_id` FOREIGN KEY (`calculating_id`) REFERENCES `calculating` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE `calculating_portions` (
              `calculating_id` int(11) NOT NULL,
              `portion_id` int(11) NOT NULL,
              `count` float NOT NULL,
              PRIMARY KEY (`calculating_id`,`portion_id`),
              KEY `calculating_portions_portion_id` (`portion_id`),
              CONSTRAINT `calculating_portions_calculating_id` FOREIGN KEY (`calculating_id`) REFERENCES `calculating` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `calculating_portions_portion_id` FOREIGN KEY (`portion_id`) REFERENCES `portion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        echo "m150624_172437_create_tables cannot be reverted.\n";

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
