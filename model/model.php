<?php
	namespace models;

	class Model {
		var $class;
		var $tableName;
		function __construct() {
			$this->class = explode( '\\', get_class( $this ) );
			$this->class = $this->class[count($this->class)-1];
			$this->tableName = strtolower( $this->class );
		}

		function all( $where = '' ) {
			global $db;
			$strSQL = "select * from {$this->tableName}_table where {$this->tableName}_deleted_at is null";
			$strSQL .= ($where=='')?'':" and {$where}";
			$ret = $db->execute_sql( $strSQL );
			return $ret;
		}

		function findOrFail( $id ) {
			global $db;
			$strSQL = "select * from {$this->tableName}_table where {$this->tableName}_id = {$id} and {$this->tableName}_deleted_at is null";
			if ( $ret = $db->execute_sql_ex( $strSQL ) ) {
				return $ret;
			} else {
				return false;
			}
		}

		function myFind( $strSQL ) {
			global $db;
			$ret = $db->execute_sql( $strSQL );
			return $ret;
		}

		function insert( $param ) {
			global $db;
			$columns = '';
			$values = '';
			foreach( $param as $column => $value ) {
				$columns .= (($columns=='')?'':',').$column;
				$values .= (($values=='')?'':',').$value;
			}
			$strSQL = "insert into {$this->tableName}_table ( {$columns} ) values ( {$values} )";
			$db->execute_sql( $strSQL );
		}

		function update( $param, $id, $where='', $null=false ) {
			global $db;
			$update = '';
			foreach( $param as $column => $value ) {
				$update .= (($update=='')?'':',').$column.'='.$value;
			}
			$wheres = "where ".(($id!='')?($this->tableName.'_id='.$id):'').' '.$where.($null?'':(' and '.$this->tableName.'_deleted_at is null'));
			$strSQL = "update {$this->tableName}_table set {$update} ".$wheres;
			$db->execute_sql( $strSQL );
			return $strSQL;
		}

		function delete( $ids ) {
			global $db;
			$id_list = implode( ',', $ids );
			$strSQL = "update {$this->tableName}_table set {$this->tableName}_deleted_at = now() where {$this->tableName}_id in ( $id_list ) and {$this->tableName}_deleted_at is null";
			$db->execute_sql( $strSQL );
			return $strSQL;
		}

		function lastId() {
			global $db;
			$ret = $db->get_new_id();
			return $ret;
		}

		function getError() {
			global $db;
			return $db->get_error();
		}
	}

?>
