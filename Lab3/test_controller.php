<?php

require_once "./controllers/ProductController.php";

$controller = new ProductController();

echo "<pre>";
print_r(get_class_methods($controller));
echo "</pre>";