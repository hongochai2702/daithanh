<?php
class ControllerStartupRouter extends Controller {
	public function index() {
		// Route
		if (isset($this->request->get['routes']) && $this->request->get['routes'] != 'startup/router') {
			$routes = $this->request->get['routes'];
		} else {
			$routes = $this->config->get('action_default');
		}
		
		// Sanitize the call
		$routes = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routes);
		
		// Trigger the pre events
		$result = $this->event->trigger('controller/' . $routes . '/before', array(&$routes, &$data));
		
		if (!is_null($result)) {
			return $result;
		}
		
		// We dont want to use the loader class as it would make an controller callable.
		$action = new Action($routes);
		
		// Any output needs to be another Action object.
		$output = $action->execute($this->registry); 
		
		// Trigger the post events
		$result = $this->event->trigger('controller/' . $routes . '/after', array(&$routes, &$data, &$output));
		
		if (!is_null($result)) {
			return $result;
		}
		
		return $output;
	}
}
