<?php
class ControllerExtensionModuleBlogsRelated extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/blogs_related');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['name'] = $setting['name'];
		$this->load->model('catalog/blogs');
		$this->load->model('tool/image');
		$data['products'] = array();
		$filter_data = array(
			'sort'  => 'p.sort_order',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);
		$data['module_id'] = $setting['module_id'];
		$results = $this->model_catalog_blogs->getBlogss($filter_data);

		// Unset value routes blogs_id;
		$blogs_id = $this->request->get['blogs_id'];
		unset($results[$blogs_id]);

		if ($results) {
			foreach ($results as $result) {
				if ( $setting['width'] == 0 && $setting['height'] == 0 ) {
					$image = URL_HOME . 'image/' . $result['image'];
				} else {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}
				}
				
				$data['blogss'][] = array(
					'blogs_id'  => $result['blogs_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'href'        => str_replace(URL_HOME, '', $this->url->link('blogs/blogs', 'blogs_id=' . $result['blogs_id'])) 
				);
			}
			return $this->load->view('extension/module/blogs_related', $data);
		}
	}
}