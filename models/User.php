<?php

namespace Model;

class User extends ActiveRecord{
    public static $table = "users";
    public $columns = ["id", "name", "lastname", "email", "password", "phone", "admin", "confirmed", "token"];
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->id = trim($this->id);
        $this->name = $args["name"] ?? "";
        $this->name = trim($this->name);
        $this->lastname = $args["lastname"] ?? "";
        $this->lastname = trim($this->lastname);
        $this->email = $args["email"] ?? "";
        $this->email = trim($this->email);
        $this->password = $args["password"] ?? "";
        $this->password = trim($this->password);
        $this->phone = $args["phone"] ?? "";
        $this->phone = trim($this->phone);
        $this->admin = $args["admin"] ?? "";
        $this->admin = trim($this->admin);
        $this->confirmed = $args["confirmed"] ?? "";
        $this->confirmed = trim($this->confirmed);
        $this->token = $args["token"] ?? "";
        $this->token = trim($this->token);
    }

    public function validateNewAccount(){
        $this->email = self::$db->escape_string($this->email);
        $query = "SELECT * FROM " . static::$table . " WHERE email = '$this->email';";
        $result = self::$db->query($query);

        if($result->num_rows>0){
            $this->alerts["error"][] = "Email was already registered";
        }

    }

    public function verifyToken(){
        if($this->token){
            $this->alerts["success"][]="Account verified now you can log in";
            $this->token = 0;
            $this->confirmed = 1;
            $this->admin = 0;
            $query = "UPDATE " . static::$table . " SET admin = $this->admin, confirmed = $this->confirmed, token = $this->token WHERE id = $this->id;";
            static::$db->query($query);
        }else{
            $this->alerts["error"][]="Token not found";
        }
    }

    public function createToken(){
        $this->token = uniqid();
    }

    public function verifyAuth(){
        if(!$this->email){
            $this->alerts["error"][] = "Email empty";
        }
        if(!$this->password){
            $this->alerts["error"][] = "Password empty";
        }
    }

    public function verifyPassword($password){

        if(password_verify($password, $this->password) && $this->confirmed==1){
            $this->alerts["success"][] = "User logged";

            return true;

        }else{
            $this->alerts["error"][] = "Wrong password or not verified yet";
            return false;

        }
    }

    public function validateInputData(){

        if(!$this->name){
            $this->alerts["error"][] = "Name can't be empty";
        }

        if(!$this->lastname){
            $this->alerts["error"][] = "Lastname can't be empty";
        }

        if(!$this->phone){
            $this->alerts["error"][] = "Phone can't be empty";
        }

        if(!$this->email){
            $this->alerts["error"][] = "Email can't be empty";
        }

        if(!$this->password){
            $this->alerts["error"][] = "Password can't be empty";
        }else{
            if(strlen($this->password)<6){
                $this->alerts["error"][] = "Password can't smaller than 6 characters";
            }
        }

    }

    public function sanitizeAttributes(){

        $attributes = [];


        foreach($this->columns as $column){
            if( $this->$column){
                $attributes[$column] =  self::$db->escape_string($this->$column);

                if($column == "password"){

                    $attributes[$column] = $this->hashPassword($attributes[$column]);

                }


            }
        }
        return $attributes;
    }

    public function hashPassword($password){
        $password = password_hash($password, PASSWORD_BCRYPT);
        return $password;
    }

    public function validateEmail(){

        if(!$this->email){
            $this->alerts["error"][] = "Email empty";
        }

    }

    public function validatePassword(){

        if(!$this->password){
            $this->alerts["error"][] = "Password empty";
        }else{
            if(strlen($this->password)<6){
            $this->alerts["error"][] = "Password has to be longer than 6 characters";
            }
        }
    }

    public function saveProperty($property){
        $query = "UPDATE " . static::$table . " SET $property = '". $this->$property ."' WHERE id = $this->id;";

        static::$db->query($query);
    }

}

?>