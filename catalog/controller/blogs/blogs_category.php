<?php
class ControllerBlogsBlogsCategory extends Controller {
	public function index() {
		$this->load->language('blogs/blogs_category');
		$this->load->model('catalog/blogs_category');
		$this->load->model('catalog/blogs');
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
			$limit = $this->config->get($this->config->get('config_theme') . '_blogs_limit');
		}
		

		$this->document->setTitle('Blogs Archive');
		$data['heading_title'] = ('Blogs Archive');

		$this->load->language('blogs/blogs');
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home','', 'SSL'),
			'text' => $this->language->get('text_home')
		);

		if (isset($this->request->get['blogs_category_id'])) {
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
			$parts = explode('_', (string)$this->request->get['blogs_category_id']);
			$blogs_category_id = (int)array_pop($parts);
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
				$blogs_category_info = $this->model_catalog_blogs_category->getBlogsCategory($path_id);
				if ($blogs_category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $blogs_category_info['name'],
						'href' => $this->url->link('blogs/blogs_category', 'blogs_category_id=' . $path . $url)
					);
				}
			}
		} else {
			$blogs_category_id = 0;
		}
		$blogs_category_info = $this->model_catalog_blogs_category->getBlogsCategory($blogs_category_id);
		if ($blogs_category_info) {
			$this->document->setTitle($blogs_category_info['meta_title']);
			$this->document->setDescription($blogs_category_info['meta_description']);
			$this->document->setKeywords($blogs_category_info['meta_keyword']);
			$data['heading_title'] = $blogs_category_info['name'];
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
			// Set the last blogs_category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $blogs_category_info['name'],
				'href' => $this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'])
			);
			if ($blogs_category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($blogs_category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_blogs_category_width'), $this->config->get($this->config->get('config_theme') . '_image_blogs_category_height'));
			} else {
				$data['thumb'] = '';
			}
			$data['description'] = html_entity_decode($blogs_category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('blogs/compare');
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
			$results = $this->model_catalog_blogs_category->getBlogsCategories($blogs_category_id);
			foreach ($results as $result) {
				$filter_data = array(
					'filter_blogs_category_id'  => $result['blogs_category_id'],
					'filter_sub_blogs_category' => true
				);
				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_blogs_count') ? ' (' . $this->model_catalog_blogs->getTotalBlogss($filter_data) . ')' : ''),
					'href' => $this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '_' . $result['blogs_category_id'] . $url)
				);
			}
			$data['blogss'] = array();
			$filter_data = array(
				'filter_blogs_category_id' => $blogs_category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$blogs_total = $this->model_catalog_blogs->getTotalBlogss($filter_data);
			$results = $this->model_catalog_blogs->getBlogss($filter_data);
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_blogs_width'), $this->config->get($this->config->get('config_theme') . '_image_blogs_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_blogs_width'), $this->config->get($this->config->get('config_theme') . '_image_blogs_height'));
				}
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				$data['blogss'][] = array(
					'blogs_id'  => $result['blogs_id'],
					'thumb'       => $image,
					'image'       => URL_HOME . 'image/' . $result['image'],
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_blogs_description_length')) . '..',
					'rating'      => $result['rating'],
					'href'        => str_replace(URL_HOME,'',$this->url->link('blogs/blogs', 'path=' . $this->request->get['path'] . '&blogs_id=' . $result['blogs_id'] . $url))
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
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url))
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url))
			);
			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url))
				);
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  =>  str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url))
				);
			}
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)) 
			);
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => str_replace(URL_HOME,'',$this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)) 
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
			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_blogs_limit'), 25, 50, 75, 100));
			sort($limits);
			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
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
			$pagination->total = $blogs_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('blogs/blogs_category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($blogs_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($blogs_total - $limit)) ? $blogs_total : ((($page - 1) * $limit) + $limit), $blogs_total, ceil($blogs_total / $limit));
			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('blogs/blogs_category', 'path=' . $blogs_category_info['blogs_category_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('blogs/blogs_category', 'path=' . $blogs_category_info['blogs_category_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('blogs/blogs_category', 'path=' . $blogs_category_info['blogs_category_id'] . '&page='. ($page - 1), true), 'prev');
			}
			if ($limit && ceil($blogs_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('blogs/blogs_category', 'path=' . $blogs_category_info['blogs_category_id'] . '&page='. ($page + 1), true), 'next');
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
			$this->response->setOutput($this->load->view('blogs/blogs_archive', $data));
			
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
				'href' => $this->url->link('blogs/blogs_category', $url)
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