<?php 
include_once("category.class.php"); 
/**
*	News class help user to work with derectory listing, add, edit and delete new listing.
*	Activate or deactivate listings whenevr expired.
*
* 
*/


class News  extends Cat
{
	/////////////////////////////////////////////////////////////////////////////////////////
	//
	//				*********		Add News Components 	***********
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	/**
	*	Add a new News
	*	
	*	@param
	*			$cat_id		Category id
	*			$ref_id		Reference Id
	*			$title		Title
	*			$summary	News Summary
	*
	*	@return int
	*/
	function addNews($cat_id, $ref_id, $title, $summary)
	{
		
		$title 	 = trim(addslashes($title)); 
		$summary = trim(addslashes($summary)); 
		
		
		$sql 	= "INSERT INTO news
				  (categories_id, ref_id, title, summary, added_on)
				  VALUES
				  ('$cat_id', '$ref_id','$title','$summary', now())";
		$query	= mysql_query($sql);

		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	/**
	*	Add a News Detail
	*	
	*	@param
	*			$news_id	News id
	*			$heading	Paragraph Heading
	*			$desc		Paragraph Description
	*
	*	@return int
	*/
	function addNewsDetail($news_id, $heading, $desc)
	{
		$heading 	 = trim(addslashes($heading)); 
		$desc 	 	 = trim(addslashes($desc)); 
		
		$sql 	= "INSERT INTO news_detail
				  (news_id, heading, nd_desc)
				  VALUES
				  ('$news_id', '$heading','$desc')";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	/**
	*	Add a news reference
	*	
	*	@param
	*			$ref		News reference
	*			$desc		Description
	*
	*	@return int
	*/
	function addNewsRef($ref, $desc)
	{
		
		$ref 	 = trim(addslashes($ref)); 
		$desc 	 = trim(addslashes($desc)); 
		
		$sql 	= "INSERT INTO news_reference
				  (reference, description, added_on)
				  VALUES
				  ('$ref', '$desc',now())";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = 'SU101';
		}
		return $result;
	}//eof
	
	
	/**
	*	Add news review
	*	
	*	@param
	*			$news_id	News id
	*			$sub		Subject
	*			$name		Name
	*			$email		Email
	*			$review		News review
	*			$added		Added on
	*
	*	@return int
	*/
	function addNewsReview($news_id, $sub, $name, $email, $review, $added)
	{
		
		$sql 	= "INSERT INTO news_review
				  (news_id,subject, name, email, review, added_on)
				  VALUES
				  ('$news_id','$sub', '$name','$email','$review',now())
				  ";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	/**
	*	Add news images, we are updating the news detail table
	*	
	*	@param
	*			$nd_id			News detail id
	*			$img_title		Image Name
	*			$img_desc		Image Description
	*			$img_credit		Image Credit (Created By etc.)
	*	@return int
	*/
	function addNewsImage($nd_id, $img_title, $img_desc, $img_credit)
	{
		
		$img_title 	 	 = addslashes(trim($img_title)); 
		$img_desc 	 	 = addslashes(trim($img_desc)); 
		$img_credit 	 = addslashes(trim($img_credit)); 
		
		$sql 	= "UPDATE news_detail SET 
				  img_title = '$img_title', 
				  img_desc = '$img_desc', 
				  img_credit = '$img_credit' 
				  WHERE
				  nd_id = '$nd_id'
				  ";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = mysql_insert_id();
		}
		return $result;
	}//eof
	
	
	/////////////////////////////////////////////////////////////////////////////////////////
	//
	//				*********		Delete News Components 	***********
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Delete news information from the database. Treat deleting images separately.
	*	@param 
	*			$id		news id
	*			$path	path to the news image
	*
	*	@return string
	*/
	function deleteNews($id, $path)
	{
		//lock the tables from read
		mysql_query("LOCK TABLES news, news_detail, news_review READ");
					
		//delete news review
		$sql2	= "DELETE FROM news_review WHERE news_id='$id'";
		$query2	= mysql_query($sql2);
		
		//get news detail
		$sql	= "SELECT * FROM news_detail WHERE news_id='$id'";
		$qry	= mysql_query($sql);
		if(mysql_num_rows($qry) > 0)
		{
			while($result = mysql_fetch_array($qry))
			{
				$nd_id		= $result['nd_id'];
				$img_name 	= $result['image'];
				
				//delete file first
				@unlink($path.$img_name); 
				
				//delete news detail
				$sql0	= "DELETE FROM news_detail WHERE nd_id='$nd_id'";
				$query0	= mysql_query($sql0);
				
			}
		}
		
		
		//delete from main news
		$sql5	= "DELETE FROM news WHERE news_id='$id'";
		$query5 = mysql_query($sql5);
		
		//unlock tables
		mysql_query("UNLOCK TABLES");
		
	}//eof
	
	/**
	*	Delete news review.
	*	@param 
	*			$id		news id
	*
	*	@return string
	*/
	function deleteNewsReview($id)
	{	
		//delete from review
		$sql	= "DELETE FROM news_review WHERE news_id='$id'";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER103';
		}
		else
		{
			$result = 'SU103';
		}
		//return the result
		return $result;
	}//eof
	
