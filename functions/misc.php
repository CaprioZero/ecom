<?php

    /***********************************************************
	*   Return all published items as a table
    *
    *	@param  boolean $paging
	*	@param  int  $startrow
	*   @param  int  $pagesize
	*	@return array
	*/
    function publishedproducts($paging, $startrow, $pagesize) {
	
        //echo("paging: " . $paging . "<br/>");
        //echo("startrow: " . $startrow . "<br/>");
        //echo("pagesize: " . $pagesize . "<br/>");
        //exit;
        $db = new Db();	
                $table = $db->query(
				   "SELECT * FROM items ORDER BY recid DESC"
				    );

				//$sql = " SELECT * FROM ipn_view_publishedproducts ORDER BY sortorder, item_number LIMIT :startrow, :pagesize ";
				//$params = array( 
				//	'0' => array ("startrow" => $intstartrow, "type" => PDO::PARAM_INT),
				//	'1' => array ("pagesize" => $intpagesize, "type" => PDO::PARAM_INT)
				//);
				//$table = $db->query($sql, $params);

         return $table;

    }
    /***********************************************************
	*   Return product details given the recid
    *
    *   @param int $recid
	*	@return array
	*/
    function getproductdetails($recid) {
        
        $db = new Db();

		$sql = " SELECT * FROM items WHERE recid = :recid ";       
		$params = array( 
			'0' => array ("recid" => $recid, "type" => PDO::PARAM_INT)
		);
		$table = $db->query( $sql, $params );

        return $table;
	}

?>