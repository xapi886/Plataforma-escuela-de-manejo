<?php

    class DB{

        private $host;
        private $db;
        private $user;
        private $password;
        private $charset; 

        public function __construct(){
            $this->host     = 'localhost';
            $this->db       = 'dbeescuela_de_manejo';
            $this->user     = 'root';
            $this->password = '';
            $this->charset  = 'utf8mb4';
        } 

        function connect(){
            try{
                $pdo = new PDO('mysql:host=localhost;dbname=dbeescuela_de_manejo;charset=utf8','root','');
                return $pdo;
            }

           catch(PDOException $e)
            {
                print_r('Error connection: ' . $e->getMessage());
            }   
        }    
    }   
?>