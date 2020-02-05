<?php
	include_once "dao/ProduitsDAO.php";
	include_once "dao/VentesDAO.php";

	$produits=new ProduitsDAO();
	$ventes=new VentesDAO();
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
		background-color: #696969;
	}

	.drawer{
		margin-top: 30px; 
	}

	.main{
		border-top-style: dotted;
  		border-right-style: solid;
  		border-bottom-style: dotted;
  		border-left-style: solid;
		margin-top: 25px;
		border-color: #696969;
		padding: 15px;
	}
		
	table {
		border-collapse: collapse;
		width: 100%;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #f2f2f2;
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
				<span class="sub_btn" onclick="sub_btn_actions(0)">Liste des produits</span> 
				<span class="sub_btn" onclick="sub_btn_actions(1)">Ajouter</span>
				<span class="sub_btn" onclick="sub_btn_actions(2)">Supprimer</span>
				<span class="sub_btn" onclick="sub_btn_actions(3)">Modifier</span>
			</span>
			<!-- Buttons for drawer "sales" -->
			<span hidden="true" id="drawer2">
				<span class="sub_btn" onclick="sub_btn_actions(4)">Nouvelle commande</span>
				<span class="sub_btn" onclick="sub_btn_actions(5)">Facturation</span>
			</span>
		</div>
	</div>
	<div class="main">
		<!-- Show "Products" zone -->
		<div>
			<div id="list_products">
				<?php echo $produits->getListeProducts() ?>
			</div>
			<!-- New Product -->
			<div id="new_product" hidden="true">
				<form action="controller/controller.php" method="POST">
					<input type="hidden" value="addProduit" name="action"/>
					<table>
						<tr>
							<td style="margin-right: 25px;">ID:</td>
							<td><input type="text" name="id" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Nom:</td>
							<td><input type="text" name="nom" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Categorie:</td>
							<td><input type="text" name="categorie" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Prix:</td>
							<td><input type="number" name="prix" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Date début:</td>
							<td><input type="date" name="date_deb" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Date fin:</td>
							<td><input type="date" name="date_fin" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Quantité:</td>
							<td><input type="number" name="qt" required/></td>	
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Confirmer"/></td>
						</tr>
					</table>
				</form>
			</div>
			
			<!-- Delete Product -->
			<div id="delete_product" hidden="true">
				<form action="controller/controller.php" method="POST">
					<input type="hidden" value="deleteProduit" name="action"/>
					<div>
						<span style="margin-right: 25px;">Produit :</span>
						<span>
								<select name="id" id="delete_id" onchange="">
									<?php 
										foreach($produits->getProducts() as $index => $product){
									?>
									<option value="<?php echo $index ?>"><?php echo $product ?></option>
									<?php 
										}
									?>
								</select>
						</span>
					
					<input type="submit" value="Supprimer"/>
					</div>
				</form>
			</div>
			
			<!-- Modify Product -->	
			<div id="modify_product" hidden="true">
				<?php echo $produits->getListeProductsModify() ?>
			</div>

		</div>

		<!-- Show "Ventes" zone -->
		<div>
			<!--Nouvelle commande-->
			<div id="nouvelle_commande" hidden="true">
				<?php echo $ventes->getCatalogue() ?>
			</div>
			<!--Facture-->
			<div id="facture" hidden="true">
				Facture
			</div>
		</div>
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

		//function switch between sub menus
		function sub_btn_actions(value){
			var list=$("#list_products");
			var nw=$("#new_product");
			var dl=$("#delete_product");
			var mod=$("#modify_product");
			var cmd=$("#nouvelle_commande");
			var fct=$("#facture");
			if(value == 0){
				list.show();
				nw.hide();
				dl.hide();
				mod.hide();
				cmd.hide();
				fct.hide();
			}
			else if(value == 1){
				
				list.hide();
				nw.show();
				dl.hide();
				mod.hide();
				cmd.hide();
				fct.hide();
			}
			else if(value == 2)
			{
				
				list.hide();
				nw.hide();
				dl.show();
				mod.hide();
				cmd.hide();
				fct.hide();
			}
			else if(value == 3){
				
				list.hide();
				nw.hide();
				dl.hide();
				mod.show();
				cmd.hide();
				fct.hide();
			}
			else if(value == 4){
				
				list.hide();
				nw.hide();
				dl.hide();
				mod.hide();
				cmd.show();
				fct.hide();
			}
			else if(value == 5){
				
				list.hide();
				nw.hide();
				dl.hide();
				mod.hide();
				cmd.hide();
				fct.show();
			}
		}

	</script>
</body>
</html>