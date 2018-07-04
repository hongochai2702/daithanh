<?php
class ControllerPortfolioCategory extends Controller {
	public function index() {
		$this->load->language('portfolio/portfolio_category');
		$this->load->model('catalog/portfolio_category');
		$this->load->model('catalog/portfolio');
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
			$limit = $this->config->get($this->config->get('config_theme') . '_portfolio_limit');
		}
		
		$this->load->language('portfolio/portfolio');
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home','', 'SSL'),
			'text' => $this->language->get('text_home')
		);

		if (isset($this->request->get['pathpor'])) {
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
			$parts = explode('_', (string)$this->request->get['pathpor']);
			$portfolio_category_id = (int)array_pop($parts);
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
				$portfolio_category_info = $this->model_catalog_portfolio_category->getPortfolioCategory($path_id);
				if ($portfolio_category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $portfolio_category_info['name'],
						'href' => $this->url->link('portfolio/category', 'pathpor=' . $path . $url)
					);
					$this->document->setTitle($portfolio_category_info['name']);
					$data['heading_title'] = $portfolio_category_info['name'];
				}
			}
		} else {
			$portfolio_category_id = 0;
		}
		$portfolio_category_info = $this->model_catalog_portfolio_category->getPortfolioCategory($portfolio_category_id);
		
		if ($portfolio_category_info) {
			$this->document->setTitle($portfolio_category_info['meta_title']);
			$this->document->setDescription($portfolio_category_info['meta_description']);
			$this->document->setKeywords($portfolio_category_info['meta_keyword']);
			$data['heading_title'] = $portfolio_category_info['name'];
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
			// Set the last portfolio_category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $portfolio_category_info['name'],
				'href' => $this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'])
			);
			if ($portfolio_category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($portfolio_category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_portfolio_category_width'), $this->config->get($this->config->get('config_theme') . '_image_portfolio_category_height'));
			} else {
				$data['thumb'] = '';
			}
			$data['description'] = html_entity_decode($portfolio_category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('portfolio/compare');
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
			$results = $this->model_catalog_portfolio_category->getPortfolioCategories(0);
			foreach ($results as $result) {
				$filter_data = array(
					'filter_portfolio_category_id'  => $result['portfolio_category_id'],
					'filter_sub_portfolio_category' => true
				);
				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_portfolio_count') ? ' (' . $this->model_catalog_portfolio->getTotalPortfolios($filter_data) . ')' : ''),
					'href' => $this->url->link('portfolio/category', 'pathpor=' . $result['portfolio_category_id'] . $url)
				);
			}
		
			$data['portfolios'] = array();
			$filter_data = array(
				// 'filter_portfolio_category_id' => $portfolio_category_id,
				'filter_portfolio_category_id' => 0, // Get all
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => 9
				// 'limit'              => $limit
			);
			$portfolio_total = $this->model_catalog_portfolio->getTotalPortfolios($filter_data);
			$results = $this->model_catalog_portfolio->getPortfolios($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 340, 280);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 340, 280);
				}
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				$data['portfolios'][] = array(
					'portfolio_id'  => $result['portfolio_id'],
					'thumb'       => $image,
					'image'       => URL_HOME . 'image/' . $result['image'],
					'name'        => $result['name'],
					'short_description' => strip_tags($result['short_description']),
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_portfolio_description_length')) . '..',
					'rating'      => $result['rating'],
					'href'        => $this->url->link('portfolio/portfolio', 'pathpor=' . $this->request->get['pathpor'] . '&portfolio_id=' . $result['portfolio_id'] . $url)
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
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=p.sort_order&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=pd.name&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=pd.name&order=DESC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=p.price&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=p.price&order=DESC' . $url))
			);
			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=rating&order=DESC' . $url))
				);
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  =>  str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=rating&order=ASC' . $url))
				);
			}
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=p.model&order=ASC' . $url)) 
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . '&sort=p.model&order=DESC' . $url)) 
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
			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_portfolio_limit'), 25, 50, 75, 100));
			sort($limits);
			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . $url . '&limit=' . $value)
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
			$pagination->total = $portfolio_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text_last = '<span class="text_last">&gt;|</span>';
			$pagination->text_next = '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
			$pagination->text_prev = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
			$pagination->url = $this->url->link('portfolio/category', 'pathpor=' . $this->request->get['pathpor'] . $url . '&page={page}');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($portfolio_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($portfolio_total - $limit)) ? $portfolio_total : ((($page - 1) * $limit) + $limit), $portfolio_total, ceil($portfolio_total / $limit));
			// http://googlewebmastercentral.portfoliopot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('portfolio/category', 'pathpor=' . $portfolio_category_info['portfolio_category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('portfolio/category', 'pathpor=' . $portfolio_category_info['portfolio_category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('portfolio/category', 'pathpor=' . $portfolio_category_info['portfolio_category_id'] . '&page='. ($page - 1), true), 'prev');
			}
			if ($limit && ceil($portfolio_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('portfolio/category', 'pathpor=' . $portfolio_category_info['portfolio_category_id'] . '&page='. ($page + 1), true), 'next');
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
			$this->response->setOutput($this->load->view('portfolio/portfolio_archive', $data));
			
		} else {
			$url = '';
			if (isset($this->request->get['pathpor'])) {
				$url .= '&path=' . $this->request->get['pathpor'];
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
				'href' => $this->url->link('portfolio/category', $url)
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