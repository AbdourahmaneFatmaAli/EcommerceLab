<?php

require_once "../classes/CustomerClass.php";

class CustomerController
{
    private $customer;

    public function __construct()
    {
        $this->customer = new CustomerClass();
    }

    public function register($data)
    {
        if ($this->customer->emailExists($data['email'])) {
            return [
                'success' => false,
                'error' => 'Email already registered'
            ];
        }

        $result = $this->customer->addCustomer(
            $data['name'],
            $data['email'],
            $data['pass'],
            $data['country'],
            $data['city'],
            $data['contact']
        );

        if ($result) {
            return [
                'success' => true
            ];
        }

        return [
            'success' => false,
            'error' => 'Registration failed'
        ];
    }

    public function selectAll()
    {
        return $this->customer->getAllCustomers();
    }

    public function login($email, $password)
    {
        return $this->customer->login($email, $password);
    }
}