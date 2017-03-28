<?php
class mySQL {
	private $host;
	private $db_name;
	private $db_user;
	private $db_pass;
	public $connect;
	public $result;
	public $sql;
	public $debug_prefix;

	public function __construct($debug_prefix = 'all') {
		if (DB_USE != 'mySQL') return;
		$this->debug_prefix = $debug_prefix;
		if(!defined('MYSQL_CONNECTION')) {
			$this->connect = mysql_connect(DB_HOST, DB_USER, DB_PASS);
			if (!$this->connect) { die ('Failed to connect to the server'.br.mysql_error()); }
			mysql_query ("SET NAMES UTF8");
			mysql_select_db(DB_DATABASE,$this->connect);
			if (mysql_errno() != 0) { die ('Failed to select_db'.br.mysql_error()); }
			define('MYSQL_CONNECTION', $this->connect);
		} else $this->connect = MYSQL_CONNECTION;
	}

	public function query() {
		global $LOG, $SQL_COUNTER;
		// debug_print_backtrace(); exit;
		$SQL_COUNTER++;
		$sqlLog = '';
		if (DEBUG == 1) {
			$fp = fopen('debug/sql.txt','a');
			fwrite($fp, $this->debug_prefix.': '.$SQL_COUNTER.rn);

		}
		if (func_num_args() > 1) $args = func_get_args();
		if (func_num_args() == 1) $args = func_get_arg(0);
		# $args = func_get_args();
		if (is_array($args)) {
			foreach($args as $key => &$arg) {
				if ($key == 0) continue;
				if (gettype ($arg) == 'array' ) { stop($args[0], 0); stop($arg); }
				$LOG->addToLog(array('arg'=>$arg), __LINE__, __METHOD__);
				$arg = mysql_real_escape_string($arg, $this->connect);
			}
		}
		if (is_array($args))
			$this->sql = call_user_func_array('sprintf', $args);
		else
			$this->sql = call_user_func('sprintf', $args);
		if (DEBUG == 1) {
			$a = array();
			$a = $args;
			$a0 = $args[0];
			$a = arrayTOhtmlspecialchars($a);
			$a[0] = $a0;
			if (is_array($a))
				$sqlLog = call_user_func_array('sprintf',$a);
			else
				$sqlLog = call_user_func('sprintf',$a);
		}
		if ($this->sql == '') {

			$LOG->addError(array('Пустой запрос')+$arg, __LINE__, __Method__);
		}

		$this->result = @mysql_query($this->sql, $this->connect);
		if (mysql_errno($this->connect) != 0) {
			$LOG->addError(array('Ошибка MySQL', mysql_errno($this->connect) => mysql_error() ),__LINE__,__METHOD__);
		}
		$LOG->addToLogSQL(array('SQL' => $sqlLog));
		if (mysql_errno() != 0) {
			$LOG->addError(array('Запрос не выполнен',mysql_error(),$this->sql), __LINE__, __Method__);
		}		
		if (DEBUG == 1) {   fclose($fp); }
		return $this->result;
	}

	public function fetchRow() {
		global $LOG;

		if(!is_resource($this->result)) #die ('Отсутствет результат запроса'.br.mysql_error().$this->sql);
		{
			$LOG->addToLog(array('sql:'=>$this->sql, 'err'=>'fetchRow Отсутствет результат запроса', 'type'=>gettype($this->result)), __LINE__, __METHOD__);
			return false;
		}
		return mysql_fetch_row($this->result);
	}
	public function fetchRowA() {
		global $LOG;

		if(!is_resource($this->result)) #die ('Отсутствет результат запроса'.br.mysql_error().$this->sql);
		{
			$LOG->addToLog(array('sql:'=>$this->sql, 'err'=>'fetchRowA Отсутствет результат запроса', 'type'=>gettype($this->result)), __LINE__, __METHOD__);
			return false;
		}
		return mysql_fetch_assoc($this->result);
	}
	/** * возвращает первый (нулевой) элемент из строки запроса */
	public function getOne() {
		if (func_num_args() != 0) {
			$args = func_get_args();
			$this->query($args);
		}
		if(!is_resource($this->result)) die ('getOne Отсутствет результат запроса'.br.mysql_error());
		$row = mysql_fetch_row($this->result);
		return $row[0];
	}

	/** возвращает первую строку по запросу */
	public function fetchOneRow() {
		if (func_num_args() != 0) {
			$args = func_get_args();
			$this->result = call_user_func_array($this.'->query', $args);
		}
		if(!is_resource($this->result)) die ('fetchOneRow Отсутствет результат запроса'.br.mysql_error());
		return mysql_fetch_row($this->result);
	}

	/** возвращает первую строку по запросу */
	public function fetchOneRowA() {
		if (func_num_args() != 0) {
			$args = func_get_args();
			$this->result = call_user_func_array($this.'->query', $args);
		}
		if(!is_resource($this->result)) { debug_print_backtrace(); die ('fetchOneRowA Отсутствет результат запроса'.br.mysql_error().br.$this->sql);}
		return mysql_fetch_assoc($this->result);
	}

	public function numRows() {
		if(is_resource($this->result)) return mysql_num_rows($this->result);
		return 0;
	}

	public function affectedRows() {
		$affectedRows = mysql_affected_rows();
		return $affectedRows;
	}

	public function insertID() {
		return mysql_insert_id();
	}
}


?>