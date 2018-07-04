<?php
class ControllerBlogsBlogs extends Controller {
	public function index() {
		$this->load->language('blogs/blogs');

		$this->load->model('catalog/blogs');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_blogs'),
			'href' => $this->url->link('blogs/blogs')
		);

		if (isset($this->request->get['blogs_id'])) {
			$blogs_id = (int)$this->request->get['blogs_id'];
		} else {
			$blogs_id = 0;
		}

		$blogs_info = $this->model_catalog_blogs->getBlogs($blogs_id);
		if ($blogs_info) {
			$this->document->setTitle($blogs_info['meta_title']);
			$this->document->setDescription($blogs_info['meta_description']);
			$this->document->setKeywords($blogs_info['meta_keyword']);
			
			$data['breadcrumbs'][] = array(
				'text' => $blogs_info['name'],
				'href' => $this->url->link('blogs/blogs', 'blogs_id=' .  $blogs_id)
			);

			$data['heading_title'] = $blogs_info['name'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['name'] 			= $blogs_info['name'];
			$data['image'] 			= URL_HOME . 'image/' .$blogs_info['image'];
			$data['description'] 	= html_entity_decode($blogs_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('blogs/blogs_single', $data));
	}
}