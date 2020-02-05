<?php
include_once 'MySQL_DB.php';

class VentesDAO{
    var $bd=null;
    var $pdo=null;
    
    function __construct()
    {
        $this->bd=new MySQL_DB();
        $this->pdo=$this->bd->pdo;
    }
    

    /*-------------------------------------*/
    //Afficher liste de produits
    function getCatalogue(){
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
        $count=0;
        $url="controller/controller.php";
        $html="<form action='$url' method='POST'><input type='hidden' value='commandeVente' name='action' />";
        $html .= "<table>\n<tr><th>Nom</th><th>ID Produit</th><th>Categorie</th><th>Prix</th><th>Quantité en Stock</th><th>Quantité</th></tr>\n";
        
        while ($donnees = $reponse->fetch())
        {
            $html .= "<tr>";
            $html .= "<td>" . $donnees['Nom'] . '</td><td>' . $donnees['IDProduit'] . '</td><td>' . $donnees['Categorie'] . '</td><td>' . $donnees['Prix'] . ' €</td><td>' . $donnees['QTT_Totale'] . '</td><td><input type="number" value="0" min="0" max="' . $donnees['QTT_Totale'] . '" name="' . $donnees['IDProduit'] . '"></td>';
            $html .= "</tr>\n";
            $count++;
        }

        $html .="</table><input type=\"submit\" value=\"Confirmer\"></form>";

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
            $desc .= "Id :" . $donnees['IDProduit'] . "</br>    Nom :" . $donnees['Nom'] . "</br>   Categorie :" . $donnees['Categorie'] . "</br>  Prix :" . $donnees['Prix'] . "€</br> Quantité :" . $donnees['QTT_Totale'];
            $array[$donnees['IDProduit']]=$desc;
        }

        $reponse->closeCursor();

        return $array;   
    }
    /*-------------------------------------*/
    //Créer commande
    function createCommande($array){
        try{
            //Create vente
            $date=date("Y/m/d");
            $this->pdo->exec("INSERT INTO ventes(date,prix_totale) Values($date,0)");
            $id=$this->pdo->lastInsertId();
            $total_price=0;
            foreach($array as $i => $qt){
                //Create stock_mv
                $this->pdo->exec("INSERT INTO  stock_mv(date,qt_mv,id_produit) VALUES('$date',-$qt,$i)");
                //Create produit_vente
                $this->pdo->exec("INSERT INTO  produit_vente(quantite,id_produit,id_ventes) VALUES('$qt',$i,$id)");
                //
                try{
                    //
                    $reponse=$this->bd->executeRequest("SELECT * FROM prix where id_produit=1 order by id desc limit 1");
                    $prix=$reponse->fetch()["valeur"];
                    $total_price=$total_price+$prix*$qt;
                }catch(Exception $e){
                    die('Erreur : '.$e->getMessage());   
                }
            }
            try{
                $this->pdo->exec("UPDATE ventes SET prix_totale=$total_price where id=$id");
            }catch(Exception $e){
                die('Erreur : '.$e->getMessage());   
            }
        }catch(Exception $e){
            die('Erreur : '.$e->getMessage());   
        }
    }
    /*--------------------------------------*/
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