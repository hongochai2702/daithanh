<?php
class ControllerPostTypePages extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('post_type/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('post_type/pages');

		$this->getList();
	}

	public function add() {
		$this->load->language('post_type/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('post_type/pages');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_post_type_pages->addPostType($this->request->post);

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

			$this->response->redirect($this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('post_type/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('post_type/pages');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_post_type_pages->editPostType($this->request->get['post_type_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('post_type/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('post_type/pages');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $post_type_id) {
				$this->model_post_type_pages->deletePostType($post_type_id);
			}

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

			$this->response->redirect($this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	private function get_list_module($data) {

		$list_modules = '';
		if ( !empty($data) ) {
			$modules = explode(',', $data);
			if ( !empty($modules) ) {
				$this->load->model('extension/module');
				foreach ($modules as $md) {
					$module_data = $this->model_extension_module->getModule( $md );
					$list_modules .= sprintf('<a href="%s" target="_blank">%s</a>, ',
						$this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'] . '&module_id=' . $module_data['moduleid'] ),
						$module_data['name']
					);
				}
			}
		}
		
		return $list_modules;
	}

	protected function getList() {
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id.title';
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
			'href' => $this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('post_type/pages/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('post_type/pages/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['post_types'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$post_type_total = $this->model_post_type_pages->getTotalPostTypes();

		$results = $this->model_post_type_pages->getPostTypes($filter_data);
		$list_modules = '';
		$this->load->model('extension/module');
		// var_dump($module_data['name']);
		foreach ($results as $result) {

			$data['post_types'][] = array(
				'post_type_id' 	=> $result['post_type_id'],
				'title'         => $result['title'],
				'modules'       => $this->get_list_module($result['modules']),
				'sort_order'    => $result['sort_order'],
				'edit'          => $this->url->link('post_type/pages/edit', 'token=' . $this->session->data['token'] . '&post_type_id=' . $result['post_type_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_modules'] = $this->language->get('column_modules');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		$data['sort_title'] = $this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $post_type_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($post_type_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($post_type_total - $this->config->get('config_limit_admin'))) ? $post_type_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $post_type_total, ceil($post_type_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('post_type/pages_list', $data));
	}

	protected function getForm() {
		// Load library jquery.
		$this->document->addScript('view/javascript/jquery/jquery-ui/jquery-ui.js');
		$this->document->addStyle('view/javascript/jquery/selectize/selectize.css');
		$this->document->addScript('view/javascript/jquery/selectize/selectize.js');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['post_type_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data = $this->language->merge($data);
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
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
			'href' => $this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['post_type_id'])) {
			$data['action'] = $this->url->link('post_type/pages/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('post_type/pages/edit', 'token=' . $this->session->data['token'] . '&post_type_id=' . $this->request->get['post_type_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('post_type/pages', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['post_type_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$post_type_info = $this->model_post_type_pages->getPostType($this->request->get['post_type_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['post_type_description'])) {
			$data['post_type_description'] = $this->request->post['post_type_description'];
		} elseif (isset($this->request->get['post_type_id'])) {
			$data['post_type_description'] = $this->model_post_type_pages->getPostTypeDescriptions($this->request->get['post_type_id']);
		} else {
			$data['post_type_description'] = array();
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} else if(!empty($post_type_info)) {
			$data['type'] = $post_type_info['type'];
		} else {
			$data['type'] = 'page';
		}

		$this->load->model('extension/module');
		$module_builder_data = $this->model_extension_module->getModulesByCode( 'so_page_builder' );
		foreach ($module_builder_data as $val) {
			$data['module_so_builder'][] = array(
				'module_id' => $val['module_id'],
				'name' => $val['name'],
				'code' => $val['code']
			);
		}

		$data['module_so_builder'] = json_encode($data['module_so_builder']);

		if (isset($this->request->post['modules'])) {
			$data['modules'] = $this->request->post['modules'];
		} else if( !empty($post_type_info) ) {
			$data['modules'] = $post_type_info['modules'];
		} else {
			$data['modules'] = '';
		}


		if (isset($this->request->post['post_type_store'])) {
			$data['post_type_store'] = $this->request->post['post_type_store'];
		} elseif (isset($this->request->get['post_type_id'])) {
			$data['post_type_store'] = $this->model_post_type_pages->getPostTypeStores($this->request->get['post_type_id']);
		} else {
			$data['post_type_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($post_type_info)) {
			$data['keyword'] = $post_type_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['bottom'])) {
			$data['bottom'] = $this->request->post['bottom'];
		} elseif (!empty($post_type_info)) {
			$data['bottom'] = $post_type_info['bottom'];
		} else {
			$data['bottom'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($post_type_info)) {
			$data['status'] = $post_type_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($post_type_info)) {
			$data['sort_order'] = $post_type_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['post_type_layout'])) {
			$data['post_type_layout'] = $this->request->post['post_type_layout'];
		} elseif (isset($this->request->get['post_type_id'])) {
			$data['post_type_layout'] = $this->model_post_type_pages->getPostTypeLayouts($this->request->get['post_type_id']);
		} else {
			$data['post_type_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('post_type/pages_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'post_type/pages')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['post_type_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['post_type_id']) && $url_alias_info['query'] != 'post_type_id=' . $this->request->get['post_type_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['post_type_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'post_type/pages')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// $this->load->model('setting/store');

		// foreach ($this->request->post['selected'] as $post_type_id) {
		// 	if ($this->config->get('config_account_id') == $post_type_id) {
		// 		$this->error['warning'] = $this->language->get('error_account');
		// 	}

		// 	if ($this->config->get('config_checkout_id') == $post_type_id) {
		// 		$this->error['warning'] = $this->language->get('error_checkout');
		// 	}

		// 	if ($this->config->get('config_affiliate_id') == $post_type_id) {
		// 		$this->error['warning'] = $this->language->get('error_affiliate');
		// 	}

		// 	if ($this->config->get('config_return_id') == $post_type_id) {
		// 		$this->error['warning'] = $this->language->get('error_return');
		// 	}

			// $store_total = $this->model_setting_store->getTotalStoresByPostTypeId($post_type_id);

			// if ($store_total) {
			// 	$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			// }
		// }

		return !$this->error;
	}
}