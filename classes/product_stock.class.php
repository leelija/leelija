<?php 
/**
*	This class is going to work with all stock associated with a particular category. 
*
*	@author		Safikul Islam
*	@date		jan 3, 2017
*	@version	1.0
*	@copyright	MIS
*	@url		http://www.monienterprises.com
*	@email		safikulislamwb@gmail.com
* 
*/




class ProductStock 
{

	#####################################################################################################
	#
	#										Add To Stock Product
	#
	#####################################################################################################
	
	/**
	*	Add a new design to product stock in stock table.
	*
	*	@param
	*			
	*			$stock_id			    stock_id	
	*			$design_no				Design no of  products
	*			$stock			     	stock 
	*			$product_in				product_in
	*			$sales					sales product
	*			$goods_return			return goods
	*			$remarks					Remark
	*			$date     		    	date
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addStockProduct($design_no, $stock,$product_in, $sales, $net_sales,  $goods_return,$remarks,$factory_id,$add_date, $added_by)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        =	trim($design_no);
		$stock			   	= 	mysql_real_escape_string(trim($stock));
		$product_in			=	mysql_real_escape_string(trim($product_in));
		$sales		       	=	mysql_real_escape_string(trim($sales));
		$net_sales		    =	mysql_real_escape_string(trim($net_sales));
		$goods_return		=	mysql_real_escape_string(trim($goods_return));
		$remarks		   	=	mysql_real_escape_string(trim($remarks));
		$factory_id		   	=	mysql_real_escape_string(trim($factory_id));
		$add_date			=	mysql_real_escape_string(trim($add_date));
		$added_by			=	mysql_real_escape_string(trim($added_by));

		//satement to insert in stock_products table
		$insert		=   "INSERT INTO stock_products
						(design_no, stock, product_in, sales, net_sales, goods_return,remarks,factory_id,add_date,added_on, added_by)
							
						VALUES
						('$design_no', '$stock', '$product_in', '$sales', '$net_sales', '$goods_return', 
							'$remarks','$factory_id','$add_date','$add_date', '$added_by')
							
						";
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$stock_id	= mysql_insert_id();
		
		//return primary key
		return $stock_id;

	}//eof
		
	
	

	
	
	#####################################################################################################
	#
	#										Edit Stock Product
	#
	#####################################################################################################
	
	
	/**
	*	This function edit stock Product
	*
	*	@param
	*			$stock_id			    stock_id	
	*			$design_no				Design no of  products
	*			$stock			     	stock 
	*			$product_in				product_in
	*			$sales					sales product
	*			$goods_return			return goods
	*			$remarks					Remark
	*			$add_date     		    	add_date
	*			
	*		
	*			
	*	@return null
	*/
	function editStockProduct($stock_id,$design_no, $stock,$product_in, $sales, $net_sales, $goods_return,$remarks,$add_date, $modified_by)
	
