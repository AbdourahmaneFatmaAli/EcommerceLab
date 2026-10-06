<?php

require_once __DIR__ . "/../classes/ProductClass.php";

class ProductController
{
    private $product;

    public function __construct()
    {
        $this->product = new ProductClass();
    }

    public function brandExists($name)
    {
        return $this->product->brandExists($name);
    }

    public function addBrand($name)
    {
        return $this->product->addBrand($name);
    }

    public function getAllBrands()
    {
        return $this->product->getAllBrands();
    }

    public function getBrandById($id)
    {
        return $this->product->getBrandById($id);
    }

    public function updateBrand($id, $name)
    {
        return $this->product->updateBrand($id, $name);
    }


    public function categoryExists($name, $brand_id)
    {
        return $this->product->categoryExists($name, $brand_id);
    }

    public function addCategory($name, $brand_id)
    {
        return $this->product->addCategory($name, $brand_id);
    }

    public function getAllCategories()
    {
        return $this->product->getAllCategories();
    }

    public function getCategoryById($id)
    {
        return $this->product->getCategoryById($id);
    }

    public function updateCategory($id, $name, $brand_id)
    {
        return $this->product->updateCategory($id, $name, $brand_id);
    }
}