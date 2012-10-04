<?php
class ValidateException extends GeneralException {}

class Validate {

	public static function forge() {
		return new static;
	}

	private $rules = array();
	private $errors = array();

	public function add_rule($field, $name, $rule) {
		$class = 'Validate_' . ucwords($rule);
		try {
			$rule = new $class;

		} catch (GeneralException $e) {
			throw new ValidateException('The rule ' . $rule . ' does not exist');
		}
		$this->rules[$field][] = array(
			'name' => $name, 
			'rule' => $rule
			);
	}

	public function run() {
		foreach ($this->rules as $field => $rules) {
			$value = Input::post($field);
			foreach ($rules as $rule) {
				if (!$rule['rule']->validate($value)) {
					$this->errors[$field] = sprintf($rule['rule']->error(), $rule['name']);
				}
			}
		}
		return (count($this->errors) > 0) ? false : true;
	}

	public function errors() {
		return $this->errors;
	}
	
	public function error($field) {
		return (isset($this->errors[$field])) ? $this->errors[$field] : false;
	}

}

interface Validate_Ruleinterface {
	public function validate($value);
	public function error();
}