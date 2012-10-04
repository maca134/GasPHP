<?php

class Validate_Email implements Validate_Ruleinterface {

	public function validate($value) {
		return (filter_var($value, FILTER_VALIDATE_EMAIL)) ? true : false;
	}

	public function error() {
		return 'The %s field is not a valid email.';
	}

}