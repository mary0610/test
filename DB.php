<?php

/**
 * Class DB
 * Hass all functions that has any relation to MySQL operations
 */
class DB {
	private $connection;
	protected static $_instance;
	/**
	 * let's use singletone pattern here
	 */
	public static function getInstance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * will put a connection here
	 */
	function __construct () {
		$this->connection = mysql_connect( 'localhost', 'root', '1' );
		mysql_select_db( 'test', $this->connection );
	}

	/**
	 * makes a query to the database and returns object of data in case of success.
	 * @param|string $query
	 *
	 * @return object|stdClass
	 * @throws Exception
	 */
	public function check_query( $query ) {
		if ( ! $this->connection ) {
			throw new Exception ('Connection failed');
		}
		$mquery = mysql_query( $query );
		if ( ! $mquery ) {
			throw new Exception( 'The query failed' );
		}
		return mysql_fetch_object( $mquery );
	}

	/**
	 * process an exception and returns set of data from the database
	 * @param $query
	 *
	 * @return object|stdClass
	 */
	public function query( $query ) {
		try	{
			$result = $this->check_query( $query );
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}
		return $result;
	}
}
