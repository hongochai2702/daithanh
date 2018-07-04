<?php
class ControllerServiceService extends Controller {

	private $error = array();
	public function index() {
		$this->load->language('service/service');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('service/service');
		$this->getList();
	}

	public function add() {
		$this->load->language('service/service');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('service/service');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_service_service->addService($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' .$this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getForm();
	}
	public function edit() {
		$this->load->language('service/service');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('service/service');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_service_service->editService($this->request->get['service_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' .$this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getForm();
	}
	public function delete() {
		$this->load->language('service/service');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('service/service');
		if ($this->request->post['selected'] && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $service_id) {
				$this->model_service_service->deleteService($service_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' .$this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getList();
	}
	public function copy() {
		$this->load->language('service/service');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('service/service');
		if ($this->request->post['selected'] && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $service_id) {
				$this->model_service_service->copyService($service_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' .$this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getList();
	}
	protected function getList() {
		$data = array();
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}
		if (isset($this->request->get['sort'])) {
			$sort =$this->request->get['sort'];
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
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href' => $this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, true)
		);
		$data['add'] = $this->url->link('service/service/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('service/service/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('service/service/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['services'] = array();
		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		$this->load->model('tool/image');
		$service_total = $this->model_service_service->getTotalServices($filter_data);
		$results = $this->model_service_service->getServices($filter_data);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			
			$data['services'][] = array(
				'service_id' => $result['service_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('service/service/edit', 'token=' . $this->session->data['token'] . '&service_id=' . $result['service_id'] . $url, true)
			);
		}
		$data['token'] = $this->session->data['token'];
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
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_name'] = $this->url->link('service/service', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_status'] = $this->url->link('service/service', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('service/service', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' .$this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $service_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('service/service', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($service_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($service_total - $this->config->get('config_limit_admin'))) ? $service_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $service_total, ceil($service_total / $this->config->get('config_limit_admin')));
		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data = $this->language->merge($data);
		$this->response->setOutput($this->load->view('service/service_list', $data));
	}
	protected function getForm() {
		$data['lagcode'] = $this->config->get('config_language');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_visual'] = $this->language->get('text_visual');
		$data['text_form'] = !isset($this->request->get['service_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
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
		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}
		if (isset($this->error['date_available'])) {
			$data['error_date_available'] = $this->error['date_available'];
		} else {
			$data['error_date_available'] = '';
		}
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		if (!isset($this->request->get['service_id'])) {
			$data['action'] = $this->url->link('service/service/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$data['action_add'] = true;
		} else {
			$data['action'] = $this->url->link('service/service/edit', 'token=' . $this->session->data['token'] . '&service_id=' . $this->request->get['service_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->url->link('service/service', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['service_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$service_info = $this->model_service_service->getService($this->request->get['service_id']);
		}
		
		
		$data['token'] = $this->session->data['token'];
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->post['service_description'])) {
			$data['service_description'] = $this->request->post['service_description'];
		} elseif (isset($this->request->get['service_id'])) {
			$data['service_description'] = $this->model_service_service->getServiceDescriptions($this->request->get['service_id']);
		} else {
			$data['service_description'] = array();
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($service_info)) {
			$data['image'] = $service_info['image'];
		} else {
			$data['image'] = '';
		}
		$this->load->model('tool/image');
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($service_info) && is_file(DIR_IMAGE . $service_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($service_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->post['service_store'])) {
			$data['service_store'] = $this->request->post['service_store'];
		} elseif (isset($this->request->get['service_id'])) {
			$data['service_store'] = $this->model_service_service->getServiceStores($this->request->get['service_id']);
		} else {
			$data['service_store'] = array(0);
		}
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($service_info)) {
			$data['keyword'] = $service_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($service_info)) {
			$data['date_available'] = ($service_info['date_available'] != '0000-00-00') ? $service_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($service_info)) {
			$data['sort_order'] = $service_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($service_info)) {
			$data['status'] = $service_info['status'];
		} else {
			$data['status'] = true;
		}
		// Categories
		$this->load->model('service/service_category');
		if (isset($this->request->post['service_category'])) {
			$categories = $this->request->post['service_category'];
		} elseif (isset($this->request->get['service_id'])) {
			$categories = $this->model_service_service->getServiceCategories($this->request->get['service_id']);
		} else {
			$categories = array();
		}
			
		$data['service_categories'] = array();
		foreach ($categories as $service_category_id) {
			$category_info = $this->model_service_service_category->getServiceCategory($service_category_id);
			if ($category_info) {
				$data['service_categories'][] = array(
					'service_category_id' => $category_info['service_category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}
		
		// Images
		if (isset($this->request->post['service_image'])) {
			$service_images = $this->request->post['service_image'];
		} elseif (isset($this->request->get['service_id'])) {
			$service_images = $this->model_service_service->getServiceImages($this->request->get['service_id']);
		} else {
			$service_images = array();
		}
		$data['service_images'] = array();
		foreach ($service_images as $service_image) {
			if (is_file(DIR_IMAGE . $service_image['image'])) {
				$image = $service_image['image'];
				$thumb = $service_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}
			$data['service_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $service_image['sort_order']
			);
		}
		if (isset($this->request->post['service_layout'])) {
			$data['service_layout'] = $this->request->post['service_layout'];
		} elseif (isset($this->request->get['service_id'])) {
			$data['service_layout'] = $this->model_service_service->getServiceLayouts($this->request->get['service_id']);
		} else {
			$data['service_layout'] = array();
		}
		$data['image_manager_status']  = $this->config->get('image_manager_status'); 
		if (isset($this->request->get['service_id'])) {
				$data['service_id'] = $this->request->get['service_id'];
		} else {
				$data['service_id'] = 0;
		}
		$this->load->model('design/layout');
		$data['layouts'] = $this->model_design_layout->getLayouts();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data = $this->language->merge($data);
		$this->response->setOutput($this->load->view('service/service_form', $data));
	}
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'service/service')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['service_description'] as $language_id => $value) {
			if ((strlen($value['name']) < 3) || (strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
			
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		return !$this->error;
	}
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'service/service')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'service/service')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	public function autocomplete() {
		$json = array();
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('service/service');
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get('limit');
			} else {
				$limit = 15;
			}
			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);
			$results = $this->model_service_service->getServices($filter_data);
			foreach ($results as $result) {
				
				$json[] = array(
					'service_id' => $result['service_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}