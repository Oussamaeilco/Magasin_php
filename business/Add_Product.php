<?php
    include '../model/Produit.php';
    include '../dao/MySQL_DB.php';
    if(!empty($_POST)){
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $prix = $_POST["prix"];
        $categorie = $_POST["categorie"];
        $date_deb = $_POST["date_deb"];
        $date_fin = $_POST["date_fin"];
        $qt = $_POST["qt"];

        $db=new MySQL_DB();
        $produit=new Produit( $id,$nom,$categorie,$prix,$date_deb,$date_fin,$qt);
        $db->renseignerProduit($produit);
        //forward
        header("Location: ../index.php");
        //exit();
    }