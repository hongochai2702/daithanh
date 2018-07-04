<?php

class ControllerProductService extends Controller {

	private $error = array();



	public function index() {

		$this->load->language('product/service');



		$data['breadcrumbs'] = array();



		$data['breadcrumbs'][] = array(

			'text' => $this->language->get('text_home'),

			'href' => $this->url->link('common/home')

		);



		$this->load->model('catalog/categorysev');



		if (isset($this->request->get['pathsev'])) {

			$pathsev = '';



			$parts = explode('_', (string)$this->request->get['pathsev']);



			$categorysev_id = (int)array_pop($parts);



			foreach ($parts as $pathsev_id) {

				if (!$pathsev) {

					$pathsev = $pathsev_id;

				} else {

					$pathsev .= '_' . $pathsev_id;

				}



				$categorysev_info = $this->model_catalog_categorysev->getCategorysev($pathsev_id);



				if ($categorysev_info) {

					$data['breadcrumbs'][] = array(

						'text' => $categorysev_info['name'],

						'href' => $this->url->link('product/categorysev', 'pathsev=' . $pathsev)

					);

				}

			}



			// Set the last categorysev breadcrumb

			$categorysev_info = $this->model_catalog_categorysev->getCategorysev($categorysev_id);



			if ($categorysev_info) {

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



				if (isset($this->request->get['limit'])) {

					$url .= '&limit=' . $this->request->get['limit'];

				}



				$data['breadcrumbs'][] = array(

					'text' => $categorysev_info['name'],

					'href' => $this->url->link('product/categorysev', 'pathsev=' . $this->request->get['pathsev'] . $url)

				);

			}

		}



		$this->load->model('catalog/manufacturersev');



		if (isset($this->request->get['manufacturersev_id'])) {

			$data['breadcrumbs'][] = array(

				'text' => $this->language->get('text_brand'),

				'href' => $this->url->link('product/manufacturersev')

			);



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



			if (isset($this->request->get['limit'])) {

				$url .= '&limit=' . $this->request->get['limit'];

			}



			$manufacturersev_info = $this->model_catalog_manufacturersev->getManufacturersev($this->request->get['manufacturersev_id']);



			if ($manufacturersev_info) {

				$data['breadcrumbs'][] = array(

					'text' => $manufacturersev_info['name'],

					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)

				);

			}

		}



		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {

			$url = '';



			if (isset($this->request->get['search'])) {

				$url .= '&search=' . $this->request->get['search'];

			}



			if (isset($this->request->get['tag'])) {

				$url .= '&tag=' . $this->request->get['tag'];

			}



			if (isset($this->request->get['description'])) {

				$url .= '&description=' . $this->request->get['description'];

			}



			if (isset($this->request->get['categorysev_id'])) {

				$url .= '&categorysev_id=' . $this->request->get['categorysev_id'];

			}



			if (isset($this->request->get['sub_categorysev'])) {

				$url .= '&sub_categorysev=' . $this->request->get['sub_categorysev'];

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

				'text' => $this->language->get('text_search'),

				'href' => $this->url->link('product/search', $url)

			);

		}



		if (isset($this->request->get['service_id'])) {

			$service_id = (int)$this->request->get['service_id'];

		} else {

			$service_id = 0;

		}



		$this->load->model('catalog/service');



		$service_info = $this->model_catalog_service->getService($service_id);



		if ($service_info) {

			$url = '';



			if (isset($this->request->get['pathsev'])) {

				$url .= '&pathsev=' . $this->request->get['pathsev'];

			}



			if (isset($this->request->get['filter'])) {

				$url .= '&filter=' . $this->request->get['filter'];

			}



			if (isset($this->request->get['manufacturer_id'])) {

				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];

			}



			if (isset($this->request->get['search'])) {

				$url .= '&search=' . $this->request->get['search'];

			}



			if (isset($this->request->get['tag'])) {

				$url .= '&tag=' . $this->request->get['tag'];

			}



