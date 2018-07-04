<?php
class ControllerExtensionModulePortfolioLatest extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/portfolio_latest');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$this->load->model('catalog/portfolio');
		$this->load->model('tool/image');
		$data['products'] = array();
		$filter_data = array(
			'sort'  => 'p.sort_order',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$data['module_id'] = $setting['module_id'];
		$results = $this->model_catalog_portfolio->getPortfolios($filter_data);
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
				
				$data['portfolios'][] = array(
					'portfolio_id'  	=> $result['portfolio_id'],
					'thumb'       		=> $image,
					'name'        		=> $result['name'],
					'short_description' => html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
					'description' 		=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'href'        		=> str_replace(URL_HOME, '', $this->url->link('portfolio/portfolio', 'portfolio_id=' . $result['portfolio_id'])) 
				);
			}
			return $this->load->view('extension/module/portfolio_latest', $data);
		}
	}
}