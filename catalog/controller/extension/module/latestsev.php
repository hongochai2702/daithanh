<?php
class ControllerExtensionModuleLatestsev extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/latestsev');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$this->load->model('service/service');
		$this->load->model('tool/image');
		$data['products'] = array();
		$filter_data = array(
			'sort'  => 'p.sort_order',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$data['module_id'] = $setting['module_id'];
		$results = $this->model_service_service->getServices($filter_data);
		// var_dump($results);
		if ($results) {
			$i = 0;
			foreach ($results as $result) {
					if ($result['image']) {
						if($result == reset($results)) {
							$image = $this->model_tool_image->resize($result['image'], 738, 350);
						} else {
							$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
						}
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}
				$data['services'][] = array(
					'service_id'  => $result['service_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'href'        => str_replace(URL_HOME, '', $this->url->link('service/service', 'service_id=' . $result['service_id'])) 
				);
			}
			return $this->load->view('extension/module/latestsev', $data);
		}
	}
}