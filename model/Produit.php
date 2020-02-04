<?php
class Produit{
    var $id ;
    var $nom;
    var $categorie;
    var $prix;
    var $date_deb;
    var $date_fin;
    var $qt;
    function __construct($id,$nom,$categorie,$prix,$date_deb,$date_fin,$qt)
    {
        $this->id=$id;
        $this->nom=$nom;
        $this->categorie=$categorie;
        $this->prix=$prix;
        $this->date_deb=$date_deb;
        $this->date_fin=$date_fin;
        $this->qt=$qt;
    }

}