<?php
    include '../model/Produit.php';
    include '../dao/VentesDAO.php';

    session_start();

    if(!empty($_SESSION)){
        foreach($_SESSION as $id => $entry){
            echo "$id => $entry" ;
        }
        $db=new VentesDAO();
        unset($_SESSION);
        //forward
        //header("Location: ../index.php");
        //exit();
    }
    