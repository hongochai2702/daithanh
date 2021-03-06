<?php 
class ControllerPortfolioPortfolioCategory extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('portfolio/portfolio_category');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('portfolio/portfolio_category');
		$this->getList();
	}
	public function add() {
		$this->load->language('portfolio/portfolio_category');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('portfolio/portfolio_category');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_portfolio_category->addPortfolioCategory($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getForm();
	}
	public function edit() {
		$this->load->language('portfolio/portfolio_category');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('portfolio/portfolio_category');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_portfolio_category->editPortfolioCategory($this->request->get['portfolio_category_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getForm();
	}
	public function delete() {
		$this->load->language('portfolio/portfolio_category');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('portfolio/portfolio_category');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $portfolio_category_id) {

				$this->model_portfolio_portfolio_category->deletePortfolioCategory($portfolio_category_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if ($this->request->get['sort']) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if ($this->request->get['order']) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if ($this->request->get['page']) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getList();
	}
	public function repair() {
		$this->load->language('portfolio/portfolio_category');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('portfolio/portfolio_category');
		if ($this->validateRepair()) {
			$this->model_portfolio_portfolio_category->repairCategories();
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'], true));
		}
		$this->getList();
	}
	protected function getList() {
		$data = array();
		$data = $this->language->merge($data);
		$data['lagcode'] = $this->config->get('config_language');
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
		$url = '';
		if (isset($this->request->get['order'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url, true)
		);
		$data['add'] = $this->url->link('portfolio/portfolio_category/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('portfolio/portfolio_category/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['repair'] = $this->url->link('portfolio/portfolio_category/repair', 'token=' . $this->session->data['token'] . $url, true);
		$data['categories'] = array();
		$this->load->model('tool/image');
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$category_total = $this->model_portfolio_portfolio_category->getTotalCategories();
		$data['config_limit_admin'] = $this->config->get('config_limit_admin');
		$results = $this->model_portfolio_portfolio_category->getCategories($filter_data);
		$data['images'] = 'no_image.png';
			if (file_exists(DIR_IMAGE . $data['images'])) {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
		foreach ($results as $result) {
			$img_query = $this->db->query("SELECT image FROM ".DB_PREFIX."portfolio_category WHERE portfolio_category_id = '".(int)$result['portfolio_category_id']."'");
			$image = 'no_image.png';
			$query_result = $img_query->row;
			if ($query_result['image']) {
					$image = $query_result['image'];
			}
			if (file_exists(DIR_IMAGE . $image)) {
				$thumb = $this->model_tool_image->resize($image, 80, 80);
			} else{
				$thumb = $this->model_tool_image->resize('no_image.png', 80, 80);
			}
			$data['categories'][] = array(
				'portfolio_category_id' => $result['portfolio_category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'image'  => $thumb,
				'edit'        => $this->url->link('portfolio/portfolio_category/edit', 'token=' . $this->session->data['token'] . '&portfolio_category_id=' . $result['portfolio_category_id'] . $url, true),
				'delete'      => $this->url->link('portfolio/portfolio_category/delete', 'token=' . $this->session->data['token'] . '&portfolio_category_id=' . $result['portfolio_category_id'] . $url, true)
			);
		}
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_name'] = $this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('portfolio/portfolio_category_list', $data));
	}
	protected function getForm() {
		$data = array();
		
		$data['lagcode'] = $this->config->get('config_language');
		
		$data['text_form'] = !isset($this->request->get['portfolio_category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		if (isset($this->error['parent'])) {
			$data['error_parent'] = $this->error['parent'];
		} else {
			$data['error_parent'] = '';
		}
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url, true)
		);
		if (!isset($this->request->get['portfolio_category_id'])) {
			$data['action'] = $this->url->link('portfolio/portfolio_category/add', 'token=' . $this->session->data['token'] . $url, true);
			$data['action_add']  = true;
		} else {
			$data['action'] = $this->url->link('portfolio/portfolio_category/edit', 'token=' . $this->session->data['token'] . '&portfolio_category_id=' . $this->request->get['portfolio_category_id'] . $url, true);
		}
		$data['cancel'] = $this->url->link('portfolio/portfolio_category', 'token=' . $this->session->data['token'] . $url, true);
		if (isset($this->request->get['portfolio_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_portfolio_portfolio_category->getPortfolioCategory($this->request->get['portfolio_category_id']);
		}
		$data['token'] = $this->session->data['token'];
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->post['category_description'])) {
			$data['category_description'] = $this->request->post['category_description'];
		} elseif ($this->request->get['portfolio_category_id']) {
			$data['category_description'] = $this->model_portfolio_portfolio_category->getPortfolioCategoryDescriptions($this->request->get['portfolio_category_id']);
		} else {
			$data['category_description'] = array();
		}
		if (isset($this->request->post['path'])) {
			$data['path'] = $this->request->post['path'];
		} elseif (!empty($category_info)) {
			$data['path'] = $category_info['path'];
		} else {
			$data['path'] = '';
		}
		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$data['parent_id'] = $category_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}
		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->post['category_store'])) {
			$data['category_store'] = $this->request->post['category_store'];
		} elseif ($this->request->get['portfolio_category_id']) {
			$data['category_store'] = $this->model_portfolio_portfolio_category->getPortfolioCategoryStores($this->request->get['portfolio_category_id']);
		} else {
			$data['category_store'] = array(0);
		}
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($category_info)) {
			$data['keyword'] = $category_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = $category_info['image'];
		} else {
			$data['image'] = '';
		}
		$this->load->model('tool/image');
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($category_info)) {
			$data['top'] = $category_info['top'];
		} else {
			$data['top'] = 0;
		}
		if (isset($this->request->post['column'])) {
			$data['column'] = $this->request->post['column'];
		} elseif (!empty($category_info)) {
			$data['column'] = $category_info['column'];
		} else {
			$data['column'] = 1;
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = true;
		}
	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data = $this->language->merge($data);
		$this->response->setOutput($this->load->view('portfolio/portfolio_category_form', $data));
	}
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'portfolio/portfolio_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}
		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');
			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);
			if ($url_alias_info && $this->request->get['portfolio_category_id'] && $url_alias_info['query'] != 'portfolio_category_id=' . $this->request->get['portfolio_category_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
			if ($url_alias_info && !$this->request->get['portfolio_category_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
			if ($this->error && !isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
		}
		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'portfolio/portfolio_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'portfolio/portfolio_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	public function autocomplete() {
		$json = array();
		if ($this->request->get['filter_name']) {
			$this->load->model('portfolio/portfolio_category');
			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 15
			);
			$results = $this->model_portfolio_portfolio_category->getCategories($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'portfolio_category_id' => $result['portfolio_category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$sort_order = array();
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}
		array_multisort($sort_order, SORT_ASC, $json);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}