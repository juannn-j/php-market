<?php
    class DB{
        public static function conectar(){

            $url = "pgsql:host=localhost;dbname=laptopdb";
            $user = "postgres"; 
            $password = "";

            try {
                $cn = new PDO($url, $user, $password);
                $cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $cn;
            } catch (PDOException $e) {
                echo "Error de conexión a la base de datos: " . $e->getMessage();
                return null;
            }
        }
    }
?>