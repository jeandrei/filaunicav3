<?php
//aula 31 do curso
    class Lista {
        private $db;

        public function __construct(){
            //inicia a classe Database
            $this->db = new Database;
        }



        public function getLastid(){
            $this->db->query("SELECT max(id) as id FROM fila");             
            $lastId = $this->db->single();
            return $lastId->id;            
        }
    
    
    }