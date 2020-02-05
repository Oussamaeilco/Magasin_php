<?php
    include '../model/Produit.php';
    include '../dao/VentesDAO.php';

    session_start();
    
    $db=new VentesDAO();
    if(isset($_SESSION["commande"])){
        
        $db->createCommande($_SESSION["commande"]);
        
         unset($_SESSION["commande"]);
        //forward
        header("Location: ../index.php");
       exit();
    }
    