<?php
class ControllerExtensionModuleTestimonialLatest extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/testimonial_latest');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$this->load->model('testimonial/testimonial');
		$this->load->model('tool/image');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = 9;
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$filter_data = array(
			'filter_testimonial_category_id' => $setting['category'],
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);

		$data['module_id'] = $setting['module_id'];
		$type = $setting['type'];
		$data['classes'] = $setting['classes'];
		$results = $this->model_testimonial_testimonial->getTestimonials($filter_data);
		$testimonial_total = $this->model_testimonial_testimonial->getTotalTestimonials($filter_data);
		
		$current = $this->request->get['_routes_'];
		$pagination = new Pagination();
		$pagination->total = $testimonial_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $current.'&page={page}' . $url;
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($testimonial_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($testimonial_total - $limit)) ? $testimonial_total : ((($page - 1) * $limit) + $limit), $testimonial_total, ceil($testimonial_total / $limit));
		$this->document->addStyle('catalog/view/theme/default/stylesheet/module/testimonial.css');
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
				$data['testimonials'][] = array(
					'testimonial_id'  => $result['testimonial_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'position'    => $result['position'],
					'description'    => $result['description'],
					'social_meta' => $result['social_meta'],
					'href'        => str_replace(URL_HOME, '', $this->url->link('testimonial/testimonial', 'testimonial_id=' . $result['testimonial_id'])) 
				);
			}
			if( $type == 'grid' ) {
				return $this->load->view('extension/module/testimonial_latest', $data);
			} else {
				return $this->load->view('extension/module/testimonial_carousel_latest', $data);
			}
		}
	}
}