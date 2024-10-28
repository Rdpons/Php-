<?php
	///database helper
	
	function dbconnect(){
		try{
			$conn = new PDO("sqlite:sarisari.db");
			return $conn;
		}
		catch(PDOException $e){ echo $e->getMessage();}
	}
	function getprocess($sql){
		$db = dbconnect();
		$rows = $db->query($sql);
		$db=null; #close the PDO connection
		return $rows;
	}
	function postprocess($sql){
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$ok=$stmt->execute(); #return 1 if SUCCESS else null
		$db=null; #close the PDO connection
		return $ok;
	}
	function getall_records($table){
		$sql = "SELECT * FROM `$table`";
		return getprocess($sql);
	}
	function add_records($table,$fields,$data){
		$ok=null;
		if(count($fields) == count($data)){
			$keys = implode("`,`",$fields);
			$values = implode("','",$data);
			$sql = "INSERT INTO `$table`(`$keys`) VALUES('$values')";
			return postprocess($sql);
		}
	}
	
	function getsales(){
		$sql = "SELECT sales_id,sales_date,customer_name,products.product_code,products.product_name,products.product_price,products.product_unit,qty,products.product_price * qty as total from sales INNER JOIN products ON products.product_id=sales.product_id";
		return getprocess($sql);
	}
	
	
	function delete_records($table,$field,$data){
		$sql = "DELETE FROM `$table` WHERE `$field` =  '$data'";
		return postprocess($sql);
	}
	//testing 123
	
?>