<?php
class ControllerCatalogFiltersev extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/filtersev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/filtersev');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/filtersev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/filtersev');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_filtersev->addFiltersev($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/filtersev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/filtersev');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_filtersev->editFiltersev($this->request->get['filtersev_group_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/filtersev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/filtersev');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $filtersev_group_id) {
				$this->model_catalog_filtersev->deleteFiltersev($filtersev_group_id);
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

			$this->response->redirect($this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'fgd.name';
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
			'href' => $this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/filtersev/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/filtersev/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['filtersevs'] = array();

		$filtersev_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$filtersev_total = $this->model_catalog_filtersev->getTotalFiltersevGroups();

		$results = $this->model_catalog_filtersev->getFiltersevGroups($filtersev_data);

		foreach ($results as $result) {
			$data['filtersevs'][] = array(
				'filtersev_group_id' => $result['filtersev_group_id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('catalog/filtersev/edit', 'token=' . $this->session->data['token'] . '&filtersev_group_id=' . $result['filtersev_group_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_group'] = $this->language->get('column_group');
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

		$data['sort_name'] = $this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . '&sort=fgd.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . '&sort=fg.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $filtersev_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($filtersev_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($filtersev_total - $this->config->get('config_limit_admin'))) ? $filtersev_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $filtersev_total, ceil($filtersev_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/filtersev_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['filtersev_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_group'] = $this->language->get('entry_group');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_filtersev_add'] = $this->language->get('button_filtersev_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['group'])) {
			$data['error_group'] = $this->error['group'];
		} else {
			$data['error_group'] = array();
		}

		if (isset($this->error['filtersev'])) {
			$data['error_filtersev'] = $this->error['filtersev'];
		} else {
			$data['error_filtersev'] = array();
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
			'href' => $this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['filtersev_group_id'])) {
			$data['action'] = $this->url->link('catalog/filtersev/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/filtersev/edit', 'token=' . $this->session->data['token'] . '&filtersev_group_id=' . $this->request->get['filtersev_group_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/filtersev', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['filtersev_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$filtersev_group_info = $this->model_catalog_filtersev->getFiltersevGroup($this->request->get['filtersev_group_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['filtersev_group_description'])) {
			$data['filtersev_group_description'] = $this->request->post['filtersev_group_description'];
		} elseif (isset($this->request->get['filtersev_group_id'])) {
			$data['filtersev_group_description'] = $this->model_catalog_filtersev->getFiltersevGroupDescriptions($this->request->get['filtersev_group_id']);
		} else {
			$data['filtersev_group_description'] = array();
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($filtersev_group_info)) {
			$data['sort_order'] = $filtersev_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['filtersev'])) {
			$data['filtersevs'] = $this->request->post['filtersev'];
		} elseif (isset($this->request->get['filtersev_group_id'])) {
			$data['filtersevs'] = $this->model_catalog_filtersev->getFiltersevDescriptions($this->request->get['filtersev_group_id']);
		} else {
			$data['filtersevs'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/filtersev_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/filtersev')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['filtersev_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
				$this->error['group'][$language_id] = $this->language->get('error_group');
			}
		}

		if (isset($this->request->post['filtersev'])) {
			foreach ($this->request->post['filtersev'] as $filtersev_id => $filtersev) {
				foreach ($filtersev['filtersev_description'] as $language_id => $filtersev_description) {
					if ((utf8_strlen($filtersev_description['name']) < 1) || (utf8_strlen($filtersev_description['name']) > 64)) {
						$this->error['filtersev'][$filtersev_id][$language_id] = $this->language->get('error_name');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/filtersev')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filtersev_name'])) {
			$this->load->model('catalog/filtersev');

			$filtersev_data = array(
				'filtersev_name' => $this->request->get['filtersev_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$filtersevs = $this->model_catalog_filtersev->getFiltersevs($filtersev_data);

			foreach ($filtersevs as $filtersev) {
				$json[] = array(
					'filtersev_id' => $filtersev['filtersev_id'],
					'name'      => strip_tags(html_entity_decode($filtersev['group'] . ' &gt; ' . $filtersev['name'], ENT_QUOTES, 'UTF-8'))
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