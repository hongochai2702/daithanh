<?php

class ControllerCatalogService extends Controller {

	private $error = array();



	public function index() {

		$this->load->language('catalog/service');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('catalog/service');



		$this->getList();

	}



	public function add() {

		$this->load->language('catalog/service');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('catalog/service');



		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_service->addService($this->request->post);



			$this->session->data['success'] = $this->language->get('text_success');



			$url = '';



			if (isset($this->request->get['filter_name'])) {

				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_model'])) {

				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_price'])) {

				$url .= '&filter_price=' . $this->request->get['filter_price'];

			}



			if (isset($this->request->get['filter_quantity'])) {

				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

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



			$this->response->redirect($this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true));

		}



		$this->getForm();

	}



	public function edit() {

		$this->load->language('catalog/service');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('catalog/service');



		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_service->editService($this->request->get['service_id'], $this->request->post);



			$this->session->data['success'] = $this->language->get('text_success');



			$url = '';



			if (isset($this->request->get['filter_name'])) {

				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_model'])) {

				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_price'])) {

				$url .= '&filter_price=' . $this->request->get['filter_price'];

			}



			if (isset($this->request->get['filter_quantity'])) {

				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

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



			$this->response->redirect($this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true));

		}



		$this->getForm();

	}



	public function delete() {

		$this->load->language('catalog/service');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('catalog/service');



		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $service_id) {

				$this->model_catalog_service->deleteService($service_id);

			}



			$this->session->data['success'] = $this->language->get('text_success');



			$url = '';



			if (isset($this->request->get['filter_name'])) {

				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_model'])) {

				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_price'])) {

				$url .= '&filter_price=' . $this->request->get['filter_price'];

			}



			if (isset($this->request->get['filter_quantity'])) {

				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

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



			$this->response->redirect($this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true));

		}



		$this->getList();

	}



	public function copy() {

		$this->load->language('catalog/service');



		$this->document->setTitle($this->language->get('heading_title'));



		$this->load->model('catalog/service');



		if (isset($this->request->post['selected']) && $this->validateCopy()) {

			foreach ($this->request->post['selected'] as $service_id) {

				$this->model_catalog_service->copyService($service_id);

			}



			$this->session->data['success'] = $this->language->get('text_success');



			$url = '';



			if (isset($this->request->get['filter_name'])) {

				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_model'])) {

				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

			}



			if (isset($this->request->get['filter_price'])) {

				$url .= '&filter_price=' . $this->request->get['filter_price'];

			}



			if (isset($this->request->get['filter_quantity'])) {

				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

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



			$this->response->redirect($this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true));

		}



		$this->getList();

	}



	protected function getList() {

		if (isset($this->request->get['filter_name'])) {

			$filter_name = $this->request->get['filter_name'];

		} else {

			$filter_name = null;

		}



		if (isset($this->request->get['filter_model'])) {

			$filter_model = $this->request->get['filter_model'];

		} else {

			$filter_model = null;

		}



		if (isset($this->request->get['filter_price'])) {

			$filter_price = $this->request->get['filter_price'];

		} else {

			$filter_price = null;

		}



		if (isset($this->request->get['filter_quantity'])) {

			$filter_quantity = $this->request->get['filter_quantity'];

		} else {

			$filter_quantity = null;

		}



		if (isset($this->request->get['filter_status'])) {

			$filter_status = $this->request->get['filter_status'];

		} else {

			$filter_status = null;

		}



		if (isset($this->request->get['filter_image'])) {

			$filter_image = $this->request->get['filter_image'];

		} else {

			$filter_image = null;

		}



		if (isset($this->request->get['sort'])) {

			$sort = $this->request->get['sort'];

		} else {

			$sort = 'pd.name';

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



		if (isset($this->request->get['filter_model'])) {

			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

		}



		if (isset($this->request->get['filter_price'])) {

			$url .= '&filter_price=' . $this->request->get['filter_price'];

		}



		if (isset($this->request->get['filter_quantity'])) {

			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

		}



		if (isset($this->request->get['filter_status'])) {

			$url .= '&filter_status=' . $this->request->get['filter_status'];

		}



		if (isset($this->request->get['filter_image'])) {

			$url .= '&filter_image=' . $this->request->get['filter_image'];

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

			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)

		);



		$data['breadcrumbs'][] = array(

			'text' => $this->language->get('heading_title'),

			'href' => $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true)

		);



		$data['add'] = $this->url->link('catalog/service/add', 'token=' . $this->session->data['token'] . $url, true);

		$data['copy'] = $this->url->link('catalog/service/copy', 'token=' . $this->session->data['token'] . $url, true);

		$data['delete'] = $this->url->link('catalog/service/delete', 'token=' . $this->session->data['token'] . $url, true);



		$data['services'] = array();



		$filter_data = array(

			'filter_name'	  => $filter_name,

			'filter_model'	  => $filter_model,

			'filter_price'	  => $filter_price,

			'filter_quantity' => $filter_quantity,

			'filter_status'   => $filter_status,

			'filter_image'    => $filter_image,

			'sort'            => $sort,

			'order'           => $order,

			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),

			'limit'           => $this->config->get('config_limit_admin')

		);



		$this->load->model('tool/image');



		$service_total = $this->model_catalog_service->getTotalServices($filter_data);



		$results = $this->model_catalog_service->getServices($filter_data);



		foreach ($results as $result) {

			if (is_file(DIR_IMAGE . $result['image'])) {

				$image = $this->model_tool_image->resize($result['image'], 40, 40);

			} else {

				$image = $this->model_tool_image->resize('no_image.png', 40, 40);

			}



			$special = false;



			$service_specials = $this->model_catalog_service->getServiceSpecials($result['service_id']);



			foreach ($service_specials  as $service_special) {

				if (($service_special['date_start'] == '0000-00-00' || strtotime($service_special['date_start']) < time()) && ($service_special['date_end'] == '0000-00-00' || strtotime($service_special['date_end']) > time())) {

					$special = $service_special['price'];



					break;

				}

			}



			$data['services'][] = array(

				'service_id' => $result['service_id'],

				'image'      => $image,

				'name'       => $result['name'],

				'model'      => $result['model'],

				'price'      => $result['price'],

				'special'    => $special,

				'quantity'   => $result['quantity'],

				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),

				'edit'       => $this->url->link('catalog/service/edit', 'token=' . $this->session->data['token'] . '&service_id=' . $result['service_id'] . $url, true)

			);

		}



		$data['heading_title'] = $this->language->get('heading_title');



		$data['text_list'] = $this->language->get('text_list');

		$data['text_enabled'] = $this->language->get('text_enabled');

		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['text_confirm'] = $this->language->get('text_confirm');



		$data['column_image'] = $this->language->get('column_image');

		$data['column_name'] = $this->language->get('column_name');

		$data['column_model'] = $this->language->get('column_model');

		$data['column_price'] = $this->language->get('column_price');

		$data['column_quantity'] = $this->language->get('column_quantity');

		$data['column_status'] = $this->language->get('column_status');

		$data['column_action'] = $this->language->get('column_action');



		$data['entry_name'] = $this->language->get('entry_name');

		$data['entry_model'] = $this->language->get('entry_model');

		$data['entry_price'] = $this->language->get('entry_price');

		$data['entry_quantity'] = $this->language->get('entry_quantity');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['entry_image'] = $this->language->get('entry_image');



		$data['button_copy'] = $this->language->get('button_copy');

		$data['button_add'] = $this->language->get('button_add');

		$data['button_edit'] = $this->language->get('button_edit');

		$data['button_delete'] = $this->language->get('button_delete');

		$data['button_filter'] = $this->language->get('button_filter');



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



		if (isset($this->request->get['filter_model'])) {

			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

		}



		if (isset($this->request->get['filter_price'])) {

			$url .= '&filter_price=' . $this->request->get['filter_price'];

		}



		if (isset($this->request->get['filter_quantity'])) {

			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

		}



		if (isset($this->request->get['filter_status'])) {

			$url .= '&filter_status=' . $this->request->get['filter_status'];

		}



		if (isset($this->request->get['filter_image'])) {

			$url .= '&filter_image=' . $this->request->get['filter_image'];

		}



		if ($order == 'ASC') {

			$url .= '&order=DESC';

		} else {

			$url .= '&order=ASC';

		}



		if (isset($this->request->get['page'])) {

			$url .= '&page=' . $this->request->get['page'];

		}



		$data['sort_name'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);

		$data['sort_model'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);

		$data['sort_price'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);

		$data['sort_quantity'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);

		$data['sort_status'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);

		$data['sort_order'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);



		$url = '';



		if (isset($this->request->get['filter_name'])) {

			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));

		}



		if (isset($this->request->get['filter_model'])) {

			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

		}



		if (isset($this->request->get['filter_price'])) {

			$url .= '&filter_price=' . $this->request->get['filter_price'];

		}



		if (isset($this->request->get['filter_quantity'])) {

			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

		}



		if (isset($this->request->get['filter_status'])) {

			$url .= '&filter_status=' . $this->request->get['filter_status'];

		}



		if (isset($this->request->get['filter_image'])) {

			$url .= '&filter_image=' . $this->request->get['filter_image'];

		}



		if (isset($this->request->get['sort'])) {

			$url .= '&sort=' . $this->request->get['sort'];

		}



		if (isset($this->request->get['order'])) {

			$url .= '&order=' . $this->request->get['order'];

		}



		$pagination = new Pagination();

		$pagination->total = $service_total;

		$pagination->page = $page;

		$pagination->limit = $this->config->get('config_limit_admin');

		$pagination->url = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);



		$data['pagination'] = $pagination->render();



		$data['results'] = sprintf($this->language->get('text_pagination'), ($service_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($service_total - $this->config->get('config_limit_admin'))) ? $service_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $service_total, ceil($service_total / $this->config->get('config_limit_admin')));



		$data['filter_name'] = $filter_name;

		$data['filter_model'] = $filter_model;

		$data['filter_price'] = $filter_price;

		$data['filter_quantity'] = $filter_quantity;

		$data['filter_status'] = $filter_status;

		$data['filter_image'] = $filter_image;



		$data['sort'] = $sort;

		$data['order'] = $order;



		$data['header'] = $this->load->controller('common/header');

		$data['column_left'] = $this->load->controller('common/column_left');

		$data['footer'] = $this->load->controller('common/footer');



		$this->response->setOutput($this->load->view('catalog/service_list', $data));

	}



	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');



		$data['text_form'] = !isset($this->request->get['service_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');

		

		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_none'] = $this->language->get('text_none');

		$data['text_yes'] = $this->language->get('text_yes');

		$data['text_no'] = $this->language->get('text_no');

		$data['text_plus'] = $this->language->get('text_plus');

		$data['text_minus'] = $this->language->get('text_minus');

		$data['text_default'] = $this->language->get('text_default');

		$data['text_optionsev'] = $this->language->get('text_optionsev');

		$data['text_optionsev_value'] = $this->language->get('text_optionsev_value');

		$data['text_select'] = $this->language->get('text_select');

		$data['text_percent'] = $this->language->get('text_percent');

		$data['text_amount'] = $this->language->get('text_amount');



		$data['entry_name'] = $this->language->get('entry_name');

		$data['entry_description'] = $this->language->get('entry_description');

		$data['entry_meta_title'] = $this->language->get('entry_meta_title');

		$data['entry_meta_description'] = $this->language->get('entry_meta_description');

		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');

		$data['entry_keyword'] = $this->language->get('entry_keyword');

		$data['entry_model'] = $this->language->get('entry_model');

		$data['entry_sku'] = $this->language->get('entry_sku');

		$data['entry_upc'] = $this->language->get('entry_upc');

		$data['entry_ean'] = $this->language->get('entry_ean');

		$data['entry_jan'] = $this->language->get('entry_jan');

		$data['entry_isbn'] = $this->language->get('entry_isbn');

		$data['entry_mpn'] = $this->language->get('entry_mpn');

		$data['entry_location'] = $this->language->get('entry_location');

		$data['entry_minimum'] = $this->language->get('entry_minimum');

		$data['entry_shipping'] = $this->language->get('entry_shipping');

		$data['entry_date_available'] = $this->language->get('entry_date_available');

		$data['entry_quantity'] = $this->language->get('entry_quantity');

		$data['entry_stock_status'] = $this->language->get('entry_stock_status');

		$data['entry_price'] = $this->language->get('entry_price');

		$data['entry_tax_class'] = $this->language->get('entry_tax_class');

		$data['entry_points'] = $this->language->get('entry_points');

		$data['entry_optionsev_points'] = $this->language->get('entry_optionsev_points');

		$data['entry_subtract'] = $this->language->get('entry_subtract');

		$data['entry_weight_class'] = $this->language->get('entry_weight_class');

		$data['entry_weight'] = $this->language->get('entry_weight');

		$data['entry_dimension'] = $this->language->get('entry_dimension');

		$data['entry_length_class'] = $this->language->get('entry_length_class');

		$data['entry_length'] = $this->language->get('entry_length');

		$data['entry_width'] = $this->language->get('entry_width');

		$data['entry_height'] = $this->language->get('entry_height');

		$data['entry_image'] = $this->language->get('entry_image');

		$data['entry_additional_image'] = $this->language->get('entry_additional_image');

		$data['entry_store'] = $this->language->get('entry_store');

		$data['entry_manufacturersev'] = $this->language->get('entry_manufacturersev');

		$data['entry_download'] = $this->language->get('entry_download');

		$data['entry_categorysev'] = $this->language->get('entry_categorysev');

		$data['entry_filter'] = $this->language->get('entry_filter');

		$data['entry_related'] = $this->language->get('entry_related');

		$data['entry_attributesev'] = $this->language->get('entry_attributesev');

		$data['entry_text'] = $this->language->get('entry_text');

		$data['entry_optionsev'] = $this->language->get('entry_optionsev');

		$data['entry_optionsev_value'] = $this->language->get('entry_optionsev_value');

		$data['entry_required'] = $this->language->get('entry_required');

		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['entry_date_start'] = $this->language->get('entry_date_start');

		$data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['entry_priority'] = $this->language->get('entry_priority');

		$data['entry_tag'] = $this->language->get('entry_tag');

		$data['entry_customer_group'] = $this->language->get('entry_customer_group');

		$data['entry_reward'] = $this->language->get('entry_reward');

		$data['entry_layout'] = $this->language->get('entry_layout');

		$data['entry_recurring'] = $this->language->get('entry_recurring');



		$data['help_keyword'] = $this->language->get('help_keyword');

		$data['help_sku'] = $this->language->get('help_sku');

		$data['help_upc'] = $this->language->get('help_upc');

		$data['help_ean'] = $this->language->get('help_ean');

		$data['help_jan'] = $this->language->get('help_jan');

		$data['help_isbn'] = $this->language->get('help_isbn');

		$data['help_mpn'] = $this->language->get('help_mpn');

		$data['help_minimum'] = $this->language->get('help_minimum');

		$data['help_manufacturersev'] = $this->language->get('help_manufacturersev');

		$data['help_stock_status'] = $this->language->get('help_stock_status');

		$data['help_points'] = $this->language->get('help_points');

		$data['help_categorysev'] = $this->language->get('help_categorysev');

		$data['help_filter'] = $this->language->get('help_filter');

		$data['help_download'] = $this->language->get('help_download');

		$data['help_related'] = $this->language->get('help_related');

		$data['help_tag'] = $this->language->get('help_tag');



		$data['button_save'] = $this->language->get('button_save');

		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['button_attributesev_add'] = $this->language->get('button_attributesev_add');

		$data['button_optionsev_add'] = $this->language->get('button_optionsev_add');

		$data['button_optionsev_value_add'] = $this->language->get('button_optionsev_value_add');

		$data['button_discount_add'] = $this->language->get('button_discount_add');

		$data['button_special_add'] = $this->language->get('button_special_add');

		$data['button_image_add'] = $this->language->get('button_image_add');

		$data['button_remove'] = $this->language->get('button_remove');

		$data['button_recurring_add'] = $this->language->get('button_recurring_add');



		$data['tab_general'] = $this->language->get('tab_general');

		$data['tab_data'] = $this->language->get('tab_data');

		$data['tab_attributesev'] = $this->language->get('tab_attributesev');

		$data['tab_optionsev'] = $this->language->get('tab_optionsev');

		$data['tab_recurring'] = $this->language->get('tab_recurring');

		$data['tab_discount'] = $this->language->get('tab_discount');

		$data['tab_special'] = $this->language->get('tab_special');

		$data['tab_image'] = $this->language->get('tab_image');

		$data['tab_links'] = $this->language->get('tab_links');

		$data['tab_reward'] = $this->language->get('tab_reward');

		$data['tab_design'] = $this->language->get('tab_design');

		$data['tab_openbay'] = $this->language->get('tab_openbay');



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



		if (isset($this->error['keyword'])) {

			$data['error_keyword'] = $this->error['keyword'];

		} else {

			$data['error_keyword'] = '';

		}



		$url = '';



		if (isset($this->request->get['filter_name'])) {

			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));

		}



		if (isset($this->request->get['filter_model'])) {

			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));

		}



		if (isset($this->request->get['filter_price'])) {

			$url .= '&filter_price=' . $this->request->get['filter_price'];

		}



		if (isset($this->request->get['filter_quantity'])) {

			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];

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

			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)

		);



		$data['breadcrumbs'][] = array(

			'text' => $this->language->get('heading_title'),

			'href' => $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true)

		);



		if (!isset($this->request->get['service_id'])) {

			$data['action'] = $this->url->link('catalog/service/add', 'token=' . $this->session->data['token'] . $url, true);

		} else {

			$data['action'] = $this->url->link('catalog/service/edit', 'token=' . $this->session->data['token'] . '&service_id=' . $this->request->get['service_id'] . $url, true);

		}



		$data['cancel'] = $this->url->link('catalog/service', 'token=' . $this->session->data['token'] . $url, true);



		if (isset($this->request->get['service_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {

			$service_info = $this->model_catalog_service->getService($this->request->get['service_id']);

		}



		$data['token'] = $this->session->data['token'];



		$this->load->model('localisation/language');



		$data['languages'] = $this->model_localisation_language->getLanguages();



		if (isset($this->request->post['service_description'])) {

			$data['service_description'] = $this->request->post['service_description'];

		} elseif (isset($this->request->get['service_id'])) {

			$data['service_description'] = $this->model_catalog_service->getServiceDescriptions($this->request->get['service_id']);

		} else {

			$data['service_description'] = array();

		}



		if (isset($this->request->post['model'])) {

			$data['model'] = $this->request->post['model'];

		} elseif (!empty($service_info)) {

			$data['model'] = $service_info['model'];

		} else {

			$data['model'] = '';

		}



		if (isset($this->request->post['sku'])) {

			$data['sku'] = $this->request->post['sku'];

		} elseif (!empty($service_info)) {

			$data['sku'] = $service_info['sku'];

		} else {

			$data['sku'] = '';

		}



		if (isset($this->request->post['upc'])) {

			$data['upc'] = $this->request->post['upc'];

		} elseif (!empty($service_info)) {

			$data['upc'] = $service_info['upc'];

		} else {

			$data['upc'] = '';

		}



		if (isset($this->request->post['ean'])) {

			$data['ean'] = $this->request->post['ean'];

		} elseif (!empty($service_info)) {

			$data['ean'] = $service_info['ean'];

		} else {

			$data['ean'] = '';

		}



		if (isset($this->request->post['jan'])) {

			$data['jan'] = $this->request->post['jan'];

		} elseif (!empty($service_info)) {

			$data['jan'] = $service_info['jan'];

		} else {

			$data['jan'] = '';

		}



		if (isset($this->request->post['isbn'])) {

			$data['isbn'] = $this->request->post['isbn'];

		} elseif (!empty($service_info)) {

			$data['isbn'] = $service_info['isbn'];

		} else {

			$data['isbn'] = '';

		}



		if (isset($this->request->post['mpn'])) {

			$data['mpn'] = $this->request->post['mpn'];

		} elseif (!empty($service_info)) {

			$data['mpn'] = $service_info['mpn'];

		} else {

			$data['mpn'] = '';

		}



		if (isset($this->request->post['location'])) {

			$data['location'] = $this->request->post['location'];

		} elseif (!empty($service_info)) {

			$data['location'] = $service_info['location'];

		} else {

			$data['location'] = '';

		}



		$this->load->model('setting/store');



		$data['stores'] = $this->model_setting_store->getStores();



		if (isset($this->request->post['service_store'])) {

			$data['service_store'] = $this->request->post['service_store'];

		} elseif (isset($this->request->get['service_id'])) {

			$data['service_store'] = $this->model_catalog_service->getServiceStores($this->request->get['service_id']);

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



		if (isset($this->request->post['shipping'])) {

			$data['shipping'] = $this->request->post['shipping'];

		} elseif (!empty($service_info)) {

			$data['shipping'] = $service_info['shipping'];

		} else {

			$data['shipping'] = 1;

		}



		if (isset($this->request->post['price'])) {

			$data['price'] = $this->request->post['price'];

		} elseif (!empty($service_info)) {

			$data['price'] = $service_info['price'];

		} else {

			$data['price'] = '';

		}



		$this->load->model('catalog/recurring');



		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();



		if (isset($this->request->post['service_recurrings'])) {

			$data['service_recurrings'] = $this->request->post['service_recurrings'];

		} elseif (!empty($service_info)) {

			$data['service_recurrings'] = $this->model_catalog_service->getRecurrings($service_info['service_id']);

		} else {

			$data['service_recurrings'] = array();

		}



		$this->load->model('localisation/tax_class');



		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();



		if (isset($this->request->post['tax_class_id'])) {

			$data['tax_class_id'] = $this->request->post['tax_class_id'];

		} elseif (!empty($service_info)) {

			$data['tax_class_id'] = $service_info['tax_class_id'];

		} else {

			$data['tax_class_id'] = 0;

		}



		if (isset($this->request->post['date_available'])) {

			$data['date_available'] = $this->request->post['date_available'];

		} elseif (!empty($service_info)) {

			$data['date_available'] = ($service_info['date_available'] != '0000-00-00') ? $service_info['date_available'] : '';

		} else {

			$data['date_available'] = date('Y-m-d');

		}



		if (isset($this->request->post['quantity'])) {

			$data['quantity'] = $this->request->post['quantity'];

		} elseif (!empty($service_info)) {

			$data['quantity'] = $service_info['quantity'];

		} else {

			$data['quantity'] = 1;

		}



		if (isset($this->request->post['minimum'])) {

			$data['minimum'] = $this->request->post['minimum'];

		} elseif (!empty($service_info)) {

			$data['minimum'] = $service_info['minimum'];

		} else {

			$data['minimum'] = 1;

		}



		if (isset($this->request->post['subtract'])) {

			$data['subtract'] = $this->request->post['subtract'];

		} elseif (!empty($service_info)) {

			$data['subtract'] = $service_info['subtract'];

		} else {

			$data['subtract'] = 1;

		}



		if (isset($this->request->post['sort_order'])) {

			$data['sort_order'] = $this->request->post['sort_order'];

		} elseif (!empty($service_info)) {

			$data['sort_order'] = $service_info['sort_order'];

		} else {

			$data['sort_order'] = 1;

		}



		$this->load->model('localisation/stock_status');



		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();



		if (isset($this->request->post['stock_status_id'])) {

			$data['stock_status_id'] = $this->request->post['stock_status_id'];

		} elseif (!empty($service_info)) {

			$data['stock_status_id'] = $service_info['stock_status_id'];

		} else {

			$data['stock_status_id'] = 0;

		}



		if (isset($this->request->post['status'])) {

			$data['status'] = $this->request->post['status'];

		} elseif (!empty($service_info)) {

			$data['status'] = $service_info['status'];

		} else {

			$data['status'] = true;

		}



		if (isset($this->request->post['weight'])) {

			$data['weight'] = $this->request->post['weight'];

		} elseif (!empty($service_info)) {

			$data['weight'] = $service_info['weight'];

		} else {

			$data['weight'] = '';

		}



		$this->load->model('localisation/weight_class');



		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();



		if (isset($this->request->post['weight_class_id'])) {

			$data['weight_class_id'] = $this->request->post['weight_class_id'];

		} elseif (!empty($service_info)) {

			$data['weight_class_id'] = $service_info['weight_class_id'];

		} else {

			$data['weight_class_id'] = $this->config->get('config_weight_class_id');

		}



		if (isset($this->request->post['length'])) {

			$data['length'] = $this->request->post['length'];

		} elseif (!empty($service_info)) {

			$data['length'] = $service_info['length'];

		} else {

			$data['length'] = '';

		}



		if (isset($this->request->post['width'])) {

			$data['width'] = $this->request->post['width'];

		} elseif (!empty($service_info)) {

			$data['width'] = $service_info['width'];

		} else {

			$data['width'] = '';

		}



		if (isset($this->request->post['height'])) {

			$data['height'] = $this->request->post['height'];

		} elseif (!empty($service_info)) {

			$data['height'] = $service_info['height'];

		} else {

			$data['height'] = '';

		}



		$this->load->model('localisation/length_class');



		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();



		if (isset($this->request->post['length_class_id'])) {

			$data['length_class_id'] = $this->request->post['length_class_id'];

		} elseif (!empty($service_info)) {

			$data['length_class_id'] = $service_info['length_class_id'];

		} else {

			$data['length_class_id'] = $this->config->get('config_length_class_id');

		}



		$this->load->model('catalog/manufacturersev');



		if (isset($this->request->post['manufacturersev_id'])) {

			$data['manufacturersev_id'] = $this->request->post['manufacturersev_id'];

		} elseif (!empty($service_info)) {

			$data['manufacturersev_id'] = $service_info['manufacturersev_id'];

		} else {

			$data['manufacturersev_id'] = 0;

		}



		if (isset($this->request->post['manufacturersev'])) {

			$data['manufacturersev'] = $this->request->post['manufacturersev'];

		} elseif (!empty($service_info)) {

			$manufacturersev_info = $this->model_catalog_manufacturersev->getManufacturersev($service_info['manufacturersev_id']);



			if ($manufacturersev_info) {

				$data['manufacturersev'] = $manufacturersev_info['name'];

			} else {

				$data['manufacturersev'] = '';

			}

		} else {

			$data['manufacturersev'] = '';

		}



		// Categories

		$this->load->model('catalog/categorysev');



		if (isset($this->request->post['service_categorysev'])) {

			$categories = $this->request->post['service_categorysev'];

		} elseif (isset($this->request->get['service_id'])) {

			$categories = $this->model_catalog_service->getServiceCategories($this->request->get['service_id']);

		} else {

			$categories = array();

		}



		$data['service_categories'] = array();



		foreach ($categories as $categorysev_id) {

			$categorysev_info = $this->model_catalog_categorysev->getCategorysev($categorysev_id);



			if ($categorysev_info) {

				$data['service_categories'][] = array(

					'categorysev_id' => $categorysev_info['categorysev_id'],

					'name'        => ($categorysev_info['pathsev']) ? $categorysev_info['pathsev'] . ' &gt; ' . $categorysev_info['name'] : $categorysev_info['name']

				);

			}

		}



		// Filters

		$this->load->model('catalog/filter');



		if (isset($this->request->post['service_filter'])) {

			$filters = $this->request->post['service_filter'];

		} elseif (isset($this->request->get['service_id'])) {

			$filters = $this->model_catalog_service->getServiceFilters($this->request->get['service_id']);

		} else {

			$filters = array();

		}



		$data['service_filters'] = array();



		foreach ($filters as $filter_id) {

			$filter_info = $this->model_catalog_filter->getFilter($filter_id);



			if ($filter_info) {

				$data['service_filters'][] = array(

					'filter_id' => $filter_info['filter_id'],

					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']

				);

			}

		}



		// Attributesevs

		$this->load->model('catalog/attributesev');



		if (isset($this->request->post['service_attributesev'])) {

			$service_attributesevs = $this->request->post['service_attributesev'];

		} elseif (isset($this->request->get['service_id'])) {

			$service_attributesevs = $this->model_catalog_service->getServiceAttributesevs($this->request->get['service_id']);

		} else {

			$service_attributesevs = array();

		}



		$data['service_attributesevs'] = array();



		foreach ($service_attributesevs as $service_attributesev) {

			$attributesev_info = $this->model_catalog_attributesev->getAttributesev($service_attributesev['attributesev_id']);



			if ($attributesev_info) {

				$data['service_attributesevs'][] = array(

					'attributesev_id'                  => $service_attributesev['attributesev_id'],

					'name'                          => $attributesev_info['name'],

					'service_attributesev_description' => $service_attributesev['service_attributesev_description']

				);

			}

		}



		// Options

		$this->load->model('catalog/optionsev');



		if (isset($this->request->post['service_optionsev'])) {

			$service_optionsevs = $this->request->post['service_optionsev'];

		} elseif (isset($this->request->get['service_id'])) {

			$service_optionsevs = $this->model_catalog_service->getServiceOptions($this->request->get['service_id']);

		} else {

			$service_optionsevs = array();

		}



		$data['service_optionsevs'] = array();



		foreach ($service_optionsevs as $service_optionsev) {

			$service_optionsev_value_data = array();



			if (isset($service_optionsev['service_optionsev_value'])) {

				foreach ($service_optionsev['service_optionsev_value'] as $service_optionsev_value) {

					$service_optionsev_value_data[] = array(

						'service_optionsev_value_id' => $service_optionsev_value['service_optionsev_value_id'],

						'optionsev_value_id'         => $service_optionsev_value['optionsev_value_id'],

						'quantity'                => $service_optionsev_value['quantity'],

						'subtract'                => $service_optionsev_value['subtract'],

						'price'                   => $service_optionsev_value['price'],

						'price_prefix'            => $service_optionsev_value['price_prefix'],

						'points'                  => $service_optionsev_value['points'],

						'points_prefix'           => $service_optionsev_value['points_prefix'],

						'weight'                  => $service_optionsev_value['weight'],

						'weight_prefix'           => $service_optionsev_value['weight_prefix']

					);

				}

			}



			$data['service_optionsevs'][] = array(

				'service_optionsev_id'    => $service_optionsev['service_optionsev_id'],

				'service_optionsev_value' => $service_optionsev_value_data,

				'optionsev_id'            => $service_optionsev['optionsev_id'],

				'name'                 => $service_optionsev['name'],

				'type'                 => $service_optionsev['type'],

				'value'                => isset($service_optionsev['value']) ? $service_optionsev['value'] : '',

				'required'             => $service_optionsev['required']

			);

		}



		$data['optionsev_values'] = array();



		foreach ($data['service_optionsevs'] as $service_optionsev) {

			if ($service_optionsev['type'] == 'select' || $service_optionsev['type'] == 'radio' || $service_optionsev['type'] == 'checkbox' || $service_optionsev['type'] == 'image') {

				if (!isset($data['optionsev_values'][$service_optionsev['optionsev_id']])) {

					$data['optionsev_values'][$service_optionsev['optionsev_id']] = $this->model_catalog_optionsev->getOptionValues($service_optionsev['optionsev_id']);

				}

			}

		}



		$this->load->model('customer/customer_group');



		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();



		if (isset($this->request->post['service_discount'])) {

			$service_discounts = $this->request->post['service_discount'];

		} elseif (isset($this->request->get['service_id'])) {

			$service_discounts = $this->model_catalog_service->getServiceDiscounts($this->request->get['service_id']);

		} else {

			$service_discounts = array();

		}



		$data['service_discounts'] = array();



		foreach ($service_discounts as $service_discount) {

			$data['service_discounts'][] = array(

				'customer_group_id' => $service_discount['customer_group_id'],

				'quantity'          => $service_discount['quantity'],

				'priority'          => $service_discount['priority'],

				'price'             => $service_discount['price'],

				'date_start'        => ($service_discount['date_start'] != '0000-00-00') ? $service_discount['date_start'] : '',

				'date_end'          => ($service_discount['date_end'] != '0000-00-00') ? $service_discount['date_end'] : ''

			);

		}



		if (isset($this->request->post['service_special'])) {

			$service_specials = $this->request->post['service_special'];

		} elseif (isset($this->request->get['service_id'])) {

			$service_specials = $this->model_catalog_service->getServiceSpecials($this->request->get['service_id']);

		} else {

			$service_specials = array();

		}



		$data['service_specials'] = array();



		foreach ($service_specials as $service_special) {

			$data['service_specials'][] = array(

				'customer_group_id' => $service_special['customer_group_id'],

				'priority'          => $service_special['priority'],

				'price'             => $service_special['price'],

				'date_start'        => ($service_special['date_start'] != '0000-00-00') ? $service_special['date_start'] : '',

				'date_end'          => ($service_special['date_end'] != '0000-00-00') ? $service_special['date_end'] :  ''

			);

		}

		

		// Image

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



		// Images

		if (isset($this->request->post['service_image'])) {

			$service_images = $this->request->post['service_image'];

		} elseif (isset($this->request->get['service_id'])) {

			$service_images = $this->model_catalog_service->getServiceImages($this->request->get['service_id']);

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



		// Downloads

		$this->load->model('catalog/download');



		if (isset($this->request->post['service_download'])) {

			$service_downloads = $this->request->post['service_download'];

		} elseif (isset($this->request->get['service_id'])) {

			$service_downloads = $this->model_catalog_service->getServiceDownloads($this->request->get['service_id']);

		} else {

			$service_downloads = array();

		}



		$data['service_downloads'] = array();



		foreach ($service_downloads as $download_id) {

			$download_info = $this->model_catalog_download->getDownload($download_id);



			if ($download_info) {

				$data['service_downloads'][] = array(

					'download_id' => $download_info['download_id'],

					'name'        => $download_info['name']

				);

			}

		}



		if (isset($this->request->post['service_related'])) {

			$services = $this->request->post['service_related'];

		} elseif (isset($this->request->get['service_id'])) {

			$services = $this->model_catalog_service->getServiceRelated($this->request->get['service_id']);

		} else {

			$services = array();

		}



		$data['service_relateds'] = array();



		foreach ($services as $service_id) {

			$related_info = $this->model_catalog_service->getService($service_id);



			if ($related_info) {

				$data['service_relateds'][] = array(

					'service_id' => $related_info['service_id'],

					'name'       => $related_info['name']

				);

			}

		}



		if (isset($this->request->post['points'])) {

			$data['points'] = $this->request->post['points'];

		} elseif (!empty($service_info)) {

			$data['points'] = $service_info['points'];

		} else {

			$data['points'] = '';

		}



		if (isset($this->request->post['service_reward'])) {

			$data['service_reward'] = $this->request->post['service_reward'];

		} elseif (isset($this->request->get['service_id'])) {

			$data['service_reward'] = $this->model_catalog_service->getServiceRewards($this->request->get['service_id']);

		} else {

			$data['service_reward'] = array();

		}



		if (isset($this->request->post['service_layout'])) {

			$data['service_layout'] = $this->request->post['service_layout'];

		} elseif (isset($this->request->get['service_id'])) {

			$data['service_layout'] = $this->model_catalog_service->getServiceLayouts($this->request->get['service_id']);

		} else {

			$data['service_layout'] = array();

		}



		$this->load->model('design/layout');



		$data['layouts'] = $this->model_design_layout->getLayouts();



		$data['header'] = $this->load->controller('common/header');

		$data['column_left'] = $this->load->controller('common/column_left');

		$data['footer'] = $this->load->controller('common/footer');



		$this->response->setOutput($this->load->view('catalog/service_form', $data));

	}



	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/service')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}



		foreach ($this->request->post['service_description'] as $language_id => $value) {

			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {

				$this->error['name'][$language_id] = $this->language->get('error_name');

			}



			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {

				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');

			}

		}



		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {

			$this->error['model'] = $this->language->get('error_model');

		}



		if (utf8_strlen($this->request->post['keyword']) > 0) {

			$this->load->model('catalog/url_alias');



			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);



			if ($url_alias_info && isset($this->request->get['service_id']) && $url_alias_info['query'] != 'service_id=' . $this->request->get['service_id']) {

				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));

			}



			if ($url_alias_info && !isset($this->request->get['service_id'])) {

				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));

			}

		}



		if ($this->error && !isset($this->error['warning'])) {

			$this->error['warning'] = $this->language->get('error_warning');

		}



		return !$this->error;

	}



	protected function validateDelete() {

		if (!$this->user->hasPermission('modify', 'catalog/service')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}



		return !$this->error;

	}



	protected function validateCopy() {

		if (!$this->user->hasPermission('modify', 'catalog/service')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}



		return !$this->error;

	}



	public function autocomplete() {

		$json = array();



		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {

			$this->load->model('catalog/service');

			$this->load->model('catalog/optionsev');



			if (isset($this->request->get['filter_name'])) {

				$filter_name = $this->request->get['filter_name'];

			} else {

				$filter_name = '';

			}



			if (isset($this->request->get['filter_model'])) {

				$filter_model = $this->request->get['filter_model'];

			} else {

				$filter_model = '';

			}



			if (isset($this->request->get['limit'])) {

				$limit = $this->request->get['limit'];

			} else {

				$limit = 5;

			}



			$filter_data = array(

				'filter_name'  => $filter_name,

				'filter_model' => $filter_model,

				'start'        => 0,

				'limit'        => $limit

			);



			$results = $this->model_catalog_service->getServices($filter_data);



			foreach ($results as $result) {

				$optionsev_data = array();



				$service_optionsevs = $this->model_catalog_service->getServiceOptions($result['service_id']);



				foreach ($service_optionsevs as $service_optionsev) {

					$optionsev_info = $this->model_catalog_optionsev->getOption($service_optionsev['optionsev_id']);



					if ($optionsev_info) {

						$service_optionsev_value_data = array();



						foreach ($service_optionsev['service_optionsev_value'] as $service_optionsev_value) {

							$optionsev_value_info = $this->model_catalog_optionsev->getOptionValue($service_optionsev_value['optionsev_value_id']);



							if ($optionsev_value_info) {

								$service_optionsev_value_data[] = array(

									'service_optionsev_value_id' => $service_optionsev_value['service_optionsev_value_id'],

									'optionsev_value_id'         => $service_optionsev_value['optionsev_value_id'],

									'name'                    => $optionsev_value_info['name'],

									'price'                   => (float)$service_optionsev_value['price'] ? $this->currency->format($service_optionsev_value['price'], $this->config->get('config_currency')) : false,

									'price_prefix'            => $service_optionsev_value['price_prefix']

								);

							}

						}



						$optionsev_data[] = array(

							'service_optionsev_id'    => $service_optionsev['service_optionsev_id'],

							'service_optionsev_value' => $service_optionsev_value_data,

							'optionsev_id'            => $service_optionsev['optionsev_id'],

							'name'                 => $optionsev_info['name'],

							'type'                 => $optionsev_info['type'],

							'value'                => $service_optionsev['value'],

							'required'             => $service_optionsev['required']

						);

					}

				}



				$json[] = array(

					'service_id' => $result['service_id'],

					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),

					'model'      => $result['model'],

					'optionsev'     => $optionsev_data,

					'price'      => $result['price']

				);

			}

		}



		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));

	}

}

