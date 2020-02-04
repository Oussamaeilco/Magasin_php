<?php

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Acceuill</title>
<link href='https://fonts.googleapis.com/css?family=Merienda' rel='stylesheet'>
<style>
	.btn{
		border: thick;
		border-color: black;
		color: white;
		font-size: 25px;
		background-color: #B0C4DE; 
		padding: 10px;
		font-size: 25px;
		margin: 10px;
		border-radius: 12px;
		cursor: pointer;
		
	}
	
	.sub_btn{

		border: thick;
		border-color: black;
		color: white;
		font-size: 25px;
		background-color: #87CEEB; 
		padding: 10px;
		font-size: large;
		border-radius: 12px;
		cursor: pointer;
		margin: 10px;
	}

	.Title{
		border: thick;
		font-size: 75px;
		font-family: 'Merienda';
		padding: 10px;
		border-radius: 13 px;
		margin: 10px;
		color: white;
	}

	.header{
		background-color: #A9A9A9;
	}

	.drawer{
		margin-top: 30px; 
	}
</style>
</head>
<body>
	<div class="header">
		<div style="text-align: center;" class="Title">Magasin</div>
		<div >
			<span class="btn" id="products" onclick="show_drawer('products')">Produits</span>
			<span class="btn" id="sales" onclick="show_drawer('sales')">Ventes</span>
		</div>
		<div hidden="true" id="drawer" class="drawer">
			<!-- Buttons for drawer "products" -->
			<span hidden="true" id="drawer1">
				<span class="sub_btn">Liste des produits</span> 
				<span class="sub_btn">Ajouter</span>
				<span class="sub_btn">Supprimer</span>
				<span class="sub_btn">Modifier</span>
			</span>
			<!-- Buttons for drawer "sales" -->
			<span hidden="true" id="drawer2">
				<span class="sub_btn">Nouvelle commande</span>
				<span class="sub_btn">Facturation</span>
			</span>
		</div>
	</div>
	
	<!-- Show "Products" zone -->
	<div>

	</div>

	<!-- Show "Ventes" zone -->
	<div>

	</div>

	<!-- Script JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		//function open drawers
		function show_drawer(value){
			var drawer=$("#drawer");
			var drawer1=$("#drawer1");
			var drawer2=$("#drawer2");

			if(value=="products"){
				if(!(drawer.is(':visible') && drawer1.is(':visible') && drawer2.is(':hidden')))
				{		
					drawer1.show();
					drawer2.hide();
					if(drawer.is(':hidden')){
						drawer.toggle(500);
					}
				}
				else
				{
					drawer.toggle(500);
					drawer1.hide();
					drawer2.hide();
				}
			}
			else if(value=="sales")
			{	
				if(!(drawer.is(':visible') && drawer1.is(':hidden') && drawer2.is(':visible')))
				{		
					drawer1.hide();
					drawer2.show();
					if(drawer.is(':hidden')){
						drawer.toggle(500);
					}
				}
				else{
					drawer.toggle(500);
					drawer1.hide();
					drawer2.hide();
				}
			}
		}
	</script>
</body>
</html>