<?php 
/**
*	Manage catgoeries independently, where thable name required in teh run time to execute 
*	the function. In version 1.0 and 2.0 we have dealt with only one category table. 
*	We will be able to handle multiple category table. This is required when there is separate 
*	directory and classified category. Categories table must be identical.
*
*
*	UPDATE April 08, 2013
*	Developed getAllChildUsingJS function to display category submenu in list format. The code will show or hide 
*	subcategories based on the user selection. We have used Javascript and jQuery to develop this module.
*
*
*	UPDATE February 27, 2012
*	Added dropdown list that exclude No Category section. This is applicable to display the list of categories
*	for the users.
*
*
*	UPDATE July 20, 2010
*	New fields brief and url have been added to the system.
*
*
*	UPDATE July 21, 2010
*	1. Page title has added to the system.
*	
*	2. New function getRestRootCat has been added to the system, so that, we will have all the category
*	except the default category.
*
*
*	@author		Himadri Shekhar Roy
*	@date		November 28, 2006
*	@version	2.1
*	@copyright	Analyze System
*	@url		http://www.ansysoft.com
*	@email		himadri.s.roy@ansysoft.com
* 
*/


class Cat
{
	/**
	*	Create a new category. Note that the category image will be uoloaded by a separate function
	*	which will be using as a utility.
	*
	*	@update	July 21, 2010
	*
	*	@param
	*			$parentId			Parent id
	*			$catName			Category name
	*			$url				Customized url name for the website
	*			$txtBrief			Brief of the category or the tag line of the category
	*			$pageTitle			Title of the page description or text, can be same as the category name
	*			$txtDesc			Description of the category
	*			$sort_order			Sorting order
	*			$table				Name of the table
	*
	*	@return int
	*/
	function createCategory($parentId, $catName, $seo_url, $url, $txtBrief, $pageTitle, $description, $sort_order, $table)
	{
		//get the var
		$catName 	= trim($catName);
		$description	= addslashes(trim($description));
		$txtBrief 	= addslashes(trim($txtBrief));
		$pageTitle	= addslashes(trim($pageTitle));
		$sort_order	= (int)$sort_order;
		
		//statement
		$insert  = "INSERT INTO ".$table." 
					(categories_name, seo_url, parent_id, url, brief, page_title, description, sort_order, added_on)
					VALUES
					('$catName', '$seo_url', '$parentId', '$url', '$txtBrief', '$pageTitle', '$description', '$sort_order', now())
					";
			
		//execute query		
		$query   = mysql_query($insert);
		/*echo $insert.mysql_error(); exit;*/
		//get teh primary key
		$id      = mysql_insert_id();
		
		//return the key value
		return $id;
		
	}//eof
	
	
	