	/**
	*	Delete review.
	*	@param 
	*			$id		review id
	*
	*	@return string
	*/
	function deleteReview($id)
	{	
		//delete from review
		$sql	= "DELETE FROM news_review WHERE review_id='$id'";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER103';
		}
		else
		{
			$result = 'SU103';
		}
		//return the result
		return $result;
	}//eof
	
	/////////////////////////////////////////////////////////////////////////////////////////
	//
	//				*********		Update News Components 	***********
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Update news
	*	@param
	*			$news_id		News id
	*			$cat_id		Category id
	*			$ref_id		Reference Id
	*			$title		Title
	*			$summary	News Summary
	*
	*	@return string
	*/

	function updateNews($news_id, $cat_id, $ref_id, $title, $summary)
	{
		$title 	 = trim(addslashes($title)); 
		$summary = trim(addslashes($summary)); 
			
		//update news
		$sql	= "UPDATE news SET
				  categories_id 	= '$cat_id',
				  ref_id 			= '$ref_id',
				  title 			= '$title',
				  summary 			= '$summary',
				  modified_on 		=  now()
				  WHERE 
				  news_id = '$news_id'
				  ";
		$query	= mysql_query($sql);
		
		//update news updation date
		$this->updateDate($news_id);
		
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
	}//eof
	
	/**
	*	Update the date time, whenever the news is updated.
	*
	*	@param
	*			$news_id		News id
	*/
	function updateDate($news_id)
	{
		//update time info
		$sql	= "UPDATE news SET
				  modified_on 	= now()
				  WHERE 
				  news_id  = '$news_id'
				  ";
		$query	= mysql_query($sql);
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
	}//eof
	
	
	/**
	*	Update a news detail
	*	
	*	@param
	*			$nd_id		News id
	*			$news_id	News id
	*			$heading	Paragraph Heading
	*			$desc		Paragraph Description
	*
	*	@return string
	*/
	
	function updateNewsDetail($nd_id, $heading, $desc)
	{
		$heading = addslashes(trim($heading));
		$desc    = addslashes(trim($desc));
		//update news address
		$sql	= "UPDATE news_detail 
				  SET
				  heading 	='$heading',
				  nd_desc	='$desc'
				  WHERE 
				  nd_id 	= '$nd_id'
				  ";
		$query	= mysql_query($sql);
		//echo $sql;exit;
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
	}//eof
	
	/**
	*	Update news review
	*	
	*	@param
	*			$rev_id		Review Id
	*			$news_id		News id
	*			$sub		Subject
	*			$name		Name
	*			$email		Email
	*			$review		Business review
	*
	*	@return string
	*/
	
	function updateNewsReview($rev_id, $news_id, $sub, $name, $email, $review)
	{
		//update news info
		$sql	= "UPDATE news_review SET
				  news_id 	= '$news_id',
				  subject 		= '$sub',
				  name 			= '$name',
				  email 		= '$email',
				  review 		= '$review'
				  WHERE 
				  review_id = '$rev_id'
				  ";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = "ER102";
		}
		else
		{
			$result = "SU102";
		}
		
		//return the result
		return $result;
	}//eof
	
	
	/**
	*	Update news images on delete. If someone delete this we need to set the data
	*	in image field as null.
	*	
	*	@param
	*			$nd_id		News Detail id	
	*
	*	@return int
	*/
	function updateNewsImgDel($nd_id)
	{
		$sql 	= "UPDATE news_detail SET
				   image		= '',
				   img_title	= '',
				   img_desc		= '',
				   img_credit	= ''
				   WHERE
				   nd_id = '$nd_id'
				  ";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = 'SU301';
		}
		return $result;
	}//eof
	
	
	/**
	*	Update news reference.
	*	
	*	@param
	*			$ref_id			News reference id	
	*			$reference		Reference
	*			$description	Reference Detail
	*
	*	@return string
	*/
	function updateRef($ref_id, $reference, $description)
	{
		$reference   = trim(addslashes($reference));
		$description = trim(addslashes($description));
		
		$sql 	= "UPDATE news_reference SET
				   reference	= '$reference',
				   description	= '$description',
				   modified_on	=  now()
				   WHERE
				   ref_id 		= $ref_id
				  ";
		$query	= mysql_query($sql);
		
		$result = '';
		if(!$query)
		{
			$result = 'ER101';
		}
		else
		{
			$result = 'SU301';
		}
		return $result;
	}//eof
	
	
	/////////////////////////////////////////////////////////////////////////////////////////
	//
	//			*********		Get News ID + Components 	***********
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Retrieve all news id based upon criteria. Like status, reference, category
	*	
	*	@param
	*			$id		Identity of a particular type associated with the news.
	*					No nothing is specified it will search for the entire news listing.
	*			$type	Type of the identity. Type coud be any of the following:
	*					STATUS 		: News associated with status
	*					CATEGORY 	: News belongs to  a category
	*					
	*
	*	@return array
	*/
	function getNewsId($id, $type)
	{
		
		//Building the statement
		switch($type)
		{
			case('STATUS'):
				$sql	= "SELECT news_id FROM news N
						   WHERE status = '$id'
						   ORDER BY N.added_on DESC";
				break;
			
			case('REFERENCE'):
				$sql	= "SELECT news_id FROM news N
						   WHERE ref_id = '$id'
						   ORDER BY N.added_on DESC";
				break;
						   
		    case('CATEGORY'):
				$sql	= "SELECT news_id FROM news N
						   WHERE N.categories_id = '$id'
						   ORDER BY N.added_on DESC";
				break;
		   
			default:
				$sql	= "SELECT news_id FROM news N ORDER BY N.added_on DESC";
					
		}
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['news_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all news id based upon mixed criteria, viz. status is either active or past, category 
	*	and Limit.
	*	
	*	@param
	*			$cat		Category of the news
	*			$limit_min	Lower limit to start with
	*			$limit_max	Upper limit
	*					
	*
	*	@return array
	*/
	function getNewsByCatStat($cat, $limit_min, $limit_max)
	{

		if($limit_max == 0)
		{
			$sql =  "SELECT news_id FROM news 
					WHERE categories_id='$cat' 
					AND status='a' OR  status='p' 
					ORDER BY added_on DESC ";
		}
		else
		{
			$sql =  "SELECT news_id FROM news 
					WHERE categories_id='$cat' 
					AND status='a' OR  status='p' 
					ORDER BY added_on DESC 
					LIMIT $limit_min, $limit_max  ";
		}
		

		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['news_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all news id based upon mixed criteria, viz. Status and Limit
	*	
	*	@param
	*			$status		Status of the news
	*			$limit_min	Lower limit to start with
	*			$limit_max	Upper limit
	*					
	*
	*	@return array
	*/
	function getNewsByStat($status, $limit_min, $limit_max)
	{
		
		 switch ($status)
		 {
			case 'ACT_PAST':
				$sql =  "SELECT news_id FROM news WHERE status='a' OR  status='p' ORDER BY 
						added_on DESC LIMIT $limit_min, $limit_max  ";
				break;
			case 'ALL':
				$sql =  "SELECT news_id FROM news ORDER BY added_on DESC 
						LIMIT $limit_min, $limit_max  ";
				break;
			case 'a':
				$sql =  "SELECT news_id FROM news WHERE status='a' ORDER BY added_on DESC 
						LIMIT $limit_min, $limit_max  ";
				break;
			case 'p':
				$sql =  "SELECT news_id FROM news WHERE status='p' ORDER BY added_on DESC 
						LIMIT $limit_min, $limit_max  ";
				break;
			case 'w':
				$sql =  "SELECT news_id FROM news WHERE status='w' ORDER BY added_on DESC 
						LIMIT $limit_min, $limit_max  ";
				break;
			case 'd':
				$sql =  "SELECT news_id FROM news WHERE status='d' ORDER BY added_on DESC 
						LIMIT $limit_min, $limit_max  ";
				break;
			default:
				$sql =  "SELECT news_id FROM news WHERE status='$status' ORDER BY added_on DESC 
						LIMIT $limit_min, $limit_max  ";
				break;
		 }
				
		
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['news_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all news id under a category or it's sub category.
	*	
	*	@param
	*			$catId		Identity of a particular type associated with the news.
	*/
	function getNewsIdByCat($catId, $table)
	{
		$parentCat 	= array($catId);
		$childIds  	= $this->getChildCategories($table,NULL, $catId, $recursive = true);
		$allCat	   	= array_merge($parentCat,$childIds );
		$data	   	= array();
		foreach ($allCat as $k)
		{
			$select = "SELECT * FROM news WHERE categories_id='$k'";
			$query  = mysql_query($select);
			if(mysql_num_rows($query) > 0)
			{
				while($result = mysql_fetch_array($query))
				{
					$data[] = $result['news_id'];
				}
			}
		}
		return $data;
	}//eof
	
	
	/**
	*	Retrieve all image id associated with a news id
	*	
	*	@param
	*			$id		News id.
	*
	*	@return array
	*/
	function getNewsImageId($id)
	{
		
		//Building the statement
		$sql	= "SELECT nd_id FROM news_detail 
				   WHERE news_id='$id' AND image != ''
				   ORDER BY nd_id ASC ";
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['nd_id'];
			}
		}
		return $data;
	}//eof
	
	
	/**
	* 	This function return exactly how many images exists
	*
	*	@param
	*			$id		News id.
	*			$path	Path to the images.
	*
	*	@return array
	*/
	function getNumNewsImg($id, $path)
	{
		//$actual image
		$realImgId	= array();
		
		$imgIds = $this->getNewsImageId($id);
		
		if(count($imgIds) > 0)
		{
			
			foreach($imgIds as $k)
			{
				$imgData	= $this->getNewsDtlData($k);
				//echo "Image Data = ".$imgData[3]."<Br>";
				if(($imgData[3] != '') && (file_exists($path . $imgData[3])))
				{
					$realImgId[] = $k;
				}
			}
		}
		return $realImgId;
		
	}//eof
	
	
	
	/**
	*	Retrieve all image id associated with a news id
	*	
	*	@param
	*			$id		News id.
	*
	*	@return array
	*/
	function getNewsDtlId($id)
	{
		
		//Building the statement
		$sql	= "SELECT nd_id FROM news_detail 
				   WHERE news_id='$id'
				   ORDER BY nd_id ASC ";
		
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['nd_id'];
			}
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve all reference id
	*	
	*	@return array
	*/
	function getRefId()
	{
		//Building the statement
		$sql	= "SELECT ref_id FROM news_reference  ORDER BY reference";
				 
		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['ref_id'];
			}
		}
		return $data;
	}//eof
	
	
	/////////////////////////////////////////////////////////////////////////////////////////
	//
	//			*********		Get News Data or Information 	***********
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	*	Retrieve all news data
	*	@return array
	*	@param	$id		id of the news
	*/
	function getNewsData($id)
	{
		//create the statement
		$sql	= "SELECT *, 
				   N.title AS title, N.summary AS summary, N.no_clicks AS clicks, N.rating AS rating, 
				   N.num_rating AS num_rating, N.status AS status, N.added_on AS added, 
				   N.modified_on AS modified, 
				   NC.categories_id AS cat_id, NC.categories_name AS cat_name, 
				   NC.categories_image AS cat_img, NC.parent_id AS pid, NC.date_added AS cat_added,   
				   NR.ref_id AS ref_id, NR.reference AS reference, NR.description AS description, 
				   NR.added_on AS ref_added 
				   FROM news N, news_categories NC, news_reference NR
				   WHERE N.categories_id = NC.categories_id
				   AND N.ref_id = NR.ref_id
				   AND N.news_id = $id
				   ";
		
		$query	= mysql_query($sql);
		$data	= array();
		//echo $sql."<br>";
		//echo $sql.mysql_error();exit;
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			echo $result['title'];exit;
			$data = array(
						 $result['title'],		//0, NEWS
						 $result['summary'],	//1
						 $result['clicks'],		//2
						 $result['rating'],		//3
						 $result['num_rating'],	//4
						 $result['status'],		//5
						 $result['added'],		//6
						 
						 $result['cat_id'],		//7 CATEGORY
						 $result['cat_name'],	//8
						 $result['cat_img'],	//9
						 $result['pid'],		//10
						 $result['cat_added'],	//11
						
						 $result['ref_id'],		//12 REFERENCE
						 $result['reference'],	//13
						 $result['description'],		//14
						 $result['ref_added']	//15
						 
						 );
		}
		
		return $data;
	}//eof
	
	/**
	*	Retrieve all news data
	*	@return array
	*	@param	$id		id of the news
	*/
	function showNewsData($id)
	{
		//create the statement
		$sql	= "SELECT *, 
				   N.title AS title, N.summary AS summary, N.no_clicks AS clicks, N.rating AS rating, 
				   N.num_rating AS num_rating, N.status AS status, N.added_on AS added, 
				   N.modified_on AS modified, 
				   NC.categories_id AS cat_id, NC.categories_name AS cat_name, 
				   NC.categories_image AS cat_img, NC.parent_id AS pid, NC.date_added AS cat_added   
				   
				   FROM news N, news_categories NC 
				   WHERE N.categories_id = NC.categories_id
				   
				   AND N.news_id = $id
				   ";/*NR.ref_id AS ref_id, NR.reference AS reference, NR.description AS description, 
				   NR.added_on AS ref_added */   /*AND N.ref_id = NR.ref_id*/    /*news_reference NR*/
		
		$query	= mysql_query($sql);
		$data	= array();
		//echo $sql."<br>";
		//echo $sql.mysql_error();exit;
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			
			$data = array(
						 $result['title'],		//0, NEWS
						 $result['summary'],	//1
						 $result['clicks'],		//2
						 $result['rating'],		//3
						 $result['num_rating'],	//4
						 $result['status'],		//5
						 $result['added'],		//6
						 
						 $result['cat_id'],		//7 CATEGORY
						 $result['cat_name'],	//8
						 $result['cat_img'],	//9
						 $result['pid'],		//10
						 $result['cat_added']	//11
						
						 /*$result['ref_id'],		//12 REFERENCE
						 $result['reference'],	//13
						 $result['description'],		//14
						 $result['ref_added']*/	//15
						 
						 );
		}
		
		return $data;
	}//eof

	
	/**
	*	Retrieve news detail data
	*
	*	@param	
	*			$id		news detail is
	*
	*	@return array 
	*/
	function getNewsDtlData($id)
	{
		//create the statement
		$sql	= "SELECT * FROM news_detail
				   WHERE nd_id = $id
				   ";
		
		$query	= mysql_query($sql);
		$data	= array();
		//echo $sql;
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			$data = array(
						 $result['news_id'],		//0
						 $result['heading'],		//1
						 $result['nd_desc'],		//2
						 $result['image'],			//3
						 $result['img_title'],		//4
						 $result['img_desc'],		//5
						 $result['img_credit']		//6
						 );
		}
		return $data;
	}//eof
	
	/**
	*	Retrieve news reference detail
	*
	*	@param	
	*			$id		reference id
	*
	*	@return array 
	*/
	function getRefData($id)
	{
		//create the statement
		$sql	= "SELECT * FROM news_reference
				   WHERE ref_id = $id ";
				  

		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			$data 	= array(
						 $result['reference'],		//0
						 $result['description'],	//1
						 $result['added_on'],		//2
						 $result['modified_on']		//3
						 );
		}
		return $data;
	}//eof
		
		
	function getNews($id)
	{
		//create the statement
		$sql	= "SELECT * FROM news
				   WHERE news_id = $id ";
				  

		$query	= mysql_query($sql);
		$data	= array();
		
		if(mysql_num_rows($query) == 1)
		{
			$result = mysql_fetch_array($query);
			$data 	= array(
						 $result['title'],		//0, NEWS
						 $result['summary'],	//1
						 $result['no_clicks'],		//2
						 $result['rating'],		//3
						 $result['num_rating'],	//4
						 $result['status'],		//5
						 $result['added_on'],		//6
						 $result['categories_id'],		//7
						 $result['ref_id'],		//8
						 );
		}
		return $data;
	}//eof
	
}//eoc
?>