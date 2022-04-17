<?php

include_once('../db.php');

include_once('../TreeBehaviour.php');

require('../style/layout/header.php');

$db = new Database('localhost', 'root', '', 'food_tree');
$conn = $db->conn;

$tree = new Tree($conn, 'food');

$allNodes = $tree->getAllTreeNodes();

$tree->createTable($allNodes);