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
    //Afficher facture
    function getFacture(){
        $req="SELECT v.*,A.nom,A.quantite as QTT,pr.valeur as PrixU, A.quantite*pr.valeur as Prix
        FROM ventes v,(SELECT pv.quantite,pv.id_produit,pv.id_ventes,p.nom,p.categorie FROM magasin.produit_vente pv, produit p where p.id=pv.id_produit) as A,
        prix pr where v.id=A.id_ventes and  pr.id_produit=A.id_produit and  pr.id=( select max(B.id) from prix B where B.id_produit=A.id_produit ) order by v.id";
        try{
            $reponse = $this->bd->executeRequest($req);
        }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $id_ventes=-1;
        $date_ventes="";
        $prix_totale=0;
        $str="";
        $first=true;
        while($donnees=$reponse->fetch()){
            if($id_ventes!=$donnees["id"]){
                if($first){$first=false; } else{
                     $str.="</table>
                     <div style='margin-top:10px;font-weight: bold; color: green;'>ID Facture: $id_ventes  || Date: $date_ventes   || Montant Totale: $prix_totale €</div>
                     </div>\n"; 
                    }
                
                $id_ventes=$donnees["id"];
                $date_ventes=$donnees["date"];
                $prix_totale=$donnees["prix_totale"];
                
                $str.="<div style='margin-top:10px;' class='main'>";
                //$str.="<div style='margin-top:10px;font-weight: bold; color: green;'>ID Facture: $id_ventes  || Date: $date_ventes   || Montant Totale: $prix_totale €</div>";
                $str.="<table><tr>";
                $str.="<th>Produit</th><th>Unités Vendus</th><th>Prix Unitaire</th><th>Montant</th></tr>";
                $str.="<tr><td>".$donnees["nom"]."</td><td>".$donnees["QTT"]."</td><td>".$donnees["PrixU"]."    €</td><td>".$donnees["Prix"]."   €</td></tr>";
            }
            else{
                $str.="<tr><td>".$donnees["nom"]."</td><td>".$donnees["QTT"]."</td><td>".$donnees["PrixU"]."    €</td><td>".$donnees["Prix"]."   €</td></tr>";
            }
        }
        $str.="</table>
        <div style='margin-top:10px;font-weight: bold; color: green;'>ID Facture: $id_ventes  || Date: $date_ventes   || Montant Totale: $prix_totale €</div>
        </div>\n"; 
       
        
        $reponse->closeCursor();
        return $str;
    }
    /*-------------------------------------*/
    //Créer commande
    function createCommande($array){
        try{
            //Create vente
            $date=date("Y/m/d");
            $this->pdo->exec("INSERT INTO ventes(date,prix_totale) Values('$date',0)");
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
                    $reponse=$this->bd->executeRequest("SELECT * FROM prix where id_produit=$i order by id desc limit 1");
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