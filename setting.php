<?php
	error_reporting(0);
	session_start();
	$_SESSION['user_id'] = 1;

	//データベース設定
	define( "DB_USER", "root" );
	define( "DB_PASS", "" );
	define( "DB_HOST", "localhost" );
	define( "DB_NAME", "fanzineShop" );

	//データベース接続用
	class DBAccess {
		var $connectType;	//1:SQLServer,2:MySQL,3:PostgreSQL
		var $user;	//ユーザID
		var $pass;	//パスワード
		var $host;	//データベースサーバ名
		var $db_name;	//利用データベース名

		var $connection;
		var $sqlCommand;
		var $sqlError;

		//データベースのデフォルト設定
		function __construct () {
			$this->connectType = 2;
			$this->user = DB_USER;
			$this->pass = DB_PASS;
			$this->host = DB_HOST;
			$this->db_name = DB_NAME;
			$this->sqlCommand = "";
			$this->sqlError = "";
		}

		//データベースの設定を変更する
		function set_database( $cType, $setUser, $setPass, $setHost, $setDB ) {
			$this->connectType = $cType;
			$this->user = $setUser;
			$this->pass = $setPass;
			$this->host = $setHost;
			$this->db_name = $setDB;
		}

		//データベースに接続する
		function connect_database( ) {
			$dsn = 'mysql:dbname='.$this->db_name.';host='.$this->host;
			$user = $this->user;
			$password = $this->pass;
			$this->connection = new PDO( $dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') );
			return $this->connection;
		}

		//文字列のサニタイズ
		function quote_smart( $val ){
			return $this->connection->quote( $val );
		}

		//SQLを実行する
		function execute_sql( $sqlState ) {
			$this->sqlCommand = $sqlState;
			$this->sqlError = "";
			try {
				$stmt = $this->connection->prepare( $sqlState );
				$stmt->execute();
				$result = $stmt->fetchAll();
				return $result;
			} catch ( Exception $e ) {
				$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				$this->sqlError =  $this->connection;
			}
		}

		//SQLを実行して一行だけフェッチする
		function execute_sql_ex( $sqlState ) {
			$this->sqlCommand = $sqlState;
			$this->sqlError = "";
			try {
				$stmt = $this->connection->prepare( $sqlState );
				$stmt->execute();
				$result = $stmt->fetch();
				return $result;
			} catch ( Exception $e ) {
				$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				$this->sqlError =  $this->connection;
			}
		}

		//データをフェッチする
		function fetch_sql ( $rs, $i ) {
			$ret = $rs[$i];
			return $ret;
		}
		//登録されたレコードの自動発番号を調べる
		function get_new_id( ) {
			$row = $this->connection->lastInsertId( );
			return $row;
		}

		//行数を調べる
		function count_row_sql( $rs ) {
			return count( $rs );
		}

		//SQLエラーを表示する
		function get_error( ) {
			$ret = "";
			if ( $this->sqlError != "" ) $ret = "SQLCommand:" . display_text( $this->sqlCommand  ). "<br>" . display_text( $this->sqlError );
			return $ret;
		}
	}

	//全ての文字をHTML用に変換
	function display_text( $text ) {
		return nl2br(str_replace(">","&gt;",str_replace("<","&lt;",stripslashes($text))));
	}

	//一部の文字をHTML用に変換(Form用)
	function display_form_text( $text ) {
		return stripslashes( htmlspecialchars($text,ENT_QUOTES) );
	}

	$db = new DBAccess;
	$db->connect_database();

	function largize( $str ) {
		$first = substr( $str, 0, 1 );
		$remain = substr( $str, 1 );
		return strtoupper( $first ) . $remain;
	}

?>
