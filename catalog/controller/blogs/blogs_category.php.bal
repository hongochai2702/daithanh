<?php
class ControllerBlogsBlogsCategory extends Controller {

	public function index() {
		$this->document->setTitle('Blogs Archive');
		$data['heading_title'] = ('Blogs Archive');

		$this->load->language('blogs/blogs');
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home','', 'SSL'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('blogs/blogs_archive','', 'SSL'),
			'text' => $this->language->get('text_blogs_archive')
		);

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->response->setOutput($this->load->view('blogs/blogs_archive', $data));
	}
}