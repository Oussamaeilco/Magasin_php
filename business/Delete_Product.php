<?php
    include '../model/Produit.php';
    include '../dao/ProduitsDAO.php';

    session_start();

    if(isset($_SESSION["id"])){
        $id=$_SESSION["id"];
        $db=new ProduitsDAO();
        $db->supprimerProduit($id);
        unset($_SESSION["id"]);
        //forward
        header("Location: ../index.php");
        exit();
    }
    