<?php
use Illuminate\Support\MessageBag;

/**
 * The BaseForm class checks for the error messages we would normally store to flash (session) storage.
 * We would typically pull this data in each action, and now it will happen when each form class
 * instance is created.
 *
 * @author Taro
 *        
 */
class BaseForm {
	protected $passes;
	protected $errors;

	public function __construct() {
		$errors = new MessageBag ();
		
		if ($old = Input::old ( "errors" )) {
			$errors = $old;
		}
		
		$this->errors = $errors;
	}

	/**
	 * Gets all the input data and compares it to
	 * a set of provided validation rules.
	 *
	 * @param unknown $rules        	
	 */
	public function isValid($rules) {
		$validator = Validator::make ( Input::all (), $rules );
		$this->passes = $validator->passes ();
		$this->errors = $validator->errors ();
		return $this->passes;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setErrors(MessageBag $errors) {
		$this->errors = $errors;
		return $this;
	}

	public function hasErrors() {
		return $this->errors->any ();
	}

	public function getError($key) {
		return $this->getErrors ()->first ( $key );
	}

	public function isPosted() {
		return Input::server ( "REQUEST_METHOD" ) == "POST";
	}

}