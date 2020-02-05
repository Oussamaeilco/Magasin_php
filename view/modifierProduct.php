<?php
	 $id=-1;
    if(isset($_GET["id"])){
        $id=$_GET["id"];
    }
    
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
    </div>
    <div style="border: red dotted thick; padding: 15px; margin: 25px;">
        <form action="../controller/controller.php" method="POST">
            <input type="hidden" value="validerModification" name="action"/>        
            <input type="hidden" value="<?php echo $id?>" name="id"/>
            <table>
						<tr>
							<td style="margin-right: 25px;">Nom:</td>
							<td><input type="text" name="nom" required/></td>
						</tr>
						<tr>
							<td style="margin-right: 25px;">Categorie:</td>
							<td><input type="text" name="categorie" required/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Confirmer"/></td>
						</tr>
			</table>
        </form>
        <form action="../controller/controller.php" method="POST">
            <input type="hidden" value="home" name="action"/>        
            <input type="submit" value="annuler"/>
        </form>
    </div>
</body>
</html>