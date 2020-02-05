<?php
include '../model/Produit.php';
include_once '../dao/VentesDAO.php';
session_start();

if(isset($_POST["action"])){
    switch($_POST["action"]){
        case "home":
            header("Location: ../index.php");
            exit();
            break;
        //Ajout
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
        //Suppression
        case "deleteProduit":
            if(!empty($_POST)){
                $id = $_POST["id"];
                $url="../view/validerSuppression.php?id=$id";
                header("Location:$url");
                exit();
            }
            break;
        case "validerSuppression":
            if(!empty($_POST)){
                $id=$_POST["id"];
                $_SESSION["id"]=$id;
                $url="../business/Delete_Product.php";
                header("Location:$url");
                exit();
            }
            break;
        //Modification
        case "modifierProduit":
            if(!empty($_POST)){
                $id=$_POST["id"];
                $url="../view/modifierProduct.php?id=$id";
                header("Location:$url");
                exit();
            }
            break;
        case "validerModification":
            if(!empty($_POST)){
                $id = $_POST["id"];
                $nom = $_POST["nom"];
                $categorie = $_POST["categorie"];
                $produit=new Produit( $id,$nom,$categorie,0,"","",0);
                $_SESSION["produit"]=$produit;
                $url="../business/Modify_Product.php";
                header("Location:$url");
                exit();
            }
            break;
        //Commande
        case "commandeVente":
            if(!empty($_POST)){
                $ventes=new VentesDAO();
                $produits=$ventes->getProducts();
                $array=[];
                foreach($produits as $i=>$p){
                    if($_POST[$i]!=0)
                        $array[$i]=$_POST[$i];
                }
                $_SESSION["commande"]=$array;
                $url="../business/Add_Commande.php";
                header("Location:$url");
                exit();
            }
            break;
        default :
            header("Loacation: ../index.php");
            exit();
            break;
    }
}