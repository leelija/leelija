<?php

if(isset($_GET['path']))
{
	$path = $_GET['path'];
	//$dir = 'monidoc/'.$path;
	$dir = $path;
	//echo $dir; 
	//$link	='product_categories.php?seo_url='.$catDtl[10];
}
else{
	$dir = 'monidoc/';
}
 
if(isset($_GET['btnCreate']))
{
	$txtFolderName = $_GET['txtFolderName'];
	$dir = $_GET['txtdir'];
//	echo $dir;exit;
// Create new folders
//$curdir = getcwd();
if(mkdir($dir ."/".$txtFolderName , 0777)){
	echo "successful";
	}
	else{
		echo "Failed";
	
	}
}	
?>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get" enctype="multipart/form-data">
	 <input name="txtdir" type="text" class="text_box_large" id="txtdir" size="25" value="<?php echo $dir;?>" style="display:none;" />
	 <input name="txtFolderName" type="text" class="text_box_large" id="txtFolderName" size="25" />
	<input name="btnCreate" type="submit" class="button-add" id="btnCreate" value="Create New Folder" />
	</form>
<?php
 //echo $curdir;exit;
    $result = array();

    if (is_dir($dir)) {
            $iterator = new RecursiveDirectoryIterator($dir);
          //  foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {  
			foreach ($iterator as $file) {
                if (!$file->isFile()) {
					//echo "hi..";
                    $result[] = 'path: ' . $file->getPath(). ',  filename: ' . $file->getFilename();
					$path = $file->getPath(). '/'.$file->getFilename();
			?>		
					<a href="?path=<?php echo $path; ?>"><?php echo $file->getFilename(); ?></a><br>
			<?php		
                }
            }

    }

?>