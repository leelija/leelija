<?php 
/**
*	This class manages logo of the website.
*		
*
*	@author     	Pijush Mondal
*	@date   	 	Dec 13, 2011
*	@version 		1.0
*	@copyright 		Analyze System
*	@email			support@ansysoft.com
*/

class Backup
{
	/**
	*	Get the current database name
	*
	*	@return string
	*/
	function getCurrentDatabase()
	{
		//declare var
		$dbName	= '';
		
		//statement
		$sql	= "SELECT DATABASE()";
		
		//execute query
		$query	= mysql_query($sql);
		
		//get the db name
		$dbName	= mysql_result($query, 0);
		
		//return result
		return $dbName;	
		
	}//eof
	
	
	//Dump data to csv file from data base
	function mysqlDumpCSV($table)
    {
        $delimiter= ",";
        if( isset($_REQUEST['csv_delimiter']))
     
            $delimiter= $_REQUEST['csv_delimiter'];

        if( 'Tab' == $delimiter)
     
            $delimiter="\t";

        $sql="select * from `$table`;";
     
        $result=mysql_query($sql);
     
        if( $result)
     
        {
		    $num_rows= mysql_num_rows($result);
            $num_fields= mysql_num_fields($result);
            $i=0;
     
            while( $i <$num_fields)
     
            {
			    $meta= mysql_fetch_field($result, $i);    
                echo($meta->name);   
                if( $i <$num_fields-1)
                 echo "$delimiter";     
                $i++;     
            }
			
            echo "\n";

            if( $num_rows> 0)     
            {
                while( $row= mysql_fetch_row($result))
                {
     			  for( $i=0; $i <$num_fields; $i++)    
                    {     
                        echo mysql_real_escape_string($row[$i]);
     
                        if( $i <$num_fields-1)
     
                                echo "$delimiter";
                    }     
                    echo "\n";
                }
            }    
        }     
        mysql_free_result($result);
    }//eof

	// Dump the database to sql file
    function mysqlDump($mysql_database)
    {
        $sql="show tables;";     
        $result= mysql_query($sql);    
        if( $result)     
        {
            while( $row= mysql_fetch_row($result))    
            {
                $this->mysqldumpTableStructure($row[0]);

                if( isset($_REQUEST['sql_table_data']))
                {
                   $this->mysqldumpTableData($row[0]);
                }
            }
        }
        else
        {
            echo "/* no tables in $mysql_database */\n";
        }     
        mysql_free_result($result);    
    }//eof

     //dump database tablewise  
    function mysqldumpTableStructure($table)
     
    {
        echo "/* Table structure for table `$table` */\n";
     
        if( isset($_REQUEST['sql_drop_table']))
        {    
            echo "DROP TABLE IF EXISTS `$table`;\n\n";    
        }
     
        if( isset($_REQUEST['sql_create_table']))
        {
            $sql="show create table `$table`; ";   
            $result=mysql_query($sql);
     
            if( $result)    
            {    
                if($row= mysql_fetch_assoc($result))     
                {    
                    echo $row['Create Table'].";\n\n";     
                }     
            }   
            mysql_free_result($result);    
        }    
    }//eof
     
     
    //dump database tablewise  
    function mysqldumpTableData($table)
     
    {
        $sql="select * from `$table`;";     
        $result=mysql_query($sql);
     
        if( $result)     
        {     
            $num_rows= mysql_num_rows($result);    
            $num_fields= mysql_num_fields($result);

            if( $num_rows> 0)    
            {
                echo "/* dumping data for table `$table` */\n";

                $field_type=array();     
                $i=0;     
                while( $i <$num_fields)    
                {
                    $meta= mysql_fetch_field($result, $i);
                    array_push($field_type, $meta->type);
                    $i++;   
                }

                //print_r( $field_type);
     
                echo "insert into `$table` values\n";
                $index=0;
     
                while( $row= mysql_fetch_row($result))
                {
                    echo "(";
                    for( $i=0; $i <$num_fields; $i++)
                    {
                        if( is_null( $row[$i]))
                            echo "null";
                        else
                        {
                            switch( $field_type[$i])
                            {
                               case 'int':
                                    echo $row[$i];
                                    break;
     
                                case 'string':
     
                                case 'blob' :
     
                                default:
     
                                    echo "'".mysql_real_escape_string($row[$i])."'";
                            }
                        }
     
                        if( $i <$num_fields-1)
                            echo ",";
                    }
     
                    echo ")";
                    if( $index <$num_rows-1)
                        echo ",";
                    else
                        echo ";";
                    echo "\n";
                    $index++;
     
                }
            }
        }     
        mysql_free_result($result);
        echo "\n";
    } //eof
     
	// For testing user and password of database
    function mysqlTest($mysql_host,$mysql_database, $mysql_username, $mysql_password)
     
    {    
        global $output_messages;
        $link = mysql_connect($mysql_host, $mysql_username, $mysql_password);
        if (!$link)
        {
           array_push($output_messages, 'Could not connect: ' . mysql_error());
        }
        else
        {
            array_push ($output_messages,"Connected with MySQL server:$mysql_username@$mysql_host successfully");
            $db_selected = mysql_select_db($mysql_database, $link);
			
            if (!$db_selected)
     
            {    
                array_push ($output_messages,'Can\'t use $mysql_database : ' . mysql_error());
     
            }
            else
                array_push ($output_messages,"Connected with MySQL database:$mysql_database successfully");
        }
    }//eof
} //eoc
?>