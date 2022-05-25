<?php

include_once 'autoloader.php';

Autoload::init();

$db = new Database();
refreshDatabase($db);
fillDatabase($db);

function refreshDatabase($db)
{
    $tables = $db->query("SHOW TABLES");

    while ($row = $tables->fetch_array(MYSQLI_NUM)) {
        $db->query("DROP TABLE IF EXISTS " . $row[0]);
    }

    $db->query(
        "CREATE TABLE `users` (
    id int primary key auto_increment,
    login varchar(255),
    password varchar(255))"
    );
    $db->query(
        "CREATE TABLE `auth_token` (
    id int primary key auto_increment,
    token varchar(255),
    user_id int,
    FOREIGN KEY (user_id) REFERENCES users(id))"
    );
    $db->query(
        "CREATE TABLE `statuses` (
    id int primary key auto_increment,
    name varchar(255))"
    );
    $db->query(
        "CREATE TABLE `product_category` (
    id int primary key auto_increment,
    name varchar(255))"
    );
    $db->query(
        "CREATE TABLE `products` (
    id int primary key auto_increment,
    name varchar(255),
    description text,
    status_id int,
    category_id int,
    FOREIGN KEY (category_id) REFERENCES product_category(id),
    FOREIGN KEY (status_id) REFERENCES statuses(id))"
    );
}

function fillDatabase($db)
{
    $db->query("INSERT INTO `users` (`login`, `password`) VALUES ('admin', 'admin')");
    $db->query("INSERT INTO `statuses` (`name`) VALUES ('success'), ('failed'), ('pending')");
    $db->query("INSERT INTO `product_category` (`name`) VALUES ('apple'), ('samsung'), ('huawei')");
    $db->query("INSERT INTO `products` (`name`, `description`, `status_id`, `category_id`) VALUES ('product1', 'lorem ipsum product 1 description', 1, 1), ('product2', 'lorem ipsum product 2 description', 2, 2), ('product3', 'lorem ipsum product 3 description', 3, 3)");
}