	{
		$stock_id			   	=	mysql_real_escape_string(trim($stock_id));
		$design_no	        	=	trim($design_no);
		$stock			   		= mysql_real_escape_string(trim($stock));
		$product_in			   	=	mysql_real_escape_string(trim($product_in));
		$sales		       		=	mysql_real_escape_string(trim($sales));
		$net_sales		       	=	mysql_real_escape_string(trim($net_sales));
		$goods_return			=	mysql_real_escape_string(trim($goods_return));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$add_date				=	mysql_real_escape_string(trim($add_date));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));


		//update stock_products description
		$edit  = "UPDATE stock_products
				SET
				design_no		 		= '$design_no',
				stock			        = '$stock',
				product_in				= '$product_in',
				sales 					= '$sales',
				net_sales 				= '$net_sales',
				goods_return		    = '$goods_return',
				remarks					= '$remarks',
				add_date				= '$add_date',
				modified_on				= now(),
				modified_by				= '$modified_by'
				WHERE
				stock_id 				= '$stock_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof

	function editProductStockDesignNo($stock_id,$design_no, $remarks,$modified_by)
	 {
		$stock_id			   	=	mysql_real_escape_string(trim($stock_id));
		$design_no	        	=	trim($design_no);
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));


		//update stock_products description
		$edit  = "UPDATE stock_products
				SET
				design_no		 	= '$design_no',
				remarks				= '$remarks',
				modified_on			= now(),
				modified_by			= '$modified_by'
				WHERE
				stock_id 			= '$stock_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	function editProductStockQty($design_no, $stock,$product_in, $modified_by)
	 {
		
		$design_no	        	=	trim($design_no);
		$stock			   		=	mysql_real_escape_string(trim($stock));
		$product_in		   		=	mysql_real_escape_string(trim($product_in));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));


		//update stock_products description
		$edit  = "UPDATE stock_products
				SET
				stock		 			= '$stock',
				product_in				= '$product_in',
				modified_on				= now(),
				modified_by				= '$modified_by'
				WHERE
				design_no 				= '$design_no'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	// Edit net sales
	function editProdstockNsales($stock_id, $net_sales)
	 {
		$stock_id			   	=	mysql_real_escape_string(trim($stock_id));
		$net_sales		   		=	mysql_real_escape_string(trim($net_sales));
		//update stock_products net sales description
		$edit  = "UPDATE stock_products
				SET
				net_sales		 			= '$net_sales'
				WHERE
				stock_id 				= '$stock_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	#####################################################################################################
	#
	#										Delete from stock_products
	#
	#####################################################################################################
		
	
	/**
	*	This function will delete a order permanently
	*
	*	@param
	*			$sid			sid
	*
	*	@return null
	*/
	function delProductStock($sid)
	{
		
		//delete from stock_products
		$delete1 = "DELETE FROM stock_products WHERE design_no='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	/**
	*	This function will delete a stock product details permanently
	*
	*	@param
	*			$sid			stock id
	*
	*	@return null
	*/
	function delStockDtlDes($sid,$design_no)
	{
		//delete from product
		$delete1 = "DELETE FROM stock_products_details WHERE design_no ='$design_no' AND stock_id != '$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//
	
	function delStockInDtlDes($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM product_in WHERE design_no='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//
	
	function delStocksalesDtlDes($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM product_sales WHERE design_no='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//
	
	function delStockReturnDtlDes($sid)
	{
		//delete from product
		$delete1 = "DELETE FROM goods_return WHERE design_no='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//

	
	#####################################################################################################
	#
	#										Display  Stock products 
	#
	#####################################################################################################	

	/**
	*	Get the data associated with a stock based upon the primary key
	*
	*	@param
	*			$sid		stock id
	*
	*	@return array				
	*/
	function showProductStock($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_products
				   WHERE stock_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,				//0
					$result->design_no,				//1
					$result->stock,					//2
					$result->product_in,			//3
					$result->sales,					//4
					$result->goods_return,			//5
					$result->remarks,				//6
					$result->add_date,				//7
					$result->added_on,				//8
					$result->added_by,				//9
					$result->modified_on,			//10
					$result->modified_by,			//11
					$result->net_sales,				//12
					$result->factory_id			     //13

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
	/**
	*	Get the data associated with a stock based upon the primary key
	*
	*	@param
	*			$sid		stock products id
	*
	*	@return array				
	*/
	function showPStockDesignwise($design_no)
	{
		//echo $design_no;exit;
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_products
				   WHERE design_no	= '$design_no'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,			//0
					$result->design_no,			//1
					$result->stock,				//2
					$result->product_in,		//3
					$result->sales,				//4
					$result->goods_return,		//5
					$result->remarks,			//6
					$result->add_date,			//7
					$result->added_on,			//8
					$result->added_by,			//9
					$result->modified_on,		//10
					$result->modified_by,		//11
					$result->net_sales,			//12
					$result->factory_id			//13
					);
		}
		//return the data
		return $data;
	}//eof
	
	
	
	/**
	*	Get the data associated with a Product stock based upon the primary key
	*
	*	@param
	*			
	*	@return array				
	*/
	function showProdStockDtl()
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_products";
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,			//0
					$result->design_no,			//1
					$result->stock,				//2
					$result->product_in,		//3
					$result->sales,				//4
					$result->goods_return,		//5
					$result->remarks,			//6
					$result->add_date,			//7
					$result->added_on,			//8
					$result->added_by,			//9
					$result->modified_on,		//10
					$result->modified_by		//11
					);
		}
		//return the data
		return $data;
		
	}//eof
	
	
	/* Display all data  */
	/*
	*/
	 public function getpStock(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products ORDER BY net_sales DESC limit 60") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	/* 	Factory wise top selling list
	*	Display all data  */
	/*
	*/
	 public function getFactTopStock($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products where factory_id ='$factory_id' ORDER BY net_sales DESC limit 60") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
  // Last two month data display
	public function ProductstockAllDisplay(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products order by stock_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	 
	// Last two month data display
	public function ProdDesWiseCount(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products WHERE stock != 0 order by stock desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	 
	 /* sum of current products stock all data */
	/*
	*/
	 public function CurrentProdstockSum(){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( stock ) AS `count_stock` FROM `stock_products` ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_stock'];
     }
     return $temp_arr;  
     }
	 /* sum of current products stock all data */
	/*
	*/
	 public function factoryWiseStock($factory_id,$fac2){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( stock ) AS `count_stock` FROM `stock_products` where factory_id = '$factory_id' OR factory_id = '$fac2'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_stock'];
     }
     return $temp_arr;  
     } 
	 
	 
	// Factory wise production display
	public function getFacWiseStock($factory_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products WHERE factory_id = '$factory_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }  
	 
	// Display Due Order Details group by colour
	 public function getProdStatDesignWise($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(product_in),colour FROM stock_products where design_no = '$design_no' 
	 AND due_quantity != '0' AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by colour") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	 
	 // Product Count
	 public function getProdStatDwCount($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(product_in),SUM(sales), SUM(net_sales) FROM stock_products where design_no = '$design_no' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	 
	/*
	*	This funcion will return all the stock_id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProdStock($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT stock_id FROM stock_products";
		}
		else
		{
			//statement
			$select	= "SELECT stock_id FROM stock_products
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['stock_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	


#####################################################################################################
	#						/*--------------------Stock Details--------------*/
	#										Add To Stock Details
	#
	#####################################################################################################
	
	/**
	*	Add a new design to stock  in stock details table.
	*
	*	@param
	*			
	*			$stock_id			    stock_id	
	*			$colour					colour
	*			$quantity			    quantity
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addstockProdDetails($stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return, $added_by)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$stock_id	        	=	trim($stock_id);
		$design_no			   	=	mysql_real_escape_string(trim($design_no));
		$colour			   		= mysql_real_escape_string(trim($colour));
		$quantity			   	= mysql_real_escape_string(trim($quantity));
		$quantity_in			=	mysql_real_escape_string(trim($quantity_in));
		$sales			   		= mysql_real_escape_string(trim($sales));
		$net_sales			   	= mysql_real_escape_string(trim($net_sales));
		$quantity_return		= mysql_real_escape_string(trim($quantity_return));
		$added_by			   	=	mysql_real_escape_string(trim($added_by));
		


		
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO stock_products_details
						(stock_id, design_no ,colour, quantity,quantity_in, sales ,net_sales, quantity_return, added_on, added_by)
							
						VALUES
						('$stock_id','$design_no', '$colour', '$quantity','$quantity_in', '$sales' ,'$net_sales', '$quantity_return', now(), '$added_by')
							
						";
						
						
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$stock_dtl_id	= mysql_insert_id();
		
		//return primary key
		return $stock_dtl_id;

	}//eof
	
	
	/**
	*	This function edit stock details
	*
	*	@param
	*			$stock_dtl_id			    stock details id
	*			$stock_id			    stock_id	
	*			$design_no				Design no of  products
	*			$colour			     	colour 
	*			$quantity				product quantity
	*			
	*			
	*		
	*			
	*	@return null
	*/
	function editstockProdDetails( $stock_dtl_id,$stock_id, $design_no, $colour,$quantity,$quantity_in,$sales,$net_sales,$quantity_return,$added_on, $modified_by)
	 
	{
		$stock_dtl_id			   	=	mysql_real_escape_string(trim($stock_dtl_id));
		$stock_id	        		=	trim($stock_id);
		$design_no			   		=	mysql_real_escape_string(trim($design_no));
		$colour			   			= mysql_real_escape_string(trim($colour));
		$quantity			   		= mysql_real_escape_string(trim($quantity));
		$quantity_in			   	=	mysql_real_escape_string(trim($quantity_in));
		$sales			   			= mysql_real_escape_string(trim($sales));
		$net_sales			   		= mysql_real_escape_string(trim($net_sales));
		$quantity_return			= mysql_real_escape_string(trim($quantity_return));
		$added_on			   		=	mysql_real_escape_string(trim($added_on));
		$modified_by			   	=	mysql_real_escape_string(trim($modified_by));


		//update stock_products_details description
		$edit  = "UPDATE stock_products_details
				SET
				stock_id		 				= '$stock_id',
				design_no		 				= '$design_no',
				colour							= '$colour',
				quantity 						= '$quantity',
				quantity_in		 				= '$quantity_in',
				sales		 					= '$sales',
				net_sales						= '$net_sales',
				quantity_return 				= '$quantity_return',
				modified_by						= '$modified_by',
				modified_on						= now()
				WHERE
				stock_dtl_id 					= '$stock_dtl_id' 
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// Edit stock details by stock id
	function editStockDtlsDsnNo($stock_id,$design_no, $modified_by)
	 {
		$stock_id			   	=	mysql_real_escape_string(trim($stock_id));
		$design_no	        	=	trim($design_no);
		$modified_by			=	mysql_real_escape_string(trim($modified_by));


		//update stock_details description
		$edit  = "UPDATE stock_details
				SET
				design_no		 		= '$design_no',
				modified_on			= now(),
				modified_by			= '$modified_by'
				WHERE
				stock_id 			= '$stock_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	
	
	
	function editstockCurrentprod($stock_id,$stock)
	 
	{
		$stock_id	        =	trim($stock_id);
		$stock			   =	mysql_real_escape_string(trim($stock));
		
		//update stock_details description
		$edit  = "UPDATE stock
				SET
				stock 					= '$stock',
				modified_on					= now()
				WHERE
				stock_id 			= '$stock_id' 
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	// Edit stock details by stock id
	function editStockDtlsDsnNoColor($design_no,$colour,$quantity,$quantity_in, $modified_by)
	 {
		
		$design_no	        	=	trim($design_no);
		$colour			   		=	mysql_real_escape_string(trim($colour));
		$quantity	        	=	trim($quantity);
		$quantity_in			=	mysql_real_escape_string(trim($quantity_in));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));


		//update stock_details description
		$edit  = "UPDATE stock_details
				SET
				colour		 		= '$colour',
				quantity		 	= '$quantity',
				quantity_in		 	= '$quantity_in',
				modified_on			= now(),
				modified_by			= '$modified_by'
				WHERE
				design_no 			= '$design_no' AND colour ='$colour'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	// Edit stock product details net sales
	function editProdstocDtlskNsales($stock_dtl_id, $net_sales)
	 {
		$stock_dtl_id			=	mysql_real_escape_string(trim($stock_dtl_id));
		$net_sales		   		=	mysql_real_escape_string(trim($net_sales));
		//update stock_products net sales description
		$edit  = "UPDATE stock_products_details
				SET
				net_sales		 			= '$net_sales'
				WHERE
				stock_dtl_id 				= '$stock_dtl_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	/*
	*	This funcion will return all the stock_dtl_id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllStockProdDetails($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT stock_dtl_id FROM stock_products_details";
		}
		else
		{
			//statement
			$select	= "SELECT stock_dtl_id FROM stock_products_details
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['stock_dtl_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	/**
	*	Get the data associated with a stock details based upon the primary key
	*
	*	@param
	*			$sid		stock_dtl_id
	*
	*	@return array				
	*/
	function showStockProdDetails($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_products_details
				   WHERE stock_dtl_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,				//0
					$result->design_no,				//1
					$result->colour,				//2
					$result->quantity,				//3
					$result->added_on,				//4
					$result->added_by,				//5
					$result->modified_on,			//6
					$result->modified_by,			//7
					$result->stock_dtl_id,			//8
					$result->quantity_in,			//9
					$result->sales,					//10
					$result->net_sales,				//11
					$result->quantity_return		//12
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof

	
	
	/**
	*	Get the data associated with a stock details based upon the design_no and color
	*
	*	@param
	*			$design_no		stock design no
	*			$colour			stock color
	*
	*	@return array				
	*/
	function showPStockDetailsdescolorwise($design_no,$colour)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_products_details
				   WHERE design_no	= '$design_no' and colour = '$colour'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->stock_id,					//0
					$result->design_no,					//1
					$result->colour,					//2
					$result->quantity,					//3
					$result->added_on,					//4
					$result->added_by,					//5
					$result->modified_on,				//6
					$result->modified_by,				//7
					$result->stock_dtl_id,				//8
					$result->quantity_in,				//9
					$result->sales,						//10
					$result->net_sales,					//11
					$result->quantity_return			//12
					

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	
	
	
	
//  Display all stock product data */
	/*
	//
	*/
	
	 public function stockProdDetailsDisplay(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_details order by stock_dtl_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	 
	 
	public function GetstockDetlDisplay(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_details group by colour ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 


	
 public function stockProdDtlColor($stock_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_details where stock_id = '$stock_id' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	public function stockPDtlNetColor($stock_id){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_details where stock_id = '$stock_id' AND quantity != 0 ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	public function ProdstockDtlDes($DesignNo){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_details where design_no = '$DesignNo' AND quantity != 0") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	 

	public function ProdstockDtl($DesignNo){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_details where design_no = '$DesignNo' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	 /* Display all stock Product details data*/
	 public function getAllProdStockData(){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( quantity ) AS `count_stock` FROM `stock_products_details` ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         /*$temp_arr[] =$row;
		 echo $row['count_stock'];*/
     }
     return $temp_arr;  
     }
	
	
	 public function DisStockProdCD($colour,$design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_details where design_no='$design_no' AND colour='$colour' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	
	
	
	/**
	*	This function will delete a order permanently
	*
	*	@param
	*			$sid			sid
	*
	*	@return null
	*/
	function delStockDetails($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM stock_details WHERE stock_dtl_id ='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	
	
	
#####################################################################################################
	#										product in details
	#										Add stock product in  
	#
	#####################################################################################################
	
	/**
	*	Add a new design to stock in stock table.
	*
	*	@param
	*			
	*			$product_in_id			product in id	
	*			$design_no				Design no of  products
	*			$product_in			    product_in
	*			$remarks					Remark
	
	*			$date     		    	date
	*	@return int
	*/
	function addStockProductIn($design_no,$bil_no, $product_in, $colour, $remarks,$added_on, $added_by)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        	=	trim($design_no);
		$bil_no	          		=	trim($bil_no);
		$product_in			   	=	mysql_real_escape_string(trim($product_in));
		$colour			   		=	mysql_real_escape_string(trim($colour));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$added_on				=	mysql_real_escape_string(trim($added_on));
		$added_by				=	mysql_real_escape_string(trim($added_by));
		/*$modified_on			=	mysql_real_escape_string(trim($modified_on));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));*/
		//satement to insert in stock product table
		$insert		=   "INSERT INTO stock_product_in
						(design_no,bil_no, product_in, colour, remarks,added_on, added_by)
							
						VALUES
						('$design_no','$bil_no', '$product_in', '$colour', 
							'$remarks',now(), '$added_by')
							
						";			
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$product_in_id	= mysql_insert_id();
		
		//return primary key
		return $product_in_id;

	}//eof
	
	
	/**
	*	Edit a design to stock in stock table.
	*
	*	@param
	*			
	*			$product_in_id			product in id	
	*			$design_no				Design no of  products
	*			$product_in			    product_in
	*			$remarks					Remark
	
	*			$date     		    	date
	*			
	*		
	*			
	*
	*	@return int
	*/
	function editProductIn($product_in_id,$design_no,$bil_no, $product_in, $colour, $remarks,$added_on, $modified_by)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        =	trim($design_no);
		$bil_no	            =	trim($bil_no);
		$product_in			   =	mysql_real_escape_string(trim($product_in));
		$colour			   =	mysql_real_escape_string(trim($colour));
		$remarks		   =	mysql_real_escape_string(trim($remarks));
		$added_on			=	mysql_real_escape_string(trim($added_on));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));
		/*$modified_on			=	mysql_real_escape_string(trim($modified_on));
		$modified_by			=	mysql_real_escape_string(trim($modified_by));*/
		//update stock_details description
		$edit  = "UPDATE product_in
				SET
				design_no		 				= '$design_no',
				bil_no							= '$bil_no',
				product_in 					= '$product_in',
				colour		 				= '$colour',
				remarks		 				= '$remarks',
				added_on					= '$added_on',
				modified_by					= '$modified_by',
				modified_on					= now()
				WHERE
				product_in_id 			= '$product_in_id' 
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
		
	/*
	*	This funcion will return all the product in id
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProductIn($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT product_in_id FROM product_in";
		}
		else
		{
			//statement
			$select	= "SELECT product_in_id FROM product_in
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['product_in_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a product in  based upon the primary key
	*
	*	@param
	*			$pinid		product_in_id 
	*
	*	@return array				
	*/
	function showStockProductIn($pinid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_product_in
				   WHERE product_in_id	= '$pinid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->product_in_id,					//0
					$result->design_no,							//1
					$result->product_in,						//2
					$result->remarks,						//3
					$result->added_on,					//4
					$result->added_by,						//5
					$result->modified_on,						//6
					$result->modified_by,						//7
					$result->colour,						//8
					$result->bil_no						//9

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// All Stock product in data show
	public function stockProdInData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_in order by product_in_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	
	// All Complte Stock product in data show
	// $bid 		= bill no
	public function stockCompInData($bid){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_in where bil_no ='$bid' order by product_in_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Stock product in display design no wise
	// $design_no 		= Design No
	public function getStockInDesignWise($design_no,$todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_in where design_no ='$design_no' AND
	 added_on between '$todate' and '$fromdate'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	// 
	// Date wise stock in report
	public function getStockInDesDaily($design_no,$todate){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_in where design_no ='$design_no' AND
	 added_on ='$todate' ") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	 
	// Display Product In Details group by Date
	 public function getsProdInDateWise($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(product_in),added_on FROM stock_product_in where design_no = '$design_no' 
	  AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by added_on order by added_on desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }  
	 //last two moth order display 
	public function lTwoMonthProdIn($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( product_in ) AS `product_in` FROM `stock_product_in` where design_no ='$design_no'
	 AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['product_in'];
     }
     return $temp_arr;  
     } 
	
	
	//last two moth order display 
	public function dMonthsProdIn($design_no,$months){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( product_in ) AS `product_in` FROM `stock_product_in` where design_no ='$design_no'
	 AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL '$months' MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['product_in'];
     }
     return $temp_arr;  
     } 
	
	/**
	*	This function will delete a product in permanently
	*
	*	@param
	*			$sid			product in id
	*
	*	@return null
	*/
	function delStockProductIn($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM stock_product_in WHERE product_in_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
			
	
#####################################################################################################
	#
	#										Add Sales data into product_sales table
	#
	#####################################################################################################
	
	/**
	*	Add a new sales into product_sales table.
	*
	*	@param
	*			
	*			$sales_id			    sales_id	
	*			$design_no				Design no of  products
	*			$sales			     	sales 
	*			$company				company
	*			$address				address
	*			$contact_no				contact_no
	*			$remarks					Remark
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addStockProdSales($design_no, $sales,$sale_colour,$company, $address, $contact_no, $remarks, $prodstatus, $added_by)
	
	{
		/*$stock_id			   	   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        	   =	trim($design_no);
		$sales			   		   = mysql_real_escape_string(trim($sales));
		$sale_colour			   = mysql_real_escape_string(trim($sale_colour));
		$company			  	   =	mysql_real_escape_string(trim($company));
		$address			 	   =	mysql_real_escape_string(trim($address));
		$contact_no				   =	mysql_real_escape_string(trim($contact_no));
		$remarks		  		   =	mysql_real_escape_string(trim($remarks));
		$prodstatus		  		   =	mysql_real_escape_string(trim($prodstatus));
		$added_by			       =	mysql_real_escape_string(trim($added_by));

		//echo $contact_no;exit;
		//satement to insert in stock table
		$insert		=   "INSERT INTO stock_product_sales
						(design_no, sales, sale_colour, company, address, contact_no,remarks,prodstatus, added_on, added_by)
							
						VALUES
						('$design_no', '$sales', '$sale_colour', '$company', '$address','$contact_no', 
							'$remarks', '$prodstatus',now(), '$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$sales_id	= mysql_insert_id();
		
		//return primary key
		return $sales_id;

	}//eof
	
	/*Edit sales table*/
	function editSales($sales_id,$design_no, $sales,$sale_colour,$company, $address, $contact_no,$remarks, $modified_by)
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        	   =	trim($design_no);
		$sales			   		   = mysql_real_escape_string(trim($sales));
		$sale_colour			   = mysql_real_escape_string(trim($sale_colour));
		$company			  	   =	mysql_real_escape_string(trim($company));
		$address			 	   =	mysql_real_escape_string(trim($address));
		$contact_no				   =	mysql_real_escape_string(trim($contact_no));
		$remarks		  		   =	mysql_real_escape_string(trim($remarks));
		$modified_by			   =	mysql_real_escape_string(trim($modified_by));
		//update stock_details description
		$edit  = "UPDATE product_sales
				SET
				design_no		 				= '$design_no',
				sales							= '$sales',
				sale_colour 					= '$sale_colour',
				company		 				= '$company',
				address		 				= '$address',
				contact_no							= '$contact_no',
				remarks 					= '$remarks',
				modified_by					= '$modified_by',
				modified_on					= now()
				WHERE
				sales_id 			= '$sales_id' 
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
	
	
	
	/*
	*	This funcion will return all the product sales
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProductSales($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT sales_id FROM product_sales";
		}
		else
		{
			//statement
			$select	= "SELECT sales_id FROM product_sales
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['sales_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a product Sales  based upon the primary key
	*
	*	@param
	*			$sid		product sales id
	*
	*	@return array				
	*/
	function showStockProdSales($sid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_product_sales
				   WHERE sales_id	= '$sid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->sales_id,					//0
					$result->design_no,					//1
					$result->sales,						//2
					$result->company,					//3
					$result->address,					//4
					$result->contact_no,				//5
					$result->remarks,					//6
					$result->added_on,					//7
					$result->added_by,					//8
					$result->modified_on,				//9
					$result->modified_by,				//10
					$result->sale_colour				//11

					);
		}
		//return the data
		return $data;
	}//eof
	
	
	// All Stock product sales data show
	public function stockProdSaleData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_sales order by sales_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	
	// All Stock product sales data show
	public function stockProdSaleL6MonthData(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_sales 
	 WHERE added_on BETWEEN DATE_SUB(NOW(), INTERVAL 4 MONTH) AND NOW() order by sales_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	//Last Month top Selling product
	public function getLastMtopSaleData(){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(sales),design_no FROM stock_product_sales 
	 WHERE added_on BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() group by design_no 
	 order by SUM(sales) DESC limit 60") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	// Date wise stock in report
	public function getStockSalesDesDaily($design_no,$todate){
     //echo $design_no;exit;
	 $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_sales where design_no ='$design_no' AND
	 added_on ='$todate' ") or die(mysql_error());
	 //echo $res.mysql_error();exit;
     $count=mysql_num_rows($res);
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     } 
	 
	 //last two month Sales display 
	public function getsL2MSales($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( sales ) AS `sales` FROM `stock_product_sales` where design_no ='$design_no'
	 AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['sales'];
     }
     return $temp_arr;  
     } 
	//Product Sales Count
	public function getDWSales($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(sales),design_no FROM stock_product_sales 
	 WHERE design_no ='$design_no'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	//last two month Sales display 
	public function getsdMSales($design_no,$months){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( sales ) AS `sales` FROM `stock_product_sales` where design_no ='$design_no'
	 AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL '$months' MONTH) AND NOW()") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['sales'];
     }
     return $temp_arr;  
     } 
	// All Stock product sale data design wise show
	/*
	* $design_no 	=	Product design no.
	*/
	public function stockPSaleDesShow($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_sales WHERE design_no = '$design_no' order by sales desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
     }
     return $temp_arr;  
     }
	
	// Stock product in display design no wise
	// $design_no 		= Design No
	public function getStockSalesDesignWise($design_no,$todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_product_sales where design_no ='$design_no' AND
	 added_on between '$todate' and '$fromdate'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	
	/**
	*	This function will delete a product in permanently
	*
	*	@param
	*			$sid			product in id
	*
	*	@return null
	*/
	function delStockProdSales($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM stock_product_sales WHERE sales_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
		
		
		#####################################################################################################
	#
	#										Add Goods return data into goods_return table
	#
	#####################################################################################################
	
	/**
	*	Add a new goods return into goods_return table.
	*
	*	@param
	*			
	*			$greturn_id			    Goods return id	
	*			$design_no				Design no of  products
	*			$greturn			     	goods return 
	*			$company				company
	*			$address				address
	*			$contact_no				contact_no
	*			$remarks					Remark
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addStockProdreturn($stock_id, $greturn,$grcolour,$party_code,$remarks,$ready_gd, $added_by)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$stock_id	        	=	trim($stock_id);
		$greturn			   	= 	mysql_real_escape_string(trim($greturn));
		$grcolour			   	= 	mysql_real_escape_string(trim($grcolour));
		$party_code			   	=	mysql_real_escape_string(trim($party_code));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$ready_gd		   		=	mysql_real_escape_string(trim($ready_gd));
		$added_by				=	mysql_real_escape_string(trim($added_by));



		
		
		//satement to insert in stock product table
		$insert		=   "INSERT INTO stock_products_return
						(stock_id, greturn,grcolour, party_code, remarks,ready_gd,added_on, added_by)
							
						VALUES
						('$stock_id', '$greturn','$grcolour', '$party_code','$remarks','$ready_gd',now(), '$added_by')
							
						";
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$greturn_id	= mysql_insert_id();
		
		//return primary key
		return $greturn_id;

	}//eof
	
	
	/**
	*	This function edit Goods Return details
	*
	*	@param
	*			$grid			    goods return  id
	*			$stock_id			    stock_id	
	*			$design_no				Design no of  products
	*			$grcolour			     	colour 
	*			$greturn				product quantity
	*			
	*			
	*		
	*			
	*	@return null
	*/
	function editStockProdreturn($greturn_id,$stock_id, $greturn,$grcolour,$party_code,$remarks,$ready_gd, $modified_by)
	
	{
		$stock_id	        	=	trim($stock_id);
		$greturn			   	= 	mysql_real_escape_string(trim($greturn));
		$grcolour			   	= 	mysql_real_escape_string(trim($grcolour));
		$party_code			   	=	mysql_real_escape_string(trim($party_code));
		$remarks		   		=	mysql_real_escape_string(trim($remarks));
		$ready_gd		   		=	mysql_real_escape_string(trim($ready_gd));
		$modified_by				=	mysql_real_escape_string(trim($modified_by));


		//update stock_products_return description
		$edit  = "UPDATE stock_products_return
				SET
				stock_id		 			= '$stock_id',
				greturn 					= '$greturn',
				grcolour					= '$grcolour',
				party_code		 			= '$party_code',
				remarks		 				= '$remarks',
				ready_gd					= '$ready_gd',
				modified_by 				= '$modified_by',
				modified_on					= now()
				WHERE
				greturn_id 					= '$greturn_id'
				";
		$query = mysql_query($edit);
		//echo $edit.mysql_error();exit;
		
	}//eof
		
	/*
	*	This funcion will return all the product return
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProdStockReturn($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT greturn_id FROM stock_products_return";
		}
		else
		{
			//statement
			$select	= "SELECT greturn_id FROM stock_products_return
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['greturn_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof
	
	
	/**
	*	Get the data associated with a product Return  based upon the primary key
	*
	*	@param
	*			$grid		goods return id
	*
	*	@return array				
	*/
	function showStockProdReturn($grid)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM stock_products_return
				   WHERE greturn_id	= '$grid'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->greturn_id,	//0
					$result->stock_id,		//1
					$result->greturn,		//2
					$result->grcolour,		//3
					$result->party_code,	//4
					$result->remarks,		//5
					$result->ready_gd,		//6
					$result->added_on,	//7
					$result->added_by,		//8
					$result->modified_on,		//9
					$result->modified_by	//10

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	function showProductReturnData($stock_id,$colour)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM goods_return
				   WHERE stock_id	= '$stock_id' AND grcolour = '$colour'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->greturn_id,	//0
					$result->stock_id,		//1
					$result->greturn,		//2
					$result->grcolour,		//3
					$result->party_code,	//4
					$result->remarks,		//5
					$result->ready_gd,		//6
					$result->added_on,	//7
					$result->added_by,		//8
					$result->modified_on,		//9
					$result->modified_by	//10

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	// Show all stock return data
	 public function allStockProdreturn(){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM stock_products_return order by greturn_id desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     } 
	
	
	/*==============================*/
	/* Total product return count stock id wise
	*//*===============================*/
	 public function getGrCount($stock_id){
     $temp_arr = array();
     $res = mysql_query("SELECT sum( ready_gd ) AS `count_rquantity` FROM `stock_products_return` 
	 where stock_id ='$stock_id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         //$temp_arr[] =$row;
		 echo $row['count_rquantity'];
     }
     return $temp_arr;  
     } 
	// Display Total GR products
	 public function showTGrProd($stock_id){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(ready_gd) FROM stock_products_return where stock_id = '$stock_id'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	// Display Total GR products
	 public function showTGrProdClWise($stock_id,$grcolour){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(ready_gd) FROM stock_products_return where stock_id = '$stock_id' AND 
	 grcolour = '$grcolour'") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	
	// Stock product return display design no wise
	// $stock_id 		= Stock Id
	
	 public function getStockGRDesignWise($stock_id,$todate,$fromdate){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(ready_gd) FROM stock_products_return where stock_id ='$stock_id' AND
	 added_on between '$todate' and '$fromdate' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     }  
	
	// Display Total GR products
	 public function showTGrProdDtls($stock_id){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(ready_gd),SUM(greturn),party_code,added_on FROM stock_products_return where stock_id = '$stock_id' group by party_code") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	
	// Display Total GR products
	 public function showPartyGrProdDtls($party_code){
     $temp_arr = array();
     $res = mysql_query("SELECT SUM(ready_gd),SUM(greturn),party_code,added_on,stock_id FROM stock_products_return where party_code = '$party_code'
    AND added_on BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() group by stock_id order by SUM(ready_gd) desc") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		// echo $row[1];
     }
     return $temp_arr;  
     } 
	
	/**
	*	This function will delete a product in permanently
	*
	*	@param
	*			$sid			product in id
	*
	*	@return null
	*/
	function delProductReturn($sid)
	{
		
		//delete from product
		$delete1 = "DELETE FROM goods_return WHERE greturn_id='$sid'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
		
	
	
	#####################################################################################################
	#
	#										add colour
	#
	#####################################################################################################
	
	/**
	*	Add a new colour to colour table.
	*
	*	@param
	*			
	*			$pcolour_id			    product colour	
	*			$design_no				Design no of  products
	*			$pcolour			     product colour 
	*			$date     		    	date
	*			
	*		
	*			
	*
	*	@return int
	*/
	function addColour($design_no, $pcolour)
	
	{
		/*$stock_id			   =	mysql_real_escape_string(trim($stock_id));*/
		$design_no	        =	trim($design_no);
		$pcolour			   = mysql_real_escape_string(trim($pcolour));
		
		//satement to insert in stock table
		$insert		=   "INSERT INTO product_color
						(design_no, pcolour,added_on)
							
						VALUES
						('$design_no', '$pcolour', now())
							
						";
						
						
		//execute quary
		$query		= mysql_query($insert);
		//echo $insert.mysql_error();exit;
		//get the product id
		$stock_id	= mysql_insert_id();
		
		//return primary key
		return $stock_id;

	}//eof
	
	
	/*
	*	This funcion will return all the product colour id return
	*	
	*	@param
	*			$orderby		stock by clause in runtime
	*			$orderType		stock type, either ascending or descending
	*
	*	@return array
	*/
	function getAllProductColour($orderby, $orderbyType)
	{
		//declare var
		$data	= array();
		
		if($orderby == '' || $orderbyType == '')
		{
			$select	= "SELECT pcolour_id FROM product_color";
		}
		else
		{
			//statement
			$select	= "SELECT pcolour_id FROM product_color
					   ORDER BY ".$orderby." ".$orderbyType."";
		}
				   
		//execute query
		$query	= mysql_query($select);

		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['pcolour_id'];
		}
		
		//echo $select.mysql_error();exit;
		//return the data
		return $data;
		
	}//eof
	
	
	
		
	/**
	*	Get the data associated with a product colour  based upon the primary key
	*
	*	@param
	*			$pcolour_id		product colour id
	*
	*	@return array				
	*/
	function showProductColour($pcolour_id)
	{
		//declare vars
		$data = array();
		
		//statement
		$select = "SELECT * FROM product_color
				   WHERE pcolour_id	= '$pcolour_id'";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		//holds the data
		while($result = mysql_fetch_object($query))
		{
			$data  = array(
					$result->pcolour_id,					//0
					$result->design_no,							//1
					$result->pcolour,						//2
					$result->added_on,					//3
					$result->added_by						//4

					);
		}
		
		//return the data
		return $data;
		
	}//eof
	
	/* Display all data */
	/*
		$pid= orders_id 
	*/
	
	 public function ColourDisplay($design_no){
     $temp_arr = array();
     $res = mysql_query("SELECT * FROM product_color where design_no='$design_no' ") or die(mysql_error());        
     $count=mysql_num_rows($res);
    
    while($row = mysql_fetch_array($res)) {
         $temp_arr[] =$row;
		 
     }
     return $temp_arr;  
     }
	 
	
	 
	
	/**
	*	This function will delete a product colour permanently
	*
	*	@param
	*			$pcolour_id			product colour id
	*
	*	@return null
	*/
	function delProductColour($pcolour_id)
	{
		
		//delete from product
		$delete1 = "DELETE FROM product_color WHERE pcolour_id='$pcolour_id'";
		
		//execute quary
		$query1	= mysql_query($delete1);
		
	}//eof
	
	//
	
	
	
	
	
}
?>