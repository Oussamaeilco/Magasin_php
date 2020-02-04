<?php
include 'ResultSet.php';
class MySQLDatabase{
	private $host;
	private $source;
	private $username;
	private $password;
	private $url;
	private $db;
	
	function MySQLDatabase($host,$source,$username,$password){
		$this->host=$host;
		$this->source=$source;
		$this->username=$username;
		$this->password=$password;
		
		$this->url="mysql:host=$host;dbname=$source;";
		$this->db=new PDO($this->url,$this->username,$this->password);
		
	}
	
	public function selectAll($tablename){
		$ps=$this->db->query("SELECT * FROM $tablename");
		return new ResultSet($ps);
	}
	public function select($columnname,$index,$tablename){
		$ps=$this->db->query("SELECT * FROM $tablename WHERE $columnname ='$index'");
		return new ResultSet($ps);
	}
	public function insert($tableName,$row){
		$req="INSERT INTO $tableName VALUES(\"" . $row[0] . "\"";
		$n=count($row);
		for($i=1;$i<$n;$i++){
			$req=$req . ", \"" .$row[$i] ."\"";
		}
		$req=$req .")";
		return $this->db->exec($req);
	}
	public function executeSelect($req){
		$ps=$this->db->query($req);
		return new ResultSet($ps);
	}
	public function execute($req){
		return $this->db->exec($req);
		
	}
	public function delete($columnname,$index,$tablename){
		$ps=$this->db->query("Delete FROM $tablename WHERE $columnname ='$index'");
		return new ResultSet($ps);
	}
	public function update($columnname,$value,$id,$index,$tablename){
		$req="UPDATE $tablename SET $columnname=$value Where $id=$index";
		return $this->db->exec($req);
	}
}