	/**
	*	Edit existing category. Note: the category image will be uoloaded by a separate function
	*	which will be using as a utility.
	*
	*	@update	July 20, 2010
	*
	*	@param
	*			$parentId			Parent id
	*			$catName			Category name
	*			$url				Customized url name for the website
	*			$catId				Category id
	*			$txtBrief			Brief of the category or the tag line of the category
	*			$pageTitle			Title of the page description or text, can be same as the category name
	*			$txtDesc			Description of the category
	*			$sort_order			Sorting order
	*			$table				Name of the table
	*
	*	@return int
	*/
	function editCategory($parentId, $catName, $seo_url, $url, $txtBrief, $pageTitle, $txtDesc, $sort_order, $catId, $table)
	{
		//get the var
		$catName 	= trim($catName);
		$txtDesc 	= addslashes(trim($txtDesc));
		$txtBrief 	= addslashes(trim($txtBrief));
		$pageTitle	= addslashes(trim($pageTitle));
		
		//statement
		$update  = "UPDATE ".$table."
					SET
					categories_name = '$catName',
					seo_url			= '$seo_url',
					parent_id		= '$parentId',
					url				= '$url',
					brief			= '$txtBrief',
					page_title		= '$pageTitle',
					description		= '$txtDesc',
					sort_order		= '$sort_order',
					modified_on		=  now()
					WHERE 
					categories_id	= '$catId'
					";
					
		//execute query	
		$query   = mysql_query($update);
		
		//echo $update.mysql_error(); exit;
		//echo $update.mysql_error(); exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	
	/**
	*	This function displayes all the categories.
	*
	*	@param
	*			$table		Name of the table
	*
	*	@return array
	*/
	function displayRoot($table)
	{
		$select = "SELECT categories_id FROM ".$table." WHERE parent_id=0";
		$query  = mysql_query($select);
		$data = array();
		while($result = mysql_fetch_object($query))
		{
			$data[] = $result->categories_id;
		}
		
		return $data;
	}// eof
	
	/**
	*	Get all the child category under a parent category
	*
	*	@param
	*			$parent_id 	Parent category
	*			$table		Name of the table
	*	
	*	@return array
	*/
	function displayCategory($parent_id, $table)
	{
		$select = "SELECT categories_id FROM ".$table."
				   WHERE parent_id='$parent_id' 
				   ORDER BY sort_order, categories_name";
		$query  = mysql_query($select);
		$data = array();
		while($result = mysql_fetch_array($query))
		{
			$data[] = $result['categories_id'];
		}
		return $data;
	}//eof
	
	/**
	*	Get all the category id
	*
	*	@param
	*			$table		Name of the table
	*	
	*	@return array
	*/
	function getAllCategoryId($table)
	{
		$select = "SELECT categories_id FROM ".$table."";
		$query  = mysql_query($select);
		$data = array();
		while($result = mysql_fetch_array($query))
		{
			$data[] = $result['categories_id'];
		}
		return $data;
	}//eof
	
	
	
	/**
	*	Get all the child category under a parent category
	*
	*	@param
	*			$parent_id 	Parent category
	*			$table		Name of the table
	*	
	*	@return array
	*/
	function displayCategory2($parent_id, $table)
	{
		$select = "SELECT categories_id FROM ".$table."
				   WHERE parent_id='$parent_id' 
				   ORDER BY categories_id ASC";
		$query  = mysql_query($select);
		$data = array();
		while($result = mysql_fetch_array($query))
		{
			$data[] = $result['categories_id'];
		}
		return $data;
	}//eof
	
	
	
	/**
	*	This function will display category path from right to left, i.e. child to parent
	*
	*	@param
	*			$cat_id		Id of the category
	*			$anchor		Anchor decide whether to show path with hyperlink or not. The choices are
	*					    YES or NO
	*			$table		Name of the table
	*
	*	@return string
	*/
	function categoryPath($cat_id, $anchor, $table)
	{
		$select  = "SELECT * FROM ".$table." where categories_id='$cat_id'";
		$query   = mysql_query($select);
		//echo $select;
		$result  = mysql_fetch_array($query);
		
		$catName = $result['categories_name'];
		
		
		$path = '';
		if((int)$result['parent_id'] != 0)
		{
			$path   = $result['categories_name'];
			$path = $this->categoryPath($result['parent_id'],$anchor,$table)." > ";
		}
		
		if($anchor == 'YES')
		{
			$cPath =  $path." <a href='".$_SERVER["PHP_SELF"]."?catId=".$cat_id."' title=".$catName."> ".$catName."</a>";
		}//yes
		else
		{
			$cPath =  $path." ".$catName;
		}
		
		
		//$cPath =  $path.$cat_id;
		return $cPath;
		
	}//eof
	
	
	/**
	*	This function will display category path from right to left, i.e. child to parent
	*
	*	@param
	*			$cat_id		Id of the category
	*			$anchor		Anchor decide whether to show path with hyperlink or not. The choices are
	*					    YES or NO
	*			$table		Name of the table
	*
	*	@return string
	*/
	function categoryClsPath($cat_id, $anchor, $table)
	{
		$select  = "SELECT * FROM classified_categories where categories_id='$cat_id'";
		$query   = mysql_query($select);
		
		$result  = mysql_fetch_array($query);
		$catName = $result['categories_name'];
		
		
		$path = '';
		if((int)$result['parent_id'] != 0)
		{
			$path   = $result['categories_id'];
			$path = $this->categoryClsPath($result['parent_id'],$anchor,'classified_categories')." > ";
		}
		
		if($anchor == 'YES')
		{
			$cPath =  $path." <a href='".$_SERVER["PHP_SELF"]."?catId=".$cat_id."' title=".$catName."> ".$catName."</a>";
		}//yes
		else
		{
			$cPath =  $path." ".$catName;
		}
		
		
		//$cPath =  $path.$cat_id;
		return $cPath;
		
	}//eof
	
	
	
	/**
	*	This function will display category path from right to left, i.e. child to parent
	*
	*	@param
	*			$cat_id		Id of the category
	*			$anchor		Anchor decide whether to show path with hyperlink or not. The choices are
	*					    YES or NO
	*			$pageName	Page to redirect
	*			$table		Name of the table
	*
	*	@return string
	*/
	function categoryClsPath2($cat_id, $anchor, $pageName)
	{
		$select  = "SELECT * FROM classified_categories where categories_id='$cat_id'";
		$query   = mysql_query($select);
		
		$result  = mysql_fetch_array($query);
		$catName = $result['categories_name'];
		
		
		$path = '';
		if((int)$result['parent_id'] != 0)
		{
			$path = $result['parent_id'];
			$path = $this->categoryClsPath2($result['parent_id'],$anchor,$pageName)." > ";
		}
		
		//generate the cPath associated with categories
		$cPath = $this->getPathNodeCls($cat_id);
		
		if($anchor == 'YES')
		{
			$cPath =  $path." <a href='".$pageName."?catId=".$cat_id."&cPath=".$cPath."' title=".$catName."> ".$catName."</a>";
		}//yes
		else
		{
			$cPath =  $path." ".$catName;
		}
		
		
		//$cPath =  $path.$cat_id;
		return $cPath;
		
	}//eof
	
	
	
	
	
	/**
	*	Get parent categories id
	*	
	*	@param
	*			$table	Name of the table
	*
	*	@return array
	*/
	function getParentOnly($table)
	{
		$data	= array();
		
		$select = "SELECT categories_id FROM ".$table." WHERE parent_id=0";
		$query  = mysql_query($select);
		
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_object($query))
			{
				$data[] = $result->categories_id;
			}
		}
		
