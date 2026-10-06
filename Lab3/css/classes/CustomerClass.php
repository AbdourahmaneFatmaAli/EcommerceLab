<?php


require_once "../core/db_class.php";

class CustomerClass extends Database
{

    public function emailExists($email)
    {
        $sql = "SELECT customer_email
                FROM customer
                WHERE customer_email = ?";

        $customer = $this->fetchOne($sql, [$email]);

        return $customer !== false;
    }

    public function addCustomer($name, $email, $pass, $country, $city, $contact)
    {
      
        $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

        $sql = "INSERT INTO customer (
                    customer_name,
                    customer_email,
                    customer_pass,
                    customer_country,
                    customer_city,
                    customer_contact
                ) VALUES (?, ?, ?, ?, ?, ?)";

        return $this->execute(
            $sql,
            [
                $name,
                $email,
                $hashedPassword,
                $country,
                $city,
                $contact
            ]
        );
    }

  
    public function getAllCustomers()
    {
        $sql = "SELECT
                    customer_id,
                    customer_name,
                    customer_email,
                    customer_country,
                    customer_city,
                    customer_contact,
                    customer_image,
                    user_role
                FROM customer
                ORDER BY customer_id DESC";

        return $this->fetchAll($sql);
    }

    
    public function getCustomerByEmail($email)
    {
        $sql = "SELECT *
                FROM customer
                WHERE customer_email = ?";

        return $this->fetchOne($sql, [$email]);
    }

   
    public function login($email, $pass)
    {
        $customer = $this->getCustomerByEmail($email);

        if (!$customer) {
            return false;
        }

     
        if (!password_verify($pass, $customer['customer_pass'])) {
            return false;
        }

        return $customer;
    }
}