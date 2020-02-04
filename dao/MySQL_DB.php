<?php

class MySQL_DB{
    var $bdd=null;
   
    function __construct()
    {
        try{
            $this->bdd = new PDO('mysql:host=localhost:3308;dbname=magasin;charset=utf8', 'root', '');
        }
        catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
    }


    function executeRequest($req)
    {
        $reponse = $this->bdd->query("".$req);
        return $reponse;
    }

    //Afficher liste de produits

    function getListeProducts(){
        $req = "Select P.nom as Nom,P.id as IDProduit,P.categorie as Categorie,Pr.valeur as Prix,S.qt_mv as Quantite from produit P, prix Pr, stock_mv S where P.id=Pr.id_produit and P.id=S.qt_mv";
        $reponse = $this->executeRequest($req);

        $html = "<table><tr><th>Nom</th><th>ID Produit</th><th>Categorie</th><th>Prix</th><th>Prix</th><th>Quantité</th></tr>";
        
        while ($donnees = $reponse->fetch())
        {
            $html .= "<tr>";
            $html .= "<td>" . $donnees['Nom'] . '</td><td>' . $donnees['IDProduit'] . '</td><<td>' . $donnees['Categorie'] . '</td><td>' . $donnees['Prix'] . '</td><td>' . $donnees['Quantite'] . '</td>';
            $html .= "</tr>";
        }

        $html .="</table>";

        $reponse->closeCursor();

        return $html;
    }

    //Ajouter produit
    function renseignerProduit($produit){
        
    }
}