		//return the value
		return $data;
		
	}//eof
	
	
	
	
	
	
	/**
	*	Get parent categories id, except the default one which is the ppart of teh system
	*	
	*	@param
	*			$table		Name of the table
	*
	*	@return array
	*/
	function getRestRootCat($table)
	{
		//declare vars
		$catIds	= array();
		$data	= array();
		
		//get all the root cat
		$catIds	= $this->getParentOnly($table);
		
		//get rest of the categories
		$data	= array_slice($catIds,1);
		
		//return the value
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	Get category data associated with its key.
	*	
	*	@param
	*			$id		Category id
	*			$table	Name of the table
	*
	*	@return array
	*/
	function categoryData($id, $table)
	{
		$data	= array();
		
		$select = "SELECT * FROM ".$table." WHERE categories_id='$id'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->categories_name,		//0
					$result->categories_image,		//1
					$result->parent_id,				//2
					$result->sort_order,			//3
					$result->added_on,				//4
					$result->modified_on,			//5
					$result->description,			//6
					
					$result->brief,					//7		Added on July 20, 2010
					$result->url,					//8
					
					$result->page_title	,			//9		Added on July 21, 2010
					
					$result->seo_url,				//10		Added on Sept 5, 2013
					$result->categories_id			//11   Added on December 15 th 2014
					
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	
	/**		Added on 15th December 2014
	*
	*	get categories id corresponding seo url
	*	Get category data associated with its key.
	*	
	*	@param
	*			$id		Category id
	*			$table	Name of the table
	*
	*	@return array
	*/
	function categorySeo($seo_url)
	{
		$data	= array();
		
		$select = "SELECT * FROM categories WHERE seo_url='$seo_url'";
		$query  = mysql_query($select);
		
		//echo $select.mysql_error(); exit;
		if(mysql_num_rows($query) > 0)
		{
			$result = mysql_fetch_object($query);
			
			$data = array(
					$result->categories_name,		//0
					$result->categories_image,		//1
					$result->parent_id,				//2
					$result->sort_order,			//3
					$result->added_on,				//4
					$result->modified_on,			//5
					$result->description,			//6
					
					$result->brief,					//7		Added on July 20, 2010
					$result->url,					//8
					
					$result->page_title	,			//9		Added on July 21, 2010
					
					$result->seo_url,				//10		Added on Sept 5, 2013
					$result->categories_id			//11   Added on December 15 th 2014
					
					);
		}
		
		//return the value
		return $data;
	}//eof
	
	
	
	
	
	
	/**
	*	Get category id by page name
	*
	*	@date July 27, 2010
	*
	*	@param
	*			$scId				Static content id
	*			$sCatName			Static content category name, derived from static 
	*								content primary key value
	*
	*	@return int
	*/
	function getCatIdByPageName($scId, $sCatName)
	{
		//declare var
		$pageId	= 1;
		
		if($scId == 0)
		{
			//get the page name from the url
			if(basename($_SERVER['PHP_SELF']) != '')
			{
				$pageName = basename($_SERVER['PHP_SELF']);
			}
			else
			{
				$pageName = 'index.php';
			}
		}
		else
		{
			$pageName  = $sCatName;
		}
		
		//statement
		$sql	= "SELECT categories_id FROM static_categories WHERE url ='$pageName'";
		
		//execute query
		$query	= mysql_query($sql);
		
		//get the result
		$result	= mysql_fetch_object($query);
		
		//get the data
		$pageId	= $result->categories_id;
		
		//return the result
		return $pageId;
		
	}//eof
	
	
	
	/**
	*	Buildup the path node same as OS Commerce.
	*	
	*	@param
	*			$node_id	Category id
	*			$table		Name of the table
	*
	*	@return string
	*/
	function getPathNode($node_id, $table)
	{
		//global $cPath;
		if(isset($cPath))$cPath = '';
		$select = "SELECT * FROM ".$table." where categories_id='$node_id'";
		$query  = mysql_query($select);
		
		$result = mysql_fetch_array($query);
		
		$path = '';
		
		if((int)$result['parent_id'] != 0)
		{
			$path = $this->getPathNode($result['parent_id'], $table)."_";
		}
		
		//return $path;
		$cPath =  $path.$node_id;
		return $cPath;
	}//eof
	
	
	
	/**
	*	Buildup the path node same as OS Commerce.
	*	
	*	@param
	*			$node_id	Category id
	*			$table		Name of the table
	*
	*	@return string
	*/
	function getPathNodeCls($node_id)
	{
		//global $cPath;
		if(isset($cPath))$cPath = '';
		$select = "SELECT * FROM classified_categories where categories_id='$node_id'";
		$query  = mysql_query($select);
		
		$result = mysql_fetch_array($query);
		
		$path = '';
		
		if((int)$result['parent_id'] != 0)
		{
			$path = $this->getPathNodeCls($result['parent_id'])."_";
		}
		
		//return $path;
		$cPath =  $path.$node_id;
		return $cPath;
	}//eof
	
	/**
	*	Determine if a category is a parent category.
	*
	*	@param
	*			$id			Parent id
	*			$table		Name of the table
	*
	*	@return int
	*/
	
	function isParent($id, $table)
	{
		$select = "SELECT * FROM ".$table." WHERE parent_id='$id'";
		$query  = mysql_query($select);
		$num    = mysql_num_rows($query);
		return $num;
	}//eof
			
	/**
	*	Get all child of a parent, till any child left.
	*
	*	@param
	*			$id			Parent id
	*			$level		Level of depth
	*			$table		Name of the table
	*			$table2		Relational table where product or directory or classified or
	*						any object store.
	*
	*	@return NULL
	*/
	function getAllChild($id,$level, $table, $table2)
	{
		//global $cPath;
		global $data2;
		$select = "SELECT * FROM ".$table." WHERE parent_id='$id'";
		$query  = mysql_query($select);
		while($result = mysql_fetch_array($query))
		{
			$cPathArray = explode("_",$_GET['cPath']);
			foreach($cPathArray as $i)
			{
				if($i == $result['categories_id'])
				{
					$stringformat = "<b>".$result['categories_name']."</b>";
				}
				else
				{
					$stringformat = $result['categories_name'];
				}
			}
			//$_SERVER['PHP_SELF']
			echo str_repeat("&nbsp;&nbsp;",$level).
				"<a href='"."product.php"."?cPath=".$this->getPathNode($result['categories_id'])."'>".$stringformat;
			
			$select2 = "SELECT * FROM ".$table2." WHERE categories_id='".$result['categories_id']."'";
			$query2  = mysql_query($select2);
			$data2 	 = array();
			while($prod	= mysql_fetch_array($query2))
			{
				$data2[]	= $prod['product_id'];
			}
			$num	= count($data2);
			
			if($this->isParent($result['categories_id']) > 0)
			{
				echo " -> (".$num.")";
			}
			else
			{
				echo " (".$num.")";
			}
			echo "</a><br />";
			$this->getAllChild($result['categories_id'],$level+1);
		}
		
	}//eof
	
	

	
	/**
	*	Get all child of a parent, till any child left.
	*
	*	@param
	*			$id			Parent id
	*			$level		Level of depth
	*			$table		Name of the table
	*			$table2		Relational table where product or directory or classified or
	*						any object store.
	*
	*	@return NULL
	*/
	function getAllClsChild($id,$level)
	{
		$id	= (int)$id;
		//global $cPath;
		global $data2;
		$select = "SELECT * FROM classified_categories WHERE parent_id='$id'";
		$query  = mysql_query($select);
		while($result = mysql_fetch_array($query))
		{
			$cPathArray = explode("_",$_GET['cPath']);
			foreach($cPathArray as $i)
			{
				if($i == $result['categories_id'])
				{
					$stringformat = "<b>".$result['categories_name']."</b>";
				}
				else
				{
					$stringformat = $result['categories_name'];
				}
			}
			//$_SERVER['PHP_SELF']
			echo str_repeat("&nbsp;&nbsp;",$level).
				"<a href='"."classified_listing.php"."?cPath=".$this->getPathNodeCls($result['categories_id'])."' title='".$result['categories_name']."'>".$stringformat;
			
			$select2 = "SELECT * FROM classified WHERE categories_id='".$result['categories_id']."' AND status='a'";
			$query2  = mysql_query($select2);
			$data2 	 = array();
			while($prod	= mysql_fetch_array($query2))
			{
				$data2[]	= $prod['classified_id'];
			}
			$num	= count($data2);
			
			if($this->isParent($result['categories_id'], 'classified_categories') > 0)
			{
				echo " -> (".$num.")";
			}
			else
			{
				echo " (".$num.")";
			}
			echo "</a><br />";
			$this->getAllClsChild($result['categories_id'],$level+1);
		}
		
	}//eof
	
	
	/**
	*	Populate a dropdown list of parent category.
	*
	*	@param
	*			$id			Parent id of the category
	*			$selected	Selected category by user, if not any then it will produce the 
	*						normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its 
	*						name in the parent section so that the user won't add the child
	*						as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	function getRootCatList($selected, $table)
	{
		
		//create statement
		$select = "SELECT * FROM ".$table." WHERE parent_id=0 ORDER BY categories_name ";
		$query  = mysql_query($select);
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$new_cat_id."'  ".$select_string.">".
			$result['categories_name'].
			"</option>";
			
		}
	}//eof
	

	

	
	/**
	*	Populate a dropdown list of parent category.
	*
	*	@param
	*			$id			Parent id of the category
	*			$selected	Selected category by user, if not any then it will produce the 
	*						normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its 
	*						name in the parent section so that the user won't add the child
	*						as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	function getRootCatListEdit($cat_id, $selected, $table)
	{
		
		//create statement
		$select = "SELECT * FROM ".$table." WHERE parent_id=0  AND categories_id 
				   <> $cat_id ORDER BY categories_name ";
		$query  = mysql_query($select);
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$new_cat_id."'  ".$select_string.">".
			$result['categories_name'].
			"</option>";
			
		}
	}//eof
	

	
	
	/**
	*	Populate a dropdown list of category, if there is any selected category, it seletec it first.
	*	This function retrieve the data in recursive manner.
	*
	*	The another version of this function is availble in Utility class. The selection part works when
	*	a user already selected a field.
	*
	*	@param
	*			$id			Parent id of the category
	*			$level		Depth of the category
	*			$selected	Selected category by user, if not any then it will produce the normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its name in the 
	*						parent section so that the user won't add the child as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	
	
	function categoryDropDown($id,$level,$selected,$type,$cat_id, $table)
	{
		if($type == 'edit')
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id='$id' AND categories_id 
			<> $cat_id ORDER BY categories_name ";
		}
		else
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id= $id ORDER BY categories_name ";
		}
		
		$query  = mysql_query($select);
		
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$new_cat_id."' class='menuText' ".$select_string.">".
			str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['categories_name'].
			"</option>";
			
			$this->categoryDropDown($new_cat_id,$level+1,$selected,$type,$cat_id, $table);
		}
	}//eof
	
	
	
	
	
	/**
	*	Populate a dropdown list of product category, if there is any selected category, it seletec it first.
	*	This function retrieve the data in recursive manner.
	*
	*	The another version of this function is availble in Utility class. The selection part works when
	*	a user already selected a field.
	*
	*	@param
	*			$id			Parent id of the category
	*			$level		Depth of the category
	*			$selected	Selected category by user, if not any then it will produce the normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its name in the 
	*						parent section so that the user won't add the child as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	
	
	function catProductDropDown($id,$level,$selected,$type,$cat_id)
	{
		if($type == 'edit')
		{
			$select = "SELECT * FROM categories WHERE parent_id='$id' AND categories_id 
			<> $cat_id ORDER BY categories_name ";
		}
		else
		{
			$select = "SELECT * FROM categories WHERE parent_id= $id ORDER BY categories_name ";
		}
		
		//execute query
		$query  = mysql_query($select);
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$new_cat_id."' class='menuText' ".$select_string.">".
			str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['categories_name'].
			"</option>";
			
			$this->catProductDropDown($new_cat_id,$level+1,$selected,$type,$cat_id);
		}
	}//eof
	
	
	
	
	/**
	*	Populate a dropdown list of classified category, if there is any selected category, it seletec it first.
	*	This function retrieve the data in recursive manner.
	*
	*	The another version of this function is availble in Utility class. The selection part works when
	*	a user already selected a field.
	*
	*	@param
	*			$id			Parent id of the category
	*			$level		Depth of the category
	*			$selected	Selected category by user, if not any then it will produce the normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its name in the 
	*						parent section so that the user won't add the child as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
		
	function catClsDropDown($id,$level,$selected,$type,$cat_id)
	{
		if($type == 'edit')
		{
			$select = "SELECT * FROM classified_categories WHERE parent_id='$id' AND categories_id <> $cat_id 
			ORDER BY categories_name ";
		}
		else
		{
			$select = "SELECT * FROM classified_categories WHERE parent_id='$id' ORDER BY categories_name ";
		}
		
		$query  = mysql_query($select);
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$new_cat_id."' class='menuText' ".$select_string.">".
			str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['categories_name'].
			"</option>";
			
			$this->categoryDropDown($new_cat_id,$level+1,$selected,$type,$cat_id);
		}
		
	}//eof
	
	
	
	
	/**
	*	This function will analyze the path node and return category id as result.
	*
	*	@param
	*			$cPath	Category path
	*
	*	@return NULL
	*/
	function getCatId($cPath)
	{
		$ids	= explode("_",$cPath);
		$num 	= count($ids);
		$id		= $ids[$num -1];
		return $id;
	}//eof
	
	/**
	*	Delete the category.
	*
	*	@param
	*			$cat_id		Category id
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	function deleteCategory($cat_id, $table)
	{
		
		$delete = "DELETE FROM ".$table." WHERE categories_id='$cat_id'";
		$query  = mysql_query($delete);
		//echo $query.mysql_error();exit;
		if(!$query)
		{
			return mysql_error();
		}
	}//eof
	
	/**
	*	
	*/
	function getClsChildCategories($categories, $id, $recursive = true)
	{
		if ($categories == NULL) {
			$categories = $this->getClsCategories();
		}
		$id_arr = array();
		$n     = count($categories);
		$child = array();
		for ($i = 0; $i < $n; $i++) {
			$catId    = $categories[$i]['categories_id'];
			$parentId = $categories[$i]['parent_id'];
			if ($parentId == $id) {
				$child[] = $catId;
				if ($recursive) {
					$child   = array_merge($child, $this->getClsChildCategories($categories, $catId));
				}	
			}
		}
		
		return $child;
	}
	
	/**
	*	Return category data in an array.
	*	
	*	@param	
	*			$table	Name of the table
	*		
	*	@return array
	*/
	function getClsCategories()
	{
		$sql = "SELECT categories_id, parent_id
				FROM classified_categories
				ORDER BY categories_id, parent_id ";
		$result = mysql_query($sql);
		
		$cat = array();
		while ($row = mysql_fetch_array($result)) {
			$cat[] = $row;
		}
		
		return $cat;
	}
	
	/**
	*	Return the top ten parent categories in the list
	*		
	*	@return array
	*/
	function getTopTenCat()
	{
		$cat = array();
		
		$sql = "SELECT categories_id
				FROM classified_categories
				ORDER BY categories_name, categories_id, parent_id
				LIMIT 10";
		$result = mysql_query($sql);
		
		$cat = array();
		while ($row = mysql_fetch_array($result)) {
			$cat[] = $row['categories_id'];
		}
		
		return $cat;
	}
	
	/**
	*	Return the parent category ids
	*		
	*	@return array
	*/
	function getAllParentCat($ordBy, $ordType)
	{
		$cat = array();
		if($ordBy == '' || $ordType == '')
		{
			$sql = "SELECT * FROM categories WHERE parent_id='0'";
		}
		else
		{
			$sql = "SELECT * FROM categories WHERE parent_id='0' ORDER BY ".$ordBy." ".$ordType."";
		}
		$result = mysql_query($sql);
		
		$cat = array();
		while ($row = mysql_fetch_array($result)) {
			$cat[] = $row['categories_id'];
		}
		
		return $cat;
	}
	
	/**
	*	This alternate function will return all child categories under a parent category, including parent
	*	
	*	@param	
	*			$id		Category id
	*			$table	Name of the table
	*		
	*	@return array
	*/
	function getAllCat($id,$level, $table)
	{
		$select = "SELECT * FROM ".$table." WHERE parent_id='$id' ORDER BY categories_name ";
		$query  = mysql_query($select);
		echo $select.mysql_error();exit;
		//creating a blank array
		$cat_arr = array();
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			
			$cat_arr = array_merge($cat_arr, $this->getAllCat($new_cat_id,$level+1,$table));
		}
		return $cat_arr;
	}//eof
	
	
	
	
	/**
	*	This alternate function will return all child categories under a parent category, including parent
	*	
	*	@param	
	*			$id		Category id
	*			$table	Name of the table
	*		
	*	@return array
	*/
	function getAllCatExceptNoCat($table)
	{
		$select = "SELECT categories_id FROM ".$table." WHERE categories_id != 1 ORDER BY categories_name ";
		$query  = mysql_query($select);
		//echo $select.mysql_error();exit;
		//creating a blank array
		$cat = array();
		
		while ($result = mysql_fetch_array($query)) {
			$cat[] = $result['categories_id'];
		}
		return $cat;
	}//eof
	
	
	
	
	
	/**
	*	Display child categories by parent and table
	*
	*	@date	March 18, 2010
	*	
	*	@param
	*			$parent_id			Primary key associated with the parent category
	*			$table				Name of the table
	*			$linkClass			Style for the link
	*			$divClass			Style for the div
	*
	*	@return string
	*/
	function displayCatLink($parent_id, $table, $linkClass, $divClass)
	{
		//declare var
		$linkStr	=	'';
		
		//get all the child ids
		$childIds	= $this->displayCategory($parent_id, $table);
		
		if(count($childIds) > 0)
		{
			foreach($childIds as $k)
			{
				//get the child details
				$childDtl	= $this->categoryData($k, $table);
				
				//get the links
				$linkStr   .= " <li><a href='product.php?cPath=".$k."' class='".$linkClass."' title='".$childDtl[0]."'>".
								$childDtl[0].
								"</a></li>
								
							   ";//<br class='".$divClass."' />$parent_id."_".
			}
		}
		
		//return the values
		return $linkStr;
	}//eof
	
	
	
	
	
	/**
	*	Returns the event ids belongs to a category
	*
	*	@param
	*			$catId		Category id
	*
	*	@return	array
	*/
	function getCatEve($catId)
	{
		//initialize vars
		$data	= array();
		
		//statement
		$select = "SELECT * FROM event_entry WHERE categories_id='$catId' ORDER BY event_id DESC";
		
		//execute statement
		$query  = mysql_query($select);
		
		//check if classifieds are there
		if(mysql_num_rows($query) > 0)
		{
			while($result = mysql_fetch_array($query))
			{
				$data[] = $result['event_id'];
			}
		}
		
		//return the data
		return $data;
	}//eof

	
	
	
	
	/**
	*	Returns all the event ids  belongs to a category in direct or indirect manner
	*
	*	@date October 29, 2010
	*
	*	@param
	*			$catId			Category id
	*			$type			Type defines whether the category will search recursively through all the childs, or only to that category.
	*							The constant 'all' refers to recursive call that search through the parent and childs as well; otherwise 
	*							the function will search for the classified those directly belong to the category
	*
	*	@return array
	*/
	function getEventList($catId, $level, $type)
	{
		//declare vars
		$data	= array();
		$data1	= array();
		$data2	= array();
		
		if($type == 'all')
		{
			//statement
			$select = "SELECT * FROM event_categories WHERE parent_id='$catId' ORDER BY categories_name ";
			
			//execute statement
			$query  = mysql_query($select);
			
			while($result = mysql_fetch_array($query))
			{
				//get the categories ids
				$data1[]	=  $result['categories_id'];
				$cat_id		=  $result['categories_id'];
				
				//staement to get classifieds
				$select2 = "SELECT 		EV.event_id AS CID FROM event_entry EV, event_info EI 
						    WHERE 		EV.categories_id	='".$result['categories_id']."'
							AND 		EV.event_id 	= EI.event_id
						    ORDER BY 	EI.added_on DESC
						   ";
				
				//execute statement
				$query2  = mysql_query($select2);
				
				//get the results
				while($result2 = mysql_fetch_array($query2))
				{
					//get the classified ids
					$classifiedId = $result2['CID'];
					
					//hold in array
					$data[] = $classifiedId;
				}
				
				//call the function again
				$this->getClassifiedList($result['categories_id'], $level+1,'all');
			}
		}
		else
		{
			//get the classified ads
			$ads 	= $this->getCatEve($catId);
			
			
			//get the values in variable 
			$data	  = $ads;
		}
		
		
		//return the values
		return $data;
		
	}//eof
	
	
	
	
	/**
	*	Populate a dropdown list of parent category except the No Category. This is applicable for the user section.
	*	We will exculde the No Category from the drop down list.
	*
	*	@date	February 27, 2012
	*
	*	@param
	*			$id			Parent id of the category
	*			$selected	Selected category by user, if not any then it will produce the 
	*						normal list
	*			$type		Type decides whether the list will produce to add a category or to edit
	*						an existing category. The only constant is EDIT.
	*			$cat_id		Applicable for editing purpose. For editing it won't display its 
	*						name in the parent section so that the user won't add the child
	*						as it's parent
	*			$table		Name of the table
	*
	*	@return NULL
	*/
	function getRootCatListExceptNoCat($selected, $table)
	{
		
		//create statement
		$select = "SELECT * FROM ".$table." WHERE parent_id=0 and categories_id <> 1 ORDER BY categories_name ";
		$query  = mysql_query($select);
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<option value='".$new_cat_id."'  ".$select_string.">".
			$result['categories_name'].
			"</option>";
			
		}
	}//eof
	
	/**
	*	Display categories in javascript based style. Here we will display only 2 levels of category. This is dveloped for
	*	Gold sun only.
	*
	*	@date	April 08, 2011
	*	
	*	@param
	*			$table				Name of the table
	*
	*	@return string 
	*/
	function displayCatList($table)
	{
		//declare var
		$linkStr		=	'';
		$cPath			= 	'';
		$rootCatCls		= 	'';
		$childCatCls	=	'';
		
		$first_node		= 	0;
		$last_node		= 	0;
		
		//working with cPath
		if(isset($_GET['cPath']))
		{
			$cPath	= $_GET['cPath'];
		}
		
		if(strpos($cPath,"_") === false)
		{
			$f_n = $cPath;
			$first_node = $f_n;
			$last_node = $first_node;
		}
		else
		{
			$f_n = explode("_", $cPath);
			$first_node = $f_n[0];
			$reverse = array_reverse($f_n);
			$last_node = $reverse[0];
		}
		
		//statement
		$select = "SELECT 	* 
				   FROM 	categories 
				   WHERE 	parent_id = 0
				   AND 		status = 'a' 
				   ORDER BY sort_order ASC, categories_name ASC";
		
		//query
		$query	= mysql_query($select);
		
		
		if(mysql_num_rows($query) > 0)
		{
			//outer ul
			echo 	"<ul>";
			
			while($result	= mysql_fetch_object($query))
			{
				// get the child details     
				// taken from anchor class='".$linkClass."'
				$catId		= $result->categories_id;
				$catName	= $result->categories_name;
				
				//decide root cat display style
				if($first_node	== $catId)
				{
					$rootCatCls		= 	'selected';
				}
				else
				{
					$rootCatCls		= 	'';
				}
				
				echo	"<li class='".$rootCatCls."'>   
							<a href='product.php?cPath=".$catId."'  title='".$catName."'>"
							.$catName.
							"</a>
						";
						
				//get all child
				$childrenIds	= $this->displayCategory($catId, $table);
				
				//check if child is there
				if(count($childrenIds) > 0)
				{
					//inner ul
					echo "<ul>";
					
					foreach($childrenIds as $c)
					{
						//get all child detail
						$childDtl	= $this->categoryData($c, $table);
						
						//generate the cat path
						$catPath	= $catId."_".$c;
						
						//decide child cat display style
						if($last_node	== $c)
						{
							$childCatCls		= 	'selected';
						}
						else
						{
							$childCatCls		= 	'';
						}
				
						
						echo	"<li class='".$childCatCls."'>   
									<a href='product.php?cPath=".$catPath."'  title='".$childDtl[0]."'>"
									.$childDtl[0].
									"</a>
								 </li>
								";
					}
					
					//end inner ul
					echo "</ul>";
					
				}//eof count child
						
				//end li	
				echo 	"</li>";
							   
				
			}
			
			//end outer ul
			echo "</ul>";
		}
		
		//return the values
		return $linkStr;
	}//eof
	
	/**
	*	Display categories in javascript based style. Here we will display only 2 levels of category. This is dveloped for
	*	Gold sun only previously but modified for Dreams of Tibet to work with accordian slider menu.
	*
	*	@date	April 08, 2011
	*	
	*	@modified January 04, 2013
	*
	*	@param
	*			$table				Name of the table
	*
	*	@return string 
	*/
	function displayCatList2($table)
	{
		//declare var
		$linkStr		=	'';
		$cPath			= 	'';
		$rootCatCls		= 	'';
		$childCatCls	=	'';
		
		$first_node		= 	0;
		$last_node		= 	0;
		
		//working with cPath
		if(isset($_GET['cPath']))
		{
			$cPath	= $_GET['cPath'];
		}
		
		if(strpos($cPath,"_") === false)
		{
			$f_n = $cPath;
			$first_node = $f_n;
			$last_node = $first_node;
		}
		else
		{
			$f_n = explode("_", $cPath);
			$first_node = $f_n[0];
			$reverse = array_reverse($f_n);
			$last_node = $reverse[0];
		}
		
		//statement
		$select = "SELECT 	* 
				   FROM 	categories 
				   WHERE 	parent_id = 0
				   AND 		status = 'a' 
				   ORDER BY sort_order ASC, categories_name ASC";
		
		//query
		$query	= mysql_query($select);
		
		
		if(mysql_num_rows($query) > 0)
		{
			//outer ul
			echo 	"<ul>";
			
			while($result	= mysql_fetch_object($query))
			{
				// get the child details     
				// taken from anchor class='".$linkClass."'
				$catId		= $result->categories_id;
				$catName	= $result->categories_name;
				
				//decide root cat display style
				if($first_node	== $catId)
				{
					$rootCatCls		= 	'selected';
				}
				else
				{
					$rootCatCls		= 	'';
				}
				
				echo	"<li>
							<a href='product.php?cPath=".$catId."'>"
							.$catName.
							"</a>
						";
						
				//get all child
				$childrenIds	= $this->displayCategory($catId, $table);
				
				//check if child is there
				if(count($childrenIds) > 0)
				{
					//inner ul
					echo "<ul>";
					
					foreach($childrenIds as $c)
					{
						//get all child detail
						$childDtl	= $this->categoryData($c, $table);
						
						//generate the cat path
						$catPath	= $catId."_".$c;
						
						//decide child cat display style
						if($last_node	== $c)
						{
							$childCatCls		= 	'selected';
						}
						else
						{
							$childCatCls		= 	'';
						}
				
						
						echo	"<li>   
									<a href=''>"
									.$childDtl[0].
									"</a>
								 </li>
								";
					}
					
					//end inner ul
					echo "</ul>";
					
				}//eof count child
						
				//end li	
				echo 	"</li>";
							   
				
			}
			
			//end outer ul
			echo "</ul>";
		}
		
		//return the values
		return $linkStr;
	}//eof
	
	
	
	/**
	*	Get parent id of a category.
	*	
	*	@date	October 18, 2012
	*
	*	@param
	*			$cId		Category id
	*
	*	@return int
	*/
	function getParentIdByCat($cId)
	{
		//declare vars
		$parentId	= 0;
		
		//statement
		$select = "SELECT 	* 
				   FROM 	categories 
				   WHERE 	categories_id='$cId'";
				   
		//execute query
		$query  = mysql_query($select);
		
		if(mysql_num_rows($query) > 0)
		{
			//result
			$result 	= mysql_fetch_object($query);
			
			//get the parent id
			$parentId	= $result->parent_id;
		}
		
		
		//return parent id
		return $parentId;
		
	}//eof
	
	
	/**
	*	Get All child category
	*	
	*	@date	October 18, 2012
	*
	*	@param
	*			$pId		Parent id
	*
	*	@return array
	*/
	function getAllChildByParent($pId)
	{
		//declare vars
		$catIds	= array();
		
		//statement
		$select = "SELECT 	* 
				   FROM 	categories 
				   WHERE 	parent_id='$pId'";
				   
		//execute query
		$query  = mysql_query($select);
		//echo $select.mysql_error();exit;
		
		if (mysql_num_rows($query) > 0 )
		{
			while($result	= mysql_fetch_array($query))
			{
	
				
				//get the category ids
				$catIds[]	= $result['categories_id'];
			}
		}
		
		
		//return category ids
		return $catIds;
		
	}//eof
	
	
	/**
	*	Get all child of a parent, till any child left. This function has been developed to display sub categories 
	*	using show hide list element. We have used javascript and jQuery to develop this part. Initially this funtion will cater 
	*	only 2 levels of menu.
	*
	*	@date	April 08, 2013
	*	@author	Manoj Acharya
	*
	*	@param
	*			$id			Parent id
	*			$level		Level of depth
	*			$table		Name of the table
	*			$table2		Relational table where product or directory or classified or
	*						any object store.
	*
	*	@return NULL
	*/
	function getAllChildUsingJS($id, $level, $itemId, $table, $table2, $showNumProd)
	{
		//declare variables
		global $data2;
		$stringformat = '';
		
		//create statement
		$select = "SELECT * FROM ".$table." WHERE parent_id='$id'";
		
		//execute query
		$query  = mysql_query($select);
		
		//check if resultset found
		if(mysql_num_rows($query) > 0 )
		{
			
			//start fetching the data
			while($result = mysql_fetch_array($query))
			{
				//get the sub categopry name
				$subCatName 	= $result['categories_name'];
				
				//start list element
				$stringformat 	.= '<li title="'.$subCatName.'">'.
								   	"<a href='"."product.php"."?cPath=".$this->getPathNode($result['categories_id'], $table)."'>".$subCatName;
			
				if($showNumProd == "YES")
				{
					//get the number of item, it can be product or classified ads or directory listing or events
					//create statement
					$select2 = "SELECT * FROM ".$table2." WHERE categories_id='".$result['categories_id']."'";
					
					//execute query
					$query2  = mysql_query($select2);
					
					//get the data in array
					$data2 	 = array();
					
					while($prod	= mysql_fetch_array($query2))
					{
						$data2[]	= $prod[$itemId];
					}
					
					//get the number of item
					$num	= count($data2);
					
					//display the number
					if($this->isParent($result['categories_id'], $table) > 0)
					{
						$stringformat 	.= 	" -> (".$num.")";
					}
					else
					{
						$stringformat 	.= 	" (".$num.")";
					}
					
				}
				
				//close a and li tags
				$stringformat 	.= 		"</a>
									</li>";
										
				//we have opt out the recursive call
				//$this->getAllChild($result['categories_id'],$level+1);
				
			}//while
			
		}//if
		
		//return the formatted string
		return $stringformat;
		
	}//eof
	
	/**
	*	Generate Category Checkbox
	*
	*	@return NULL
	*/
	function genCatCheck()
	{
		//get all parent Ids
		$pIds   = $this->getAllParentCat('', '');
		
		if(count($pIds) > 0)
		{
			foreach($pIds as $q)
			{
				$pDetail		= $this->categoryData($q, 'categories');

				echo "<div class='w100P padB5 bdrB'><strong>".$pDetail[0]."</strong></div>";
				
				//get all the activities under the place
				$catIds		= $this->getAllChildByParent($q);
				//print_r($catIds);exit;
				
				$chkStr 	= '';
				$a			= 'r';
				
				if(count($catIds) > 0)
				{
					
					foreach($catIds as $p)
					{
						//activity detail
						$catDetail	= $this->categoryData($p, 'categories');
						$title		= $catDetail[0];
						
						if(isset($_SESSION[$a.$p]) && ($_SESSION[$a.$p] == $a.$p))
						{
							$chkStr 	= 'checked';
						}
						else
						{
							$chkStr 	= '';
						}
						
						echo "<div>";
						echo "<div class='w175 fl ha'>";
						
						echo	'<div class="cat-checkbox fl padL5 padR25">';
						echo     '<input name="chkCat[]" type="checkbox" id="chkCat" class="checkbox" value="'.$p.'"
								  '.$chkStr.' />';
						echo 	'</div>';
						echo 	'<div class="fl w150">'.$title.'</div>';
						echo "</div>";
						echo "</div>";
						//
					}
					echo '<div class="cl"><!-- --></div>';
				}
				echo "<div class='h25'><!-- --></div>";
			}
		}
		
						
	}//eof
	
	
	/**
	*	Product attribute or option value check boxes on edit
	*
	*	@param
	*			$prodId			Product identity
	*
	*	@return NULL
	*/
	function genOptionCheckEdit($prodId)
	{
		//get all parent Ids
		$pIds   		= $this->getAllParentCat();
		
		//get all category id of the product
		$prodCatIds		= $this->getAllCatIdByProdId($prodId);
		
		if(count($pIds) > 0)
		{
			foreach($pIds as $q)
			{
				$pDetail		= $this->categoryData($q, 'categories');

				echo "<div class='w100P padB5 bdrB'><strong>".$pDetail[0]."</strong></div>";
				
				//get all the activities under the place
				$catIds		= $this->getAllChildByParent($q);
				//print_r($catIds);exit;
				
				$chkStr 	= '';
				$a			= 'r';
				
				if(count($catIds) > 0)
				{
					
					foreach($catIds as $p)
					{
						//activity detail
						$catDetail	= $this->categoryData($p, 'categories');
						$title		= $catDetail[0];
						

						
						foreach($prodCatIds as $c)
						{
							if($p == $c)
							{
								$chkStr	= 'checked';
								break;
							}
							else
							{
								$chkStr	= '';
							}
						}
						
						echo "<div>";
						echo "<div class='w175 fl ha'>";
						
						echo	'<div class="cat-checkbox fl padL5 padR25">';
						echo     '<input name="chkCat[]" type="checkbox" id="chkCat" class="checkbox" value="'.$p.'"
								  '.$chkStr.' />';
						echo 	'</div>';
						echo 	'<div class="fl w150">'.$title.'</div>';
						echo "</div>";
						echo "</div>";
						//
					}
					echo '<div class="cl"><!-- --></div>';
				}
				echo "<div class='h25'><!-- --></div>";
			}
		}
		
	}//eof
	
	/*
	*	This funcion will return all the category id associated with a product id
	*	
	*	@param
	*			$pId		Product identity
	*
	*	@return array
	*/
	function getAllCatIdByProdId($pId)
	{
		//declare var
		$data	= array();
		
		//statement
		$select	= "SELECT categories_id FROM products_to_categories
				   WHERE product_id = '$pId'
				   ORDER BY categories_id DESC";
				   
		//execute query
		$query	= mysql_query($select);
		//echo $select.mysql_error();exit;
		
		//fetch and hold the data
		while($result	= mysql_fetch_array($query))
		{
			$data[]	= $result['categories_id'];
		}
		
		
		//return the data
		return $data;
		
	}//eof	
	
	function categoryDropDownLi($id,$level,$selected,$type,$cat_id, $table)
	{
		if($type == 'edit')
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id='$id' AND categories_id 
			<> $cat_id ORDER BY categories_name ";
		}
		else
		{
			$select = "SELECT * FROM ".$table." WHERE parent_id= $id ORDER BY categories_name ";
		}
		
		$query  = mysql_query($select);
		
		//echo $select.mysql_error();exit;
		
		while($result = mysql_fetch_array($query))
		{
			$new_cat_id = $result['categories_id'];
			if($selected == $new_cat_id)
			{
				$select_string = 'selected';
			}
			else
			{
				$select_string = '';
			}
			
			echo "<li value='".$new_cat_id."' id='menuText".$new_cat_id."' class='menuText' ".$select_string.">".
			str_repeat("&nbsp;&nbsp;&nbsp;",$level)." ".$result['categories_name'].
			"</li>";
			
			$this->categoryDropDownLi($new_cat_id,$level+1,$selected,$type,$cat_id, $table);
		}
	}//eof
	
}//eoc

?>