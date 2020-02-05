<?php

class MySQL_DB{
    var $pdo=null;
   
    function __construct()
    {
        try{
            $this->pdo = new PDO('mysql:host=localhost:3308;dbname=magasin;charset=utf8', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }


    function executeRequest($req)
    {
        $reponse = $this->pdo->query("".$req);
        return $reponse;
    }

   
}