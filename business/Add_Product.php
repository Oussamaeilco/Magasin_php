<?php
    include '../model/Produit.php';
    include '../dao/ProduitsDAO.php';

    session_start();

    if(isset($_SESSION["produit"])){
        $produit=$_SESSION["produit"];
        $db=new ProduitsDAO();
        $db->renseignerProduit($produit);
        unset($_SESSION["produit"]);
        //forward
        header("Location: ../index.php");
        exit();
    }
    