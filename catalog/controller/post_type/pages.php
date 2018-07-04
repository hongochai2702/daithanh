<?php
class ControllerPostTypePages extends Controller {
	public function index() {
		$this->load->language('post_type/pages');

		$this->load->model('post_type/pages');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['post_type_id'])) {
			$post_type_id = (int)$this->request->get['post_type_id'];
		} else {
			$post_type_id = 0;
		}

		$post_type_info = $this->model_post_type_pages->getPostType($post_type_id);

		if ($post_type_info) {
			$this->document->setTitle($post_type_info['meta_title']);
			$this->document->setDescription($post_type_info['meta_description']);
			$this->document->setKeywords($post_type_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $post_type_info['title'],
				'href' => $this->url->link('post_type/pages', 'post_type_id=' .  $post_type_id)
			);

			$data['heading_title'] = $post_type_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');
			
			if ( utf8_strlen($post_type_info['description']) >= 10 ) {
				$data['description'] = '';
			} else {
				$data['description'] = html_entity_decode($post_type_info['description'], ENT_QUOTES, 'UTF-8');
			}

			$module_data = $this->get_module($post_type_info['modules']);
			if ( !empty($module_data) ) {
				$data['modules'] = $module_data;
			} else {
				$data['modules'] = '';
			}
			$data['continue'] = $this->url->link('common/home');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('post_type/pages', $data));
	}

	private function get_module($data) {

		$module_data = array();
		if ( !empty($data) ) {
			$modules = explode(',', $data);
			if ( !empty($modules) ) {

				$this->load->model('extension/module');
				foreach ($modules as $md) {
					$render .= $this->load->controller('extension/module/so_page_builder', $this->model_extension_module->getModule( $md ));
				}
			}
		}
		
		return $render;
	}
}