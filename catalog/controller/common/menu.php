<?php 
class ControllerCommonMenu extends Controller {
	public function index(){
		$this->response->setOutput($this->load->view('common/menu'));
	}
}