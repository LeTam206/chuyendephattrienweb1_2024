<?php
require_once 'configs/database.php';

abstract class BaseModel
{
    // Database connection
    protected static $_connection;

    public function __construct()
    {

        if (!isset(self::$_connection)) {
            self::$_connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
            if (self::$_connection->connect_errno) {
                printf("Connect failed");
                exit();
            }
        }

    }

    /**
     * Query in database
     * @param $sql
     */
    protected function query($sql)
    {

        $result = self::$_connection->query($sql);
        return $result;
    }

    /**
     * Select statement
     * @param $sql
     */
    protected function select($sql)
    {
        $result = $this->query($sql);
        $rows = [];
        if (!empty($result)) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * Delete statement
     * @param $sql
     * @return mixed
     */
    protected function delete($sql)
    {
        $result = $this->query($sql);
        return $result;
    }

    /**
     * Update statement
     * @param $sql
     * @return mixed
     */
    protected function update($sql)
    {
        $result = $this->query($sql);
        return $result;
    }



    /**
     * Insert statement
     * @param $sql
     */
    protected function insert($sql)
    {
        $result = $this->query($sql);
        return $result;
        // $conn = new mysqli('localhost', 'root', "", "app_web1");
        // // Lấy id vừa được thêm
        // $last_id = $conn->insert_id;
        // $hashed_id = md5(''.$last_id);
        // $sql_update = "UPDATE users SET id = '$hashed_id' WHERE id = $last_id";
        // $conn->query($sql_update);
        // // $result = $conn->query($sql_update);
        // var_dump($last_id);
        // $conn->close();

        
    }

    protected function hashID($id)
    {
        $encryption_key = 'fvdg3436hgdf@14rt#!32)$fWgs!t3Sa';
        $method = 'AES-256-CBC';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted_id = openssl_encrypt($id, $method, $encryption_key, 0, $iv);
        return $encrypted_id;
    }

}
