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


    public function categoryExists($name, $brand_id)
    {
        $sql = "SELECT cat_id
                FROM categories
                WHERE cat_name = ?
                AND brand_id = ?";

        $category = $this->fetchOne($sql, [$name, $brand_id]);

        return $category !== false;
    }


    public function addCategory($name, $brand_id)
    {
        $sql = "INSERT INTO categories (cat_name, brand_id)
                VALUES (?, ?)";

        return $this->execute($sql, [$name, $brand_id]);
    }


    public function getAllCategories()
    {
        $sql = "SELECT
                    categories.cat_id,
                    categories.cat_name,
                    categories.brand_id,
                    brands.brand_name
                FROM categories
                LEFT JOIN brands
                    ON categories.brand_id = brands.brand_id
                ORDER BY brands.brand_name ASC, categories.cat_name ASC";

        return $this->fetchAll($sql);
    }


    public function getCategoryById($id)
    {
        $sql = "SELECT
                    categories.cat_id,
                    categories.cat_name,
                    categories.brand_id,
                    brands.brand_name
                FROM categories
                LEFT JOIN brands
                    ON categories.brand_id = brands.brand_id
                WHERE categories.cat_id = ?";

        return $this->fetchOne($sql, [$id]);
    }


    public function updateCategory($id, $name, $brand_id)
    {
        $sql = "UPDATE categories
                SET cat_name = ?,
                    brand_id = ?
                WHERE cat_id = ?";

        return $this->execute($sql, [$name, $brand_id, $id]);
    }
}