<?php
class ControllerCatalogOptionsev extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/optionsev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/optionsev');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/optionsev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/optionsev');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_optionsev->addOptionsev($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/optionsev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/optionsev');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_optionsev->editOptionsev($this->request->get['optionsev_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/optionsev');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/optionsev');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $optionsev_id) {
				$this->model_catalog_optionsev->deleteOptionsev($optionsev_id);
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

			$this->response->redirect($this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
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
			'href' => $this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/optionsev/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/optionsev/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['optionsevs'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$optionsev_total = $this->model_catalog_optionsev->getTotalOptionsevs();

		$results = $this->model_catalog_optionsev->getOptionsevs($filter_data);

		foreach ($results as $result) {
			$data['optionsevs'][] = array(
				'optionsev_id'  => $result['optionsev_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'edit'       => $this->url->link('catalog/optionsev/edit', 'token=' . $this->session->data['token'] . '&optionsev_id=' . $result['optionsev_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
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

		$data['sort_name'] = $this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . '&sort=od.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $optionsev_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($optionsev_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($optionsev_total - $this->config->get('config_limit_admin'))) ? $optionsev_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $optionsev_total, ceil($optionsev_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/optionsev_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['optionsev_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_choose'] = $this->language->get('text_choose');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_radio'] = $this->language->get('text_radio');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_input'] = $this->language->get('text_input');
		$data['text_text'] = $this->language->get('text_text');
		$data['text_textarea'] = $this->language->get('text_textarea');
		$data['text_file'] = $this->language->get('text_file');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_datetime'] = $this->language->get('text_datetime');
		$data['text_time'] = $this->language->get('text_time');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_optionsev_value'] = $this->language->get('entry_optionsev_value');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_optionsev_value_add'] = $this->language->get('button_optionsev_value_add');
		$data['button_remove'] = $this->language->get('button_remove');

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

		if (isset($this->error['optionsev_value'])) {
			$data['error_optionsev_value'] = $this->error['optionsev_value'];
		} else {
			$data['error_optionsev_value'] = array();
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
			'href' => $this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['optionsev_id'])) {
			$data['action'] = $this->url->link('catalog/optionsev/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/optionsev/edit', 'token=' . $this->session->data['token'] . '&optionsev_id=' . $this->request->get['optionsev_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/optionsev', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['optionsev_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$optionsev_info = $this->model_catalog_optionsev->getOptionsev($this->request->get['optionsev_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['optionsev_description'])) {
			$data['optionsev_description'] = $this->request->post['optionsev_description'];
		} elseif (isset($this->request->get['optionsev_id'])) {
			$data['optionsev_description'] = $this->model_catalog_optionsev->getOptionsevDescriptions($this->request->get['optionsev_id']);
		} else {
			$data['optionsev_description'] = array();
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($optionsev_info)) {
			$data['type'] = $optionsev_info['type'];
		} else {
			$data['type'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($optionsev_info)) {
			$data['sort_order'] = $optionsev_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['optionsev_value'])) {
			$optionsev_values = $this->request->post['optionsev_value'];
		} elseif (isset($this->request->get['optionsev_id'])) {
			$optionsev_values = $this->model_catalog_optionsev->getOptionsevValueDescriptions($this->request->get['optionsev_id']);
		} else {
			$optionsev_values = array();
		}

		$this->load->model('tool/image');

		$data['optionsev_values'] = array();

		foreach ($optionsev_values as $optionsev_value) {
			if (is_file(DIR_IMAGE . $optionsev_value['image'])) {
				$image = $optionsev_value['image'];
				$thumb = $optionsev_value['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['optionsev_values'][] = array(
				'optionsev_value_id'          => $optionsev_value['optionsev_value_id'],
				'optionsev_value_description' => $optionsev_value['optionsev_value_description'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order'               => $optionsev_value['sort_order']
			);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/optionsev_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/optionsev')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['optionsev_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['optionsev_value'])) {
			$this->error['warning'] = $this->language->get('error_type');
		}

		if (isset($this->request->post['optionsev_value'])) {
			foreach ($this->request->post['optionsev_value'] as $optionsev_value_id => $optionsev_value) {
				foreach ($optionsev_value['optionsev_value_description'] as $language_id => $optionsev_value_description) {
					if ((utf8_strlen($optionsev_value_description['name']) < 1) || (utf8_strlen($optionsev_value_description['name']) > 128)) {
						$this->error['optionsev_value'][$optionsev_value_id][$language_id] = $this->language->get('error_optionsev_value');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/optionsev')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/service');

		foreach ($this->request->post['selected'] as $optionsev_id) {
			$service_total = $this->model_catalog_service->getTotalServicesByOptionsevId($optionsev_id);

			if ($service_total) {
				$this->error['warning'] = sprintf($this->language->get('error_service'), $service_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->language('catalog/optionsev');

			$this->load->model('catalog/optionsev');

			$this->load->model('tool/image');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$optionsevs = $this->model_catalog_optionsev->getOptionsevs($filter_data);

			foreach ($optionsevs as $optionsev) {
				$optionsev_value_data = array();

				if ($optionsev['type'] == 'select' || $optionsev['type'] == 'radio' || $optionsev['type'] == 'checkbox' || $optionsev['type'] == 'image') {
					$optionsev_values = $this->model_catalog_optionsev->getOptionsevValues($optionsev['optionsev_id']);

					foreach ($optionsev_values as $optionsev_value) {
						if (is_file(DIR_IMAGE . $optionsev_value['image'])) {
							$image = $this->model_tool_image->resize($optionsev_value['image'], 50, 50);
						} else {
							$image = $this->model_tool_image->resize('no_image.png', 50, 50);
						}

						$optionsev_value_data[] = array(
							'optionsev_value_id' => $optionsev_value['optionsev_value_id'],
							'name'            => strip_tags(html_entity_decode($optionsev_value['name'], ENT_QUOTES, 'UTF-8')),
							'image'           => $image
						);
					}

					$sort_order = array();

					foreach ($optionsev_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}

					array_multisort($sort_order, SORT_ASC, $optionsev_value_data);
				}

				$type = '';

				if ($optionsev['type'] == 'select' || $optionsev['type'] == 'radio' || $optionsev['type'] == 'checkbox') {
					$type = $this->language->get('text_choose');
				}

				if ($optionsev['type'] == 'text' || $optionsev['type'] == 'textarea') {
					$type = $this->language->get('text_input');
				}

				if ($optionsev['type'] == 'file') {
					$type = $this->language->get('text_file');
				}

				if ($optionsev['type'] == 'date' || $optionsev['type'] == 'datetime' || $optionsev['type'] == 'time') {
					$type = $this->language->get('text_date');
				}

				$json[] = array(
					'optionsev_id'    => $optionsev['optionsev_id'],
					'name'         => strip_tags(html_entity_decode($optionsev['name'], ENT_QUOTES, 'UTF-8')),
					'categorysev'     => $type,
					'type'         => $optionsev['type'],
					'optionsev_value' => $optionsev_value_data
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