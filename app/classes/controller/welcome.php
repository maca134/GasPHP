<?php


class Controller_Welcome extends Controller_Template {
	
	public function action_index() {
		$title = 'Welcome';
		$data = array();
		$view = View::forge('welcome');
		$template = $this->template($view, $title)->render(); 
		return new Response($template);
	}

	public function action_docs() {
		$title = 'Docs';
		$data = array();
		$view = View::forge('docs');
		$template = $this->template($view, $title)->render(); 
		return new Response($template);
	}

}