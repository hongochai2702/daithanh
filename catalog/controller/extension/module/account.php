<?php

class ControllerExtensionModuleAccount extends Controller {

	public function index() {

		$this->load->language('extension/module/account');



		$data['heading_title'] = $this->language->get('heading_title');



		$data['text_register'] = $this->language->get('text_register');

		$data['text_login'] = $this->language->get('text_login');

		$data['text_logout'] = $this->language->get('text_logout');

		$data['text_forgotten'] = $this->language->get('text_forgotten');

		$data['text_account'] = $this->language->get('text_account');

		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_password'] = $this->language->get('text_password');

		$data['text_address'] = $this->language->get('text_address');

		$data['text_wishlist'] = $this->language->get('text_wishlist');

		$data['text_order'] = $this->language->get('text_order');

		$data['text_download'] = $this->language->get('text_download');

		$data['text_reward'] = $this->language->get('text_reward');

		$data['text_return'] = $this->language->get('text_return');

		$data['text_transaction'] = $this->language->get('text_transaction');

		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$data['text_recurring'] = $this->language->get('text_recurring');



		$data['logged'] = $this->customer->isLogged();

		$data['register'] = str_replace(URL_HOME,'',$this->url->link('account/register', '', true));

		$data['login'] = str_replace(URL_HOME,'',$this->url->link('account/login', '', true));

		$data['logout'] = str_replace(URL_HOME,'',$this->url->link('account/logout', '', true));

		$data['forgotten'] = str_replace(URL_HOME,'',$this->url->link('account/forgotten', '', true));

		$data['account'] = str_replace(URL_HOME,'',$this->url->link('account/account', '', true));

		$data['edit'] = str_replace(URL_HOME,'',$this->url->link('account/edit', '', true));

		$data['password'] = str_replace(URL_HOME,'',$this->url->link('account/password', '', true));

		$data['address'] = str_replace(URL_HOME,'',$this->url->link('account/address', '', true));

		$data['wishlist'] = str_replace(URL_HOME,'',$this->url->link('account/wishlist'));

		$data['order'] = str_replace(URL_HOME,'',$this->url->link('account/order', '', true));

		$data['download'] = str_replace(URL_HOME,'',$this->url->link('account/download', '', true));

		$data['reward'] = str_replace(URL_HOME,'',$this->url->link('account/reward', '', true));

		$data['return'] = str_replace(URL_HOME,'',$this->url->link('account/return', '', true));

		$data['transaction'] = str_replace(URL_HOME,'',$this->url->link('account/transaction', '', true));

		$data['newsletter'] = str_replace(URL_HOME,'',$this->url->link('account/newsletter', '', true));

		$data['recurring'] = str_replace(URL_HOME,'',$this->url->link('account/recurring', '', true));



		return $this->load->view('extension/module/account', $data);

	}

}