<?php
    class Cliente{
        public $id;
        public $rut;
        public $nombre;
        public $direccion;
        public $comuna;
        public $email;
        public $telefono;
        
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;
                return $this;
        }

        
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;
                return $this;
        }

        
        public function getRut()
        {
                return $this->rut;
        }

        /**
         * Set the value of rut
         *
         * @return  self
         */ 
        public function setRut($rut)
        {
                $this->rut = $rut;
                return $this;
        }

        
        public function getDireccion()
        {
                return $this->direccion;
        }

        /**
         * Set the value of direccion
         *
         * @return  self
         */ 
        public function setDireccion($direccion)
        {
                $this->direccion = $direccion;
                return $this;
        }

        
        public function getComuna()
        {
                return $this->comuna;
        }

        /**
         * Set the value of comuna
         *
         * @return  self
         */ 
        public function setComuna($comuna)
        {
                $this->comuna = $comuna;
                return $this;
        }

        
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;
                return $this;
        }

        
        public function getTelefono()
        {
                return $this->telefono;
        }

        /**
         * Set the value of telefono
         *
         * @return  self
         */ 
        public function setTelefono($telefono)
        {
                $this->telefono = $telefono;
                return $this;
        }

        
    }

    class Proveedor extends Cliente{
        
    }

    class Categoria{
        public $id;
        public $nombre;
    }

    class Producto{
        public $codigo;
        public $nombre;
        public $categoria;
        public $descripcion;
        public $imagen;
        //public cantidad; ????? maybe
    }
?>