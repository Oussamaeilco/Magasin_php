<?php
include '../model/Produit.php';

session_start();

if(isset($_POST["action"])){
    switch($_POST["action"]){
        case "addProduit" :
            if(!empty($_POST)){
                $id = $_POST["id"];
                $nom = $_POST["nom"];
                $prix = $_POST["prix"];
                $categorie = $_POST["categorie"];
                $date_deb = $_POST["date_deb"];
                $date_fin = $_POST["date_fin"];
                $qt = $_POST["qt"];
                $produit=new Produit( $id,$nom,$categorie,$prix,$date_deb,$date_fin,$qt);
                $_SESSION["produit"]=$produit;
                $url="../business/Add_Product.php";
                header("Location:$url");
                exit();
            }
            break;
        default :
            header("Loacation: index.php");
            break;
    }
}