<?php

class DatabaseManager {

    private $Connection;
    private $Query;
    private $Result;

    public function __construct($Server,$Username,$Password,$Database) {
        $this->Connection = mysql_connect($Server,$Username,$Password);
        if (!$this->Connection) {
            throw ("Not connected : " . mysql_error());
        }

        $SelectedDB = mysql_select_db($Database, $this->Connection);
        if (!$SelectedDB) {
            throw("Can\'t use db : " . mysql_error());
        }
        
        register_shutdown_function(array($this, '__destruct'));
    }
    
    public function setQuery($Query)
    {
        $this->Query = $Query;
    }
    
    //Return a Single Value
    public function loadResult()
    {
		if (!($cur = $this->Query())) {
			return null;
		}
		$ret = null;
		if ($row = mysql_fetch_row( $cur )) {
			$ret = $row[0];
		}
		mysql_free_result( $cur );
		return $ret;        
    }
    
    //Return one Row
    public function loadObject()
    {
		if (!($cur = $this->Query())) {
			return null;
		}
		$ret = null;
		if ($object = mysql_fetch_object( $cur )) {
			$ret = $object;
		}
		mysql_free_result( $cur );
		return $ret;        
    }
    
    //Return List of Rows
    public function loadObjectList()
    {
 		if (!($cur = $this->Query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_object( $cur )) {
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
		return $array;       
    } 
    
    public function loadArrayList()
    {
        if (!($cur = $this->Query())) {
            return null;
	}        
        $array = mysql_fetch_array($cur);
 	mysql_free_result( $cur );
	return $array;       
    }
    
    public function getNumRows()
    {
        return mysql_num_rows( $this->Result );
    }
    
    public function insertid()
    {
       return mysql_insert_id( $this->Connection ); 
    }
    
 	function Query()
	{
		if (!is_resource($this->Connection)) {
			return false;
		}

		// Take a local copy so that we don't modify the original query and cause issues later
		$sql = $this->Query;

		set_time_limit (0);
		$this->Result = mysql_query( $sql, $this->Connection );

		if (!$this->Result)
		{
                    throw new Exception(mysql_error( $this->Connection )." SQL=$sql");
                    return false;
		}
		return $this->Result;
	}   
    
 	function __destruct()
	{
            $return = false;
            if (is_resource($this->Connection)) {
                $return = mysql_close($this->Connection);
            }
            return $return;
	}   
}

?>