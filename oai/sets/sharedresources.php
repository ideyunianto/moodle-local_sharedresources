<?php

// Here are a couple of queries which might need to be adjusted to 
// your needs. Normally, if you have correctly named the columns above,
// this does not need to be done.

// this function should generate a query which will return
// all records
// the useless condition id_column = id_column is just there to ease
// further extensions to the query, please leave it as it is.
function selectAllQuery ($id = ''){
	global $CFG;

	if ($id == '') {
		$identityClause = 'id = id';
	} else {
		$identityClause  = " identifier = '$id' ";
	}
	
	$validityClause = ' AND isvalid = 1';
	$validityClause = '';

	$sql = "
	    SELECT 
	        *,
	        title as shortname,
	        timemodified as datestamp,
	        identifier as oaiid,
	        'sharedresources' as `set`
	    FROM 
	        {sharedresource_entry}
	    WHERE 
	        $identityClause
	        $validityClause
	";

	return $sql;
}

// this function will return identifier and datestamp for all records
function idQuery ($id = ''){
	global $CFG;
	global $OAI;

	if ($id == '') {
		$identityClause = 'id = id';
	} else {
		$identityClause = " identifier = '$id' ";
	}

	$validityClause = ' AND isvalid = 1';

	$sql = "
	    SELECT 
	        identifier as oaiid,
	        timemodified as datestamp,
	        'sharedresources' as `set`
	    FROM 
	        {sharedresource_entry}
	    WHERE 
	        $identityClause
	        $validityClause
	";

	return $sql;
}

// filter for until
function untilQuery($until) {
    global $OAI;
    
    $until = datestamp2unix($OAI->until);
	return " AND timemodified <= '$until' ";
}

// filter for from
function fromQuery($from){
    global $OAI;

    $from = datestamp2unix($OAI->from);
	return " AND timemodified >= '$from' ";
}

// filter for sets
function setQuery($set){
    global $OAI;

    return '';
}

/**
* tels if
*/
function isDeleted($id){
    return false;
}

?>