<?php
class HTMLFactory{
	public function HTMLFactory(){
	}
	//transforme le resultat en code html
	public static function toTable($data,$min=1,$max=-1){
		$t="";
		$n=count($data[0]);
		
		if($max==-1){
			$m=count($data);
		}
		else
		{
			$m=$max;
		}
		for($j=$min;$j<$m;$j++){
			$t=$t ."<tr>";
			for ($i=1;$i<$n;$i++){
				
				
					$t=$t . "<td style='padding :5px;'>" . $data[$j][$i] . "</td>";
				
			}
			$t=$t ."</tr>";
		}
		return $t;
	}	
}