			if (isset($this->request->get['description'])) {

				$url .= '&description=' . $this->request->get['description'];

			}



			if (isset($this->request->get['categorysev_id'])) {

				$url .= '&categorysev_id=' . $this->request->get['categorysev_id'];

			}



			if (isset($this->request->get['sub_categorysev'])) {

				$url .= '&sub_categorysev=' . $this->request->get['sub_categorysev'];

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

				'text' => $service_info['name'],

				'href' => $this->url->link('product/service', $url . '&service_id=' . $this->request->get['service_id'])

			);



			$this->document->setTitle($service_info['meta_title']);

			$this->document->setDescription($service_info['meta_description']);

			$this->document->setKeywords($service_info['meta_keyword']);

			$this->document->addLink($this->url->link('product/service', 'service_id=' . $this->request->get['service_id']), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');

			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

			// $this->document->addStyle('catalog/view/theme/default/stylesheet/flexslider/flexslider.css');

			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');

			// $this->document->addScript('catalog/view/theme/default/javascript/jquery/fancybox3/jquery.fancybox.min.js');

			// $this->document->addScript('catalog/view/theme/default/stylesheet/flexslider/jquery.flexslider-min.js');

			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');

			$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

			// $this->document->addStyle('catalog/view/theme/default/javascript/jquery/fancybox3/jquery.fancybox.min.css');

			$this->document->addScript('catalog/view/javascript/fancybox/fancybox.minef15.js');
			$this->document->addScript('catalog/view/javascript/fancybox/unslider-minef15.js');
			$this->document->addStyle('catalog/view/javascript/fancybox/fancybox.minef15.css?ver=4.8');
			$this->document->addStyle('catalog/view/javascript/fancybox/unslideref15.css');





			$data['heading_title'] = $service_info['name'];



			$data['text_select'] = $this->language->get('text_select');

			$data['text_manufacturersev'] = $this->language->get('text_manufacturersev');

			$data['text_location'] = $this->language->get('text_location');

			$data['text_model'] = $this->language->get('text_model');

			$data['text_reward'] = $this->language->get('text_reward');

			$data['text_points'] = $this->language->get('text_points');

			$data['text_stock'] = $this->language->get('text_stock');

			$data['text_discount'] = $this->language->get('text_discount');

			$data['text_tax'] = $this->language->get('text_tax');

			$data['text_optionsev'] = $this->language->get('text_optionsev');

			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $service_info['minimum']);

