<?php

// Bring in the Database class
require_once "../core/db_class.php";

// Customer model: handles database operations for the customer table.
class CustomerClass extends Database
{
    // Check whether an email already exists.
    // Returns true if it exists, false otherwise.
    public function emailExists($email)
    {
        $sql = "SELECT customer_email
                FROM customer
                WHERE customer_email = ?";

        $customer = $this->fetchOne($sql, [$email]);

        return $customer !== false;
    }

    // Add a new customer to the database.
    public function addCustomer($name, $email, $pass, $country, $city, $contact)
    {
        // Hash the password before storing it.
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

    // Get every customer, newest first.
    // Do not retrieve passwords for the customer list.
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

    // Get one customer using their email.
    // Returns the customer row or false if not found.
    public function getCustomerByEmail($email)
    {
        $sql = "SELECT *
                FROM customer
                WHERE customer_email = ?";

        return $this->fetchOne($sql, [$email]);
    }

    // Verify the customer's login credentials.
    public function login($email, $pass)
    {
        $customer = $this->getCustomerByEmail($email);

        if (!$customer) {
            return false;
        }

        // Compare the entered password with the stored password hash.
        if (!password_verify($pass, $customer['customer_pass'])) {
            return false;
        }

        return $customer;
    }
}