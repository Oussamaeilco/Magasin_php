<?php

class MySQL_DB{
    var $bdd=null;
   
    function __construct()
    {
        try{
            $this->bdd = new PDO('mysql:host=localhost:3308;dbname=magasin;charset=utf8', 'root', '');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $req = "Select Distinct P.nom as Nom,P.id as IDProduit,P.categorie as Categorie,Pr.valeur as Prix,SUM(S.qt_mv) as Quantite from produit P, prix Pr, stock_mv S where P.id=Pr.id_produit and P.id=S.id_produit Group by P.id";
        try{
            $reponse = $this->executeRequest($req);
        }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $html="";
        $html .= "<table>\n<tr><th>Nom</th><th>ID Produit</th><th>Categorie</th><th>Prix</th><th>Quantité</th></tr>\n";
        
        while ($donnees = $reponse->fetch())
        {
            $html .= "<tr>";
            $html .= "<td>" . $donnees['Nom'] . '</td><td>' . $donnees['IDProduit'] . '</td><td>' . $donnees['Categorie'] . '</td><td>' . $donnees['Prix'] . ' €</td><td>' . $donnees['Quantite'] . '</td>';
            $html .= "</tr>\n";
        }

        $html .="</table>";

        $reponse->closeCursor();

        return $html;   
    }

    //Ajouter produit
    function renseignerProduit(Produit $produit) {
        //If product doesn't exist add new one
        try{
            if(!($this->existe($produit->id)))
            {
                $this->bdd->exec("INSERT INTO produit(id,nom,categorie) Values($produit->id,'$produit->nom','$produit->categorie')");
            }
            //Add price
            $this->bdd->exec("INSERT INTO  prix(valeur,date_debut,date_fin,id_produit) VALUES($produit->prix,'$produit->date_deb','$produit->date_fin',$produit->id)");
            //Add stock_mv
            $date=date("Y/m/d");
            $this->bdd->exec("INSERT INTO  stock_mv(date,qt_mv,id_produit) VALUES('$date',$produit->qt,$produit->id)");
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
            echo ''.$produit->categorie;
        }
    }

    //Tester si produit existe par id
    function existe($id) : bool{
        $reponse=$this->executeRequest("Select * from Produit");
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