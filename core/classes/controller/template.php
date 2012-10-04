<?php

abstract class Controller_Template extends Controller {
	
	protected $template = 'template';

	public function template($content, $title) {
		$data = array(
			'title' => $title,
			'content' => $content
			);
		
		$view = View::forge($this->template, $data)->render();
		$response = new Response($view);
		return $response;
	}

}