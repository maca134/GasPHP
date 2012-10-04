<?php

class ModelException extends Exception {}

abstract class Model {
	
	public static $_pdo = null;

	public static function _init()
	{
		if (get_called_class() !== 'Model') {
			if (static::$_pdo == null) {
				$db = Config::get('db');
				static::$_pdo = new PDO($db['dsn'], $db['username'], $db['password']);
			}
		}
	}

	public static function forge($data) {
		return new static($data, true);
	}

	public static function findById($id) {
		$sql = 'SELECT `' . implode('`, `', static::$_properties) . '` FROM `' . static::$_table . '` WHERE `' . static::$_primary . '` = :id' ;
		$prep = static::$_pdo->prepare($sql);
		$prep->execute(array('id' => $id));
		$row = $prep->fetch(PDO::FETCH_ASSOC);
		if ($row == false) {
			return false;
		}
		return new static($row, false);
	}

	public static function findAll() {
		$sql = 'SELECT `' . implode('`, `', static::$_properties) . '` FROM `' . static::$_table . '`';
		$prep = static::$_pdo->prepare($sql);
		$prep->execute();
		$models = array();
		while ($row = $prep->fetch(PDO::FETCH_ASSOC)) {
			$models[] = new static($row, false);
		}
		return $models;
	}

	private $_data = array();
	private $_orig_data = array();
	private $_new = true;

	private function __construct($data = array(), $new = true) {
		$this->_data = $this->_orig_data = $data;
		$this->_new = $new;
	}

	public function __set($name, $value) {
		if (!in_array($name, static::$_properties)) {
			throw new ModelException('The column ' . $name . ' does not exist');
		}
		$this->_data[$name] = $value;
	}
	
	public function __get($name) {
		if (!in_array($name, static::$_properties)) {
			throw new ModelException('The column ' . $name . ' does not exist');
		}
		return (isset($this->_data[$name])) ? $this->_data[$name] : null;
	}

	public function save() {
		if ($this->_new) {
			return $this->_create();
		} else {
			return $this->_update();
		}
	}

	private function _create() {
		$insert_data = array();
		$sql = 'INSERT INTO `' . static::$_table . '` (`' . implode('`, `', static::$_properties) . '`) VALUES (';
		foreach (static::$_properties as $column) {
			$sql .= ':' . $column . ', ';
			$insert_data[$column] = (isset($this->_data[$column])) ? $this->_data[$column] : '';
		}
		
		$sql = rtrim($sql, ', ');
		$sql .= ')';
		$prep = static::$_pdo->prepare($sql);
		
		if (!$prep->execute($insert_data)) {
			return false;
		}

		$id = static::$_pdo->lastInsertId();
		$this->_data['id'] = $id;
		$this->_new = false;
		$this->_orig_data = $this->_data;
		return true;
	}

	private function _update() {
		$sql = 'UPDATE `' . static::$_table . '` SET ';
		$update_data = array(static::$_primary => $this->_data[static::$_primary]);
		
		foreach (static::$_properties as $column) {
			if ($column == static::$_primary || !isset($this->_data[$column]))
				continue;
			if ($this->_data[$column] !== $this->_orig_data[$column]) {
				$sql .= '`' . $column . '` = :' . $column . ', ';
				$update_data[$column] = $this->_data[$column];
			}
		}
		$sql = rtrim($sql, ', ');
		$sql .= ' WHERE `' . static::$_primary . '` = :id';
		$prep = static::$_pdo->prepare($sql);

		if (!$prep->execute($update_data)) {
			return false;
		}
		$this->_orig_data = $this->_data;
		return true;
	}
}