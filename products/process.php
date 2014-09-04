<?php 
	if(isset($_GET['action'])){
	 $action	=	$_GET['action'];
	}
	if(isset($_GET['id'])){
	$id		=	$_GET['id'];	
	}
	
	global $wpdb;
	$table	=	$wpdb->prefix.'paypal_products';
	
	
	
	if($action=='update'){
		
		if($_POST['updateprod']){
				$product_name				=	$_POST['product_name'];
				$product_price				=	$_POST['product_price'];
	
				$shortcode	=	str_replace(" ","-", $product_name);
				$shortcode	=	'[wp-paypal-product prodname="'.$shortcode.'"]'; 
	
	
	
				$data	=	array(
				'product_name' 				=> $product_name,
				'product_price' 			=> $product_price,
				'shortcode' 				=> $shortcode,
				

				);
				if(!empty($product_name) && !empty($product_price)){
				$ID		=	array('id'	=>	$id);
				$update			=	$wpdb->update($table,$data,$ID);
					$prod	=	"Product Updated Successfullly";
				}else{
					$eprod	=	"All fields are required";	
				}

		}
		
	}elseif($action=='delete'){
	    $delete		=	$wpdb->query("DELETE FROM $table WHERE id='$id'");
	}else{
	
			if($_POST['addprod']){
				$product_name				=	$_POST['product_name'];
				$product_price				=	$_POST['product_price'];
	
				$shortcode	=	str_replace(" ","-", $product_name);
				$shortcode	=	'[wp-paypal-product prodname="'.$shortcode.'"]'; 
	
	
	
				$data	=	array(
				'product_name' 				=> $product_name,
				'product_price' 			=> $product_price,
				'shortcode' 				=> $shortcode,
				

				);
				if(!empty($product_name) && !empty($product_price)){
	
				$insert		=	$wpdb->insert($table,$data) or die(mysql_error());
					$prod	=	"Product Added Successfullly";
				}else{
					$eprod	=	"All fields are required";
				}

		}
	
	}
$singleprod	 = 	$wpdb->get_row("SELECT * FROM $table WHERE id ='$id'"); 
?>