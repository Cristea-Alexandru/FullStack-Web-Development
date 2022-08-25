<?php

namespace Model;

class Usuario extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';

    }

    // Mensajes de validacion para la creacion de una cuenta
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = "El Nombre es Obligatorio";
        }
        if(!$this->apellido){
            self::$alertas['error'][] = "El Apellido es Obligatorio";
        }
        if(!$this->email){
            self::$alertas['error'][] = "El E-Mail es Obligatorio";
        }
        if(!$this->password){
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = "La Contraseña tiene que tener al menos 6 caractéres";
        }
        return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El E-mail es Obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        }
        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El E-mail es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][] = 'La Contraseña debe tener minimo 6 caracteres';
        }
        return self::$alertas;
    }

    // Revisar si el usuario ya tiene una cuenta creada o está registrado
    public function existeUsuario(){
        $query = "SELECT * from " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = "El usuario ya esta registrado";
        }   
        return $resultado;
     }

     public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
     }

     public function crearToken(){
        $this->token = uniqid();
     }

     public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Contraseña incorrecta o tu cuenta no ha sido confirmada';
        }else{
            return true;
        }
     }
}