			$data['text_write'] = $this->language->get('text_write');

			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));

			$data['text_note'] = $this->language->get('text_note');

			$data['text_tags'] = $this->language->get('text_tags');

			$data['text_related'] = $this->language->get('text_related');

			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

			$data['text_loading'] = $this->language->get('text_loading');



			$data['entry_qty'] = $this->language->get('entry_qty');

			$data['entry_name'] = $this->language->get('entry_name');

			$data['entry_reviewsev'] = $this->language->get('entry_reviewsev');

			$data['entry_rating'] = $this->language->get('entry_rating');

			$data['entry_good'] = $this->language->get('entry_good');

			$data['entry_bad'] = $this->language->get('entry_bad');



			$data['button_cart'] = $this->language->get('button_cart');

			$data['button_wishlist'] = $this->language->get('button_wishlist');

			$data['button_compare'] = $this->language->get('button_compare');

			$data['button_upload'] = $this->language->get('button_upload');

			$data['button_continue'] = $this->language->get('button_continue');



			$this->load->model('catalog/reviewsev');



			$data['tab_description'] = $this->language->get('tab_description');

			$data['tab_attributesev'] = $this->language->get('tab_attributesev');

			$data['tab_reviewsev'] = sprintf($this->language->get('tab_reviewsev'), $service_info['reviewsevs']);



			$data['service_id'] = (int)$this->request->get['service_id'];

			$data['manufacturersev'] = $service_info['manufacturersev'];

			$data['manufacturersevs'] = $this->url->link('product/manufacturersev/info', 'manufacturersev_id=' . $service_info['manufacturersev_id']);

			$data['model'] = $service_info['model'];

			$data['location'] = $service_info['location'];

			$data['reward'] = $service_info['reward'];

			$data['points'] = $service_info['points'];

			$data['description'] = html_entity_decode($service_info['description'], ENT_QUOTES, 'UTF-8');



			if ($service_info['quantity'] <= 0) {

				$data['stock'] = $service_info['stock_status'];

			} elseif ($this->config->get('config_stock_display')) {

				$data['stock'] = $service_info['quantity'];

			} else {

				$data['stock'] = $this->language->get('text_instock');

			}



			$this->load->model('tool/image');



			if ($service_info['image']) {

				$data['popup'] = $this->model_tool_image->resize($service_info['image'], 540, 357);

			} else {

				$data['popup'] = '';

			}



			if ($service_info['image']) {

				$data['thumb'] = $this->model_tool_image->resize($service_info['image'], 540, 357);

			} else {

				$data['thumb'] = '';

			}



			$data['images'] = array();



			$results = $this->model_catalog_service->getServiceImages($this->request->get['service_id']);



			foreach ($results as $result) {

				$data['images'][] = array(

					'popup' => $this->model_tool_image->resize($result['image'], 540, 357),

					'thumb' => $this->model_tool_image->resize($result['image'], 104,69)

				);

			}



			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {

				$data['price'] = $this->currency->format($this->tax->calculate($service_info['price'], $service_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

			} else {

				$data['price'] = false;

			}



			if ((float)$service_info['specialsev']) {

				$data['specialsev'] = $this->currency->format($this->tax->calculate($service_info['specialsev'], $service_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

			} else {

				$data['specialsev'] = false;

			}



			if ($this->config->get('config_tax')) {

				$data['tax'] = $this->currency->format((float)$service_info['specialsev'] ? $service_info['specialsev'] : $service_info['price'], $this->session->data['currency']);

			} else {

				$data['tax'] = false;

			}



			$discounts = $this->model_catalog_service->getServiceDiscounts($this->request->get['service_id']);



			$data['discounts'] = array();



			foreach ($discounts as $discount) {

				$data['discounts'][] = array(

					'quantity' => $discount['quantity'],

					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $service_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])

				);

			}



			$data['optionsevs'] = array();



			foreach ($this->model_catalog_service->getServiceOptions($this->request->get['service_id']) as $optionsev) {

				$service_optionsev_value_data = array();



				foreach ($optionsev['service_optionsev_value'] as $optionsev_value) {

					if (!$optionsev_value['subtract'] || ($optionsev_value['quantity'] > 0)) {

						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$optionsev_value['price']) {

							$price = $this->currency->format($this->tax->calculate($optionsev_value['price'], $service_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);

						} else {

							$price = false;

						}



						$service_optionsev_value_data[] = array(

							'service_optionsev_value_id' => $optionsev_value['service_optionsev_value_id'],

							'optionsev_value_id'         => $optionsev_value['optionsev_value_id'],

							'name'                    => $optionsev_value['name'],

							'image'                   => $this->model_tool_image->resize($optionsev_value['image'], 50, 50),

							'price'                   => $price,

							'price_prefix'            => $optionsev_value['price_prefix']

						);

					}

				}



				$data['optionsevs'][] = array(

					'service_optionsev_id'    => $optionsev['service_optionsev_id'],

					'service_optionsev_value' => $service_optionsev_value_data,

					'optionsev_id'            => $optionsev['optionsev_id'],

					'name'                 => $optionsev['name'],

					'type'                 => $optionsev['type'],

					'value'                => $optionsev['value'],

					'required'             => $optionsev['required']

				);

			}



			if ($service_info['minimum']) {

				$data['minimum'] = $service_info['minimum'];

			} else {

				$data['minimum'] = 1;

			}



			$data['reviewsev_status'] = $this->config->get('config_reviewsev_status');



			if ($this->config->get('config_reviewsev_guest') || $this->customer->isLogged()) {

				$data['reviewsev_guest'] = true;

			} else {

				$data['reviewsev_guest'] = false;

			}



			if ($this->customer->isLogged()) {

				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();

			} else {

				$data['customer_name'] = '';

			}



			$data['reviewsevs'] = sprintf($this->language->get('text_reviewsevs'), (int)$service_info['reviewsevs']);

			$data['rating'] = (int)$service_info['rating'];



			// Captcha

			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('reviewsev', (array)$this->config->get('config_captcha_page'))) {

				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));

			} else {

				$data['captcha'] = '';

			}



			$data['share'] = $this->url->link('product/service', 'service_id=' . (int)$this->request->get['service_id']);



			$data['attributesev_groups'] = $this->model_catalog_service->getServiceAttributes($this->request->get['service_id']);



			$data['services'] = array();



			$results = $this->model_catalog_service->getServiceRelated($this->request->get['service_id']);



			foreach ($results as $result) {

				if ($result['image']) {

					$image = $this->model_tool_image->resize($result['image'], 300, 326);

				} else {

					$image = $this->model_tool_image->resize('placeholder.png', 300, 326);

				}



				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {

					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

				} else {

					$price = false;

				}



				if ((float)$result['specialsev']) {

					$specialsev = $this->currency->format($this->tax->calculate($result['specialsev'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

				} else {

					$specialsev = false;

				}



				if ($this->config->get('config_tax')) {

					$tax = $this->currency->format((float)$result['specialsev'] ? $result['specialsev'] : $result['price'], $this->session->data['currency']);

				} else {

					$tax = false;

				}



				if ($this->config->get('config_reviewsev_status')) {

					$rating = (int)$result['rating'];

				} else {

					$rating = false;

				}



				$data['services'][] = array(

					'service_id'  => $result['service_id'],

					'thumb'       => $image,

					'name'        => $result['name'],

					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',

					'price'       => $price,

					'specialsev'     => $specialsev,

					'tax'         => $tax,

					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,

					'rating'      => $rating,

					'href'        => $this->url->link('product/service', 'service_id=' . $result['service_id'])

				);

			}



			$data['tags'] = array();



			if ($service_info['tag']) {

				$tags = explode(',', $service_info['tag']);



				foreach ($tags as $tag) {

					$data['tags'][] = array(

						'tag'  => trim($tag),

						'href' => $this->url->link('product/search', 'tag=' . trim($tag))

					);

				}

			}



			$data['recurrings'] = $this->model_catalog_service->getProfiles($this->request->get['service_id']);



			$this->model_catalog_service->updateViewed($this->request->get['service_id']);



			$data['column_left'] = $this->load->controller('common/column_left');

			$data['column_right'] = $this->load->controller('common/column_right');

			$data['content_top'] = $this->load->controller('common/content_top');

			$data['content_bottom'] = $this->load->controller('common/content_bottom');

			$data['footer'] = $this->load->controller('common/footer');

			$data['header'] = $this->load->controller('common/header');



			$this->response->setOutput($this->load->view('product/service', $data));

		} else {

			$url = '';



			if (isset($this->request->get['pathsev'])) {

				$url .= '&pathsev=' . $this->request->get['pathsev'];

			}



			if (isset($this->request->get['filter'])) {

				$url .= '&filter=' . $this->request->get['filter'];

			}



			if (isset($this->request->get['manufacturersev_id'])) {

				$url .= '&manufacturersev_id=' . $this->request->get['manufacturersev_id'];

			}



			if (isset($this->request->get['search'])) {

				$url .= '&search=' . $this->request->get['search'];

			}



			if (isset($this->request->get['tag'])) {

				$url .= '&tag=' . $this->request->get['tag'];

			}



			if (isset($this->request->get['description'])) {

				$url .= '&description=' . $this->request->get['description'];

			}



			if (isset($this->request->get['categorysev_id'])) {

				$url .= '&categorysev_id=' . $this->request->get['categorysev_id'];

			}



			if (isset($this->request->get['sub_categorysev'])) {

				$url .= '&sub_categorysev=' . $this->request->get['sub_categorysev'];

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

				'href' => $this->url->link('product/service', $url . '&service_id=' . $service_id)

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



	public function reviewsev() {

		$this->load->language('product/service');



		$this->load->model('catalog/reviewsev');



		$data['text_no_reviewsevs'] = $this->language->get('text_no_reviewsevs');



		if (isset($this->request->get['page'])) {

			$page = $this->request->get['page'];

		} else {

			$page = 1;

		}



		$data['reviewsevs'] = array();



		$reviewsev_total = $this->model_catalog_reviewsev->getTotalReviewsevsByServiceId($this->request->get['service_id']);



		$results = $this->model_catalog_reviewsev->getReviewsevsByServiceId($this->request->get['service_id'], ($page - 1) * 5, 5);



		foreach ($results as $result) {

			$data['reviewsevs'][] = array(

				'author'     => $result['author'],

				'text'       => nl2br($result['text']),

				'rating'     => (int)$result['rating'],

				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))

			);

		}



		$pagination = new Pagination();

		$pagination->total = $reviewsev_total;

		$pagination->page = $page;

		$pagination->limit = 5;

		$pagination->url = $this->url->link('product/service/reviewsev', 'service_id=' . $this->request->get['service_id'] . '&page={page}');



		$data['pagination'] = $pagination->render();



		$data['results'] = sprintf($this->language->get('text_pagination'), ($reviewsev_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($reviewsev_total - 5)) ? $reviewsev_total : ((($page - 1) * 5) + 5), $reviewsev_total, ceil($reviewsev_total / 5));



		$this->response->setOutput($this->load->view('product/reviewsev', $data));

	}



	public function write() {

		$this->load->language('product/service');



		$json = array();



		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {

				$json['error'] = $this->language->get('error_name');

			}



			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {

				$json['error'] = $this->language->get('error_text');

			}



			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {

				$json['error'] = $this->language->get('error_rating');

			}



			// Captcha

			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('reviewsev', (array)$this->config->get('config_captcha_page'))) {

				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');



				if ($captcha) {

					$json['error'] = $captcha;

				}

			}



			if (!isset($json['error'])) {

				$this->load->model('catalog/reviewsev');



				$this->model_catalog_reviewsev->addReviewsev($this->request->get['service_id'], $this->request->post);



				$json['success'] = $this->language->get('text_success');

			}

		}



		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));

	}



	public function getRecurringDescription() {

		$this->load->language('product/service');

		$this->load->model('catalog/service');



		if (isset($this->request->post['service_id'])) {

			$service_id = $this->request->post['service_id'];

		} else {

			$service_id = 0;

		}



		if (isset($this->request->post['recurring_id'])) {

			$recurring_id = $this->request->post['recurring_id'];

		} else {

			$recurring_id = 0;

		}



		if (isset($this->request->post['quantity'])) {

			$quantity = $this->request->post['quantity'];

		} else {

			$quantity = 1;

		}



		$service_info = $this->model_catalog_service->getService($service_id);

		$recurring_info = $this->model_catalog_service->getProfile($service_id, $recurring_id);



		$json = array();



		if ($service_info && $recurring_info) {

			if (!$json) {

				$frequencies = array(

					'day'        => $this->language->get('text_day'),

					'week'       => $this->language->get('text_week'),

					'semi_month' => $this->language->get('text_semi_month'),

					'month'      => $this->language->get('text_month'),

					'year'       => $this->language->get('text_year'),

				);



				if ($recurring_info['trial_status'] == 1) {

					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $service_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

					$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';

				} else {

					$trial_text = '';

				}



				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $service_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);



				if ($recurring_info['duration']) {

					$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);

				} else {

					$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);

				}



				$json['success'] = $text;

			}

		}



		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));

	}

}

