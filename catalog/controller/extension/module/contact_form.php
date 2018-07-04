<?php
class ControllerExtensionModuleContactForm extends Controller {

	private $error;

	public function index($setting) {
		$this->load->language('extension/module/contact_form');
		
		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$data['action'] = $this->url->link('extension/module/contact_form/send_mail', '', "SSL");
		$data['module_id'] = $setting['module_id'];
		$data = $this->language->merge($data);
		return $this->load->view('extension/module/contact_form', $data);
	}

	public function send_mail() {

		$this->load->language('extension/module/contact_form');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->request->post['email']);
			$mail->setSender(html_entity_decode($this->request->post['company_name'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['company_name']), ENT_QUOTES, 'UTF-8'));

			$mailTemplate = '<ul>';
			$mailTemplate .= sprintf('<li>%s %s</li>',$this->language->get('entry_company_name'), $this->request->post['company_name']);
			$mailTemplate .= sprintf('<li>%s %s</li>',$this->language->get('entry_email'), $this->request->post['email']);
			$mailTemplate .= sprintf('<li>%s %s</li>',$this->language->get('entry_phone'), $this->request->post['phone']);
			$mailTemplate .= sprintf('<li>%s %s</li>',$this->language->get('entry_enquiry'), $this->request->post['enquiry']);
			$mailTemplate .= '</ul>';
			$mail->setHtml(html_entity_decode($mailTemplate, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			$json['success'] = $this->language->get('text_success_form');
		}

		if (isset($this->error['company_name'])) {
			$json['error_company_name'] = $this->error['company_name'];
		} else {
			$json['error_company_name'] = '';
		}

		if (isset($this->error['error_phone'])) {
			$json['phone'] = $this->error['error_phone'];
		} else {
			$json['phone'] = '';
		}


		if (isset($this->error['error_email'])) {
			$json['email'] = $this->error['error_email'];
		} else {
			$json['email'] = '';
		}

		$json['error'] = $this->error;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	protected function validateForm() {

		if ((utf8_strlen($this->request->post['company_name']) < 3) || (utf8_strlen($this->request->post['company_name']) > 32)) {
			$this->error['company_name'] = $this->language->get('error_company_name');
		}

		if ((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 32)) {
			$this->error['phone'] = $this->language->get('error_phone');
		}

		if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}
}