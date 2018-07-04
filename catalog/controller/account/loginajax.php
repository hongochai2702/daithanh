<?php
class ControllerAccountLoginajax extends Controller {
	private $error = array();

	public function login(){
		$this->load->model('account/customer');
		$this->load->language('account/login');
		// Login override for admin users
		if (!empty($this->request->get['token'])) {
			$this->event->trigger('pre.customer.login');

			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['wishlist']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				$this->event->trigger('post.customer.login');

				$this->response->redirect($this->url->link('account/account', '', 'SSL'));
			}
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			unset($this->session->data['guest']);

			// Default Shipping Address
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}
			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);
			$this->model_account_activity->addActivity('login', $activity_data);
			$data['response'] = $activity_data;
			$data['success'] = true;
		} else {
			$data['success'] = false;
			$data['error_login'] = $this->language->get('error_login');
		}

		$this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
	}
	public function register() {
		$json = array();
		$this->load->model('account/customer');
		$this->load->language('account/register');
		$this->load->model('account/customer');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateRegister()) {

			$customer_id = $this->model_account_customer->addCustomerCustom($this->request->post);

			$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);

			unset($this->session->data['guest']);

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'email'        => $this->customer->getEmail() . ' ' . $this->customer->getLastName()
			);

			$json['success'] = true;
			$json['message'] = $this->language->get('text_success');
			$json['response'] = $activity_data;

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {

				$this->load->model('account/activity');

				$activity_data = array(

					'customer_id' => $customer_id,

					'name'        => $this->request->post['firstname'] . ' ' . $this->request->post['lastname']

				);

				$this->model_account_activity->addActivity('register', $activity_data);
			} 
		} else {
				$json['success'] = false;
				$json['message'] = $this->error;
		}
	
		$this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

	}
	private function validateRegister() {
		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['warning'] = $this->language->get('error_email');
		}
		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {

			$this->error['warning'] = $this->language->get('error_exists');
		}
		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['warning'] = $this->language->get('error_password');
		}
		if ($this->request->post['confirm'] != $this->request->post['password']) {

			$this->error['warning'] = $this->language->get('error_confirm');
		}
		return !$this->error;

	}
	public function index() {
		$this->load->language('account/login');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_new_customer'] = $this->language->get('text_new_customer');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_register_account'] = $this->language->get('text_register_account');
		$data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_login'] = $this->language->get('button_login');
		$data['action'] = $this->url->link('account/loginajax/login', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

		
		return $this->load->view('account/loginajax', $data);
		
	}

	protected function validate() {
		$this->event->trigger('pre.customer.login');

		// Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

		if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
		}

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['warning'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);

				$this->event->trigger('post.customer.login');
			}
		}

		return !$this->error;
	}
}