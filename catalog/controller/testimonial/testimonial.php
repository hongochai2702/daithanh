<?php
class ControllerTestimonialTestimonial extends Controller {
	public function index() {
		$this->load->language('testimonial/testimonial');

		$this->load->model('testimonial/testimonial');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_testimonial'),
			'href' => $this->url->link('testimonial/testimonial')
		);

		if (isset($this->request->get['testimonial_id'])) {
			$testimonial_id = (int)$this->request->get['testimonial_id'];
		} else {
			$testimonial_id = 0;
		}

		$testimonial_info = $this->model_testimonial_testimonial->getTestimonial($testimonial_id);

		if ($testimonial_info) {
			$this->document->setTitle($testimonial_info['meta_title']);
			$this->document->setDescription($testimonial_info['meta_description']);
			$this->document->setKeywords($testimonial_info['meta_keyword']);
			
			$data['breadcrumbs'][] = array(
				'text' => $testimonial_info['name'],
				'href' => $this->url->link('testimonial/testimonial', 'testimonial_id=' .  $testimonial_id)
			);

			$data['heading_title'] = $testimonial_info['name'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['name'] 			= $testimonial_info['name'];
			$data['position'] 		= $testimonial_info['position'];
			$data['social_meta'] 	= $testimonial_info['social_meta'];
			$data['image'] 			= URL_HOME . 'image/' .$testimonial_info['image'];
			$data['description'] 	= html_entity_decode($testimonial_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('testimonial/testimonial', $data));
	}
}