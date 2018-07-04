<?php
class ControllerServiceServiceCategory extends Controller {
	public function index() {
		$this->load->language('service/service_category');
		$this->load->model('catalog/service_category');
		$this->load->model('catalog/service');
		$this->load->model('tool/image');
		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}
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
			$limit = $this->config->get($this->config->get('config_theme') . '_service_limit');
		}
		
		$this->document->setTitle('Service Archive');
		$data['heading_title'] = ('Service Archive');

		$this->load->language('service/service');
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home','', 'SSL'),
			'text' => $this->language->get('text_home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$service_category_id = (int)array_pop($parts);
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
				$service_category_info = $this->model_catalog_service_category->getServiceCategory($path_id);
				if ($service_category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $service_category_info['name'],
						'href' => $this->url->link('service/service_category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$service_category_id = 0;
		}
		$service_category_info = $this->model_catalog_service_category->getServiceCategory($service_category_id);
		
		if ($service_category_info) {
			$this->document->setTitle($service_category_info['meta_title']);
			$this->document->setDescription($service_category_info['meta_description']);
			$this->document->setKeywords($service_category_info['meta_keyword']);
			$data['heading_title'] = $service_category_info['name'];
			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');
			// Set the last service_category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $service_category_info['name'],
				'href' => $this->url->link('service/service_category', 'path=' . $this->request->get['path'])
			);
			if ($service_category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($service_category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_service_category_width'), $this->config->get($this->config->get('config_theme') . '_image_service_category_height'));
			} else {
				$data['thumb'] = '';
			}
			$data['description'] = html_entity_decode($service_category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('service/compare');
			$url = '';
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
			$data['categories'] = array();
			$results = $this->model_catalog_service_category->getServiceCategories($service_category_id);
			
			foreach ($results as $result) {
				$filter_data = array(
					'filter_service_category_id'  => $result['service_category_id'],
					'filter_sub_service_category' => true
				);
				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_service_count') ? ' (' . $this->model_catalog_service->getTotalServices($filter_data) . ')' : ''),
					'href' => $this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '_' . $result['service_category_id'] . $url)
				);
			}
			$data['services'] = array();
			$filter_data = array(
				'filter_service_category_id' => $service_category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$service_total = $this->model_catalog_service->getTotalServices($filter_data);
			$results = $this->model_catalog_service->getServices($filter_data);
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_service_width'), $this->config->get($this->config->get('config_theme') . '_image_service_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_service_width'), $this->config->get($this->config->get('config_theme') . '_image_service_height'));
				}
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				$data['services'][] = array(
					'service_id'  => $result['service_id'],
					'thumb'       => $image,
					'image'       => URL_HOME . 'image/' . $result['image'],
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_service_description_length')) . '..',
					'rating'      => $result['rating'],
					'href'        => str_replace(URL_HOME,'',$this->url->link('service/service', 'path=' . $this->request->get['path'] . '&service_id=' . $result['service_id'] . $url))
				);
			}
			$url = '';
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$data['sorts'] = array();
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url))
			);
			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url))
				);
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  =>  str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url))
				);
			}
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)) 
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('service/service_category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)) 
			);
			$url = '';
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			$data['limits'] = array();
			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_service_limit'), 25, 50, 75, 100));
			sort($limits);
			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('service/service_category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}
			$url = '';
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
			$pagination = new Pagination();
			$pagination->total = $service_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('service/service_category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($service_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($service_total - $limit)) ? $service_total : ((($page - 1) * $limit) + $limit), $service_total, ceil($service_total / $limit));
			// http://googlewebmastercentral.servicepot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('service/service_category', 'path=' . $service_category_info['service_category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('service/service_category', 'path=' . $service_category_info['service_category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('service/service_category', 'path=' . $service_category_info['service_category_id'] . '&page='. ($page - 1), true), 'prev');
			}
			if ($limit && ceil($service_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('service/service_category', 'path=' . $service_category_info['service_category_id'] . '&page='. ($page + 1), true), 'next');
			}
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			$data['continue'] = $this->url->link('common/home');
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$this->response->setOutput($this->load->view('service/service_archive', $data));
			
		} else {
			$url = '';
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('service/service_category', $url)
			);
			$this->document->setTitle($this->language->get('text_error'));
			$data['heading_title'] = $this->language->get('text_error');
			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}