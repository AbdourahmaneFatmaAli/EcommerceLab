<?php

require_once __DIR__ . "/../core/db_class.php";

class ProductClass extends Database
{

    public function brandExists($name)
    {
        $sql = "SELECT brand_id
                FROM brands
                WHERE brand_name = ?";

        $brand = $this->fetchOne($sql, [$name]);

        return $brand !== false;
    }


    public function addBrand($name)
    {
        $sql = "INSERT INTO brands (brand_name) VALUES (?)";

        return $this->execute($sql, [$name]);
    }

    public function getAllBrands()
    {
        $sql = "SELECT *
                FROM brands
                ORDER BY brand_name ASC";

        return $this->fetchAll($sql);
    }

  
    public function getBrandById($id)
    {
        $sql = "SELECT *
                FROM brands
                WHERE brand_id = ?";

        return $this->fetchOne($sql, [$id]);
    }


    public function updateBrand($id, $name)
    {
        $sql = "UPDATE brands
                SET brand_name = ?
                WHERE brand_id = ?";

        return $this->execute($sql, [$name, $id]);
    }


  
    public function categoryExists($name)
    {
        $sql = "SELECT cat_id
                FROM categories
                WHERE cat_name = ?";

        $category = $this->fetchOne($sql, [$name]);

        return $category !== false;
    }


    public function addCategory($name)
    {
        $sql = "INSERT INTO categories (cat_name) VALUES (?)";

        return $this->execute($sql, [$name]);
    }


    public function getAllCategories()
    {
        $sql = "SELECT *
                FROM categories
                ORDER BY cat_name ASC";

        return $this->fetchAll($sql);
    }


    public function getCategoryById($id)
    {
        $sql = "SELECT *
                FROM categories
                WHERE cat_id = ?";

        return $this->fetchOne($sql, [$id]);
    }


    public function updateCategory($id, $name)
    {
        $sql = "UPDATE categories
                SET cat_name = ?
                WHERE cat_id = ?";

        return $this->execute($sql, [$name, $id]);
    }
}