<?php
class ControllerServiceService extends Controller {
	public function index() {
		$this->load->language('service/service');

		$this->load->model('catalog/service');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_service'),
			'href' => $this->url->link('service/service')
		);

		if (isset($this->request->get['service_id'])) {
			$service_id = (int)$this->request->get['service_id'];
		} else {
			$service_id = 0;
		}

		$service_info = $this->model_catalog_service->getService($service_id);
		// var_dump($service_info);
		if ($service_info) {
			$this->document->setTitle($service_info['meta_title']);
			$this->document->setDescription($service_info['meta_description']);
			$this->document->setKeywords($service_info['meta_keyword']);
			
			$data['breadcrumbs'][] = array(
				'text' => $service_info['name'],
				'href' => $this->url->link('service/service', 'service_id=' .  $service_id)
			);

			$data['heading_title'] = $service_info['name'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['name'] 			= $service_info['name'];
			$data['image'] 			= URL_HOME . 'image/' .$service_info['image'];
			$data['description'] 	= html_entity_decode($service_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('service/service_single', $data));
	}
}