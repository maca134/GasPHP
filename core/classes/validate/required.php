<?php

class Validate_Required implements Validate_Ruleinterface {
	
	public function validate($value) {
		return (!empty($value)) ? true : false;
	}

	public function error() {
		return 'The %s field is required.';
	}

}