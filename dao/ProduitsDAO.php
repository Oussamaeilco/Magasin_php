<?php
include 'MySQL_DB.php';

class ProduitsDAO{
    var $bd=null;
    var $pdo=null;
    
    function __construct()
    {
        $this->bd=new MySQL_DB();
        $this->pdo=$this->bd->pdo;
    }
    

    /*-------------------------------------*/
    //Afficher liste de produits
    function getListeProducts(){
        $req="Select Nom,IDProduit,Categorie,Prix, sum(Quantite) as QTT_Totale 
            from (
                Select  P.nom as Nom,P.id as IDProduit,P.categorie as Categorie,Pr.valeur as Prix,S.qt_mv  as Quantite
                from produit P, prix Pr, stock_mv S 
                where P.id=Pr.id_produit and P.id=S.id_produit 
                group by S.id) as A
            group by A.IDProduit
        ";
        try{
            $reponse = $this->bd->executeRequest($req);
        }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $html="";
        $html .= "<table>\n<tr><th>Nom</th><th>ID Produit</th><th>Categorie</th><th>Prix</th><th>Quantité</th></tr>\n";
        
        while ($donnees = $reponse->fetch())
        {
            $html .= "<tr>";
            $html .= "<td>" . $donnees['Nom'] . '</td><td>' . $donnees['IDProduit'] . '</td><td>' . $donnees['Categorie'] . '</td><td>' . $donnees['Prix'] . ' €</td><td>' . $donnees['QTT_Totale'] . '</td>';
            $html .= "</tr>\n";
        }

        $html .="</table>";

        $reponse->closeCursor();

        return $html;   
    }
    //Liste des produits
    function getProducts(){
        $req="Select Nom,IDProduit,Categorie,Prix, sum(Quantite) as QTT_Totale 
        from (
            Select  P.nom as Nom,P.id as IDProduit,P.categorie as Categorie,Pr.valeur as Prix,S.qt_mv  as Quantite
            from produit P, prix Pr, stock_mv S 
            where P.id=Pr.id_produit and P.id=S.id_produit 
            group by S.id) as A
        group by A.IDProduit
        ";
        try{
            $reponse = $this->bd->executeRequest($req);
        }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $array=[];
        
        while ($donnees = $reponse->fetch())
        {
            $desc = "";
            $desc .= "Id :" . $donnees['IDProduit'] . "\nNom :" . $donnees['Nom'] . '\nCategorie :' . $donnees['Categorie'] . '\nPrix :' . $donnees['Prix'] . ' €\nQuantité :' . $donnees['QTT_Totale'] ;
            $array[$donnees['IDProduit']]=$desc;
        }

        $reponse->closeCursor();

        return $array;   
    }
    /*-------------------------------------*/
    //Ajouter produit
    function renseignerProduit(Produit $produit) {
        
        try{
            //If product doesn't exist add new one
            if(!($this->existe($produit->id)))
            {
                $this->pdo->exec("INSERT INTO produit(id,nom,categorie) Values($produit->id,'$produit->nom','$produit->categorie')");
            }
            //update Data
            else{
                $this->pdo->exec("UPDATE produit SET nom='$produit->nom',categorie='$produit->categorie' WHERE id=$produit->id");
            }
            //Add price
            $this->pdo->exec("INSERT INTO  prix(valeur,date_debut,date_fin,id_produit) VALUES($produit->prix,'$produit->date_deb','$produit->date_fin',$produit->id)");
            //Add stock_mv
            $date=date("Y/m/d");
            $this->pdo->exec("INSERT INTO  stock_mv(date,qt_mv,id_produit) VALUES('$date',$produit->qt,$produit->id)");
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
            echo ''.$produit->categorie;
        }
    }
    //Supprimer produit
    function supprimerProduit($id){
        try{
            $this->pdo->exec("Delete from produit where id=$id");
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }

    //Tester si produit existe par id
    function existe($id) : bool{
        $reponse=$this->bd->executeRequest("Select * from Produit");
        while($donnees=$reponse->fetch())
        {
            if($donnees["id"]==$id){
                $reponse->closeCursor();
                return true;
            }
        }
        $reponse->closeCursor();
        return false;
    }
}