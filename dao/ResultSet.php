<?php
class ResultSet{
	private $rowCount;
	private $columnCount;
	private $data;
	private $fields;
	
	
	function ResultSet(PDOStatement  $ps){
		$this->rowCount=$ps->rowCount();
		$this->columnCount=$ps->columnCount();
		$this->data=array();
		$this->fields=array();
		for($i=0;$i<$this->columnCount;$i++){
			$meta=$ps->getColumnMeta($i);
			$this->fields[$i]=$meta["name"];
		}
		$this->data[]=$this->fields;
		$i=0;
		foreach ($ps as $row){
			$i++;
			for($j=0;$j<$this->columnCount;$j++){
				$this->data[$i][$j]=$row[$j];	
			}
		}
	}
	public function getData(){
		return $this->data;
	}
	
	public function getRow($index){
		return $this->data[$index];
	}
	public function getColumn($index){
		$t=array();
		for($i=0;$i<($this->rowCount);$i++){
			$t[$i]=$this->data[$index];
		}	
		return $t;
	}
	public function getColumnName($index){
		return $this->fields[$index];
	}
	public function getColumnCount(){
		return $this->columnCount;
	}
	public function getRowCount(){
		return $this->rowCount;
	}
}