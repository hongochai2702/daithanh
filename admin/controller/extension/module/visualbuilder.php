<?php
class ControllerExtensionModuleVisualBuilder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/visualbuilder');
		
		// $catalogURL = $this->getCatalogURL();
		
		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/visualbuilder/visualbuilder.css');
		$this->document->addStyle('view/stylesheet/visualbuilder/switchy.css');
		$this->document->addStyle('view/stylesheet/visualbuilder/multiselect.css');
		$this->document->addScript('view/javascript/visualbuilder/builder.js');
		$this->document->addScript('view/javascript/visualbuilder/jquery-ui.min.js');
		$this->document->addScript('view/javascript/visualbuilder/jquery.multi-select.js');
		$this->document->addScript('view/javascript/visualbuilder/switchy.js');

		$this->load->model('extension/module/visualbuilder');
		
		$this->getForm();
	}
	
	/**
	 * Save module settings
	 */
	public function saveModuleSettings(){
			
		$this->load->language('extension/module/visualbuilder');
		
		if (!$this->user->hasPermission('modify', 'extension/module/visualbuilder')) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}	
		
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_setting->editSetting('visualbuilder', $this->request->post);
			echo json_encode(array_values($this->request->post));	
		} 
	}
	public function edit() {
			
		$this->load->language('extension/module/visualbuilder');
		
		$this->load->model('extension/module/visualbuilder');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			
			if (isset($this->request->get['layout_id'])) {
				$selectedlayout = $this->request->get['layout_id'];
			} else {
				$selectedlayout = 1;
			}
						
			$this->model_extension_module_visualbuilder->editLayout($selectedlayout, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '&layout_id=' . $selectedlayout;

			$this->response->redirect($this->url->link('extension/module/visualbuilder', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	
    /**
     *
     */
    protected function getForm() {
		
		$languageVariables = array(
            'heading_title',
            'text_module',
            'text_choose_layout',
            'text_builder',
            'text_success',
            'text_edit',
            'text_content_top',
            'text_content_bottom',
            'text_column_right',
            'text_column_left',
            'text_active_modules',
            'text_available_modules',
            'text_excluded_modules',
            'text_settings',
            'text_selected_banner',
            'text_you_are_editing',
            'text_module_settings',
            'text_module_settings_help',
            'text_module_success',
            'text_image_size',
            'text_choose_layout',
            'text_build',
            'text_view',
            'text_layout',
            'button_apply',
            'button_save',
            'button_cancel',
            'error_input_form',
         	'heading_title',
			'text_edit',
			'text_default',
			'text_enabled',
			'text_disabled',
			'text_module_disabled',
			'entry_name',
			'entry_store',
			'entry_route',
			'entry_module',
			'entry_position',
			'entry_sort_order',
			'button_save',
			'button_cancel',
			'button_route_add',
			'button_module_add',
			'button_remove'
        );
       
        foreach ($languageVariables as $languageVariable) {
            $data[$languageVariable] = $this->language->get($languageVariable);
        }

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


		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/visualbuilder', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['saveModulePositions'] = $this->url->link('extension/module/visualbuilder/saveModuleSettings', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['excluded_modules'] = array();
		
		if($this->config->get('visualbuilder_excluded')){
			$data['excluded_modules'] = $this->config->get('visualbuilder_excluded');
		}
		
		$data['layouts'] = array();

		$layout_total = $this->model_extension_module_visualbuilder->getTotalLayouts();

		$results = $this->model_extension_module_visualbuilder->getLayouts();
		
		

		foreach ($results as $result) {
			
		$routes = $this->model_extension_module_visualbuilder->getLayoutRoute($result['layout_id']);

		foreach( $routes as $route ) {
				if($route['route']=="product/product") $layout_route=$route['route'].'&product_id='.$this->getProductId();
				else if($route['route']=="product/category") $layout_route=$route['route'].'&path='.$this->getCategoryId();
				else if($route['route']=="checkout/") $layout_route=$route['route'].'cart';
				else if($route['route']=="account") $layout_route=$route['route'].'/account';
				else if($route['route']=="affiliate/") $layout_route=$route['route'].'account';
				else if($route['route']=="information/information") $layout_route=$route['route'].'&information_id='.$this->getInformationId();
				else $layout_route=$route['route'];

		}
		
			
			$data['layouts'][] = array(
				'layout_id' => $result['layout_id'],
				'name'      => $result['name'],
				'route'		=> $layout_route,
				'edit'      => $this->url->link('extension/module/visualbuilder', 'token=' . $this->session->data['token'] . '&layout_id=' . $result['layout_id'] . $url, 'SSL')
			);
		}
				
		
		if (!isset($this->request->get['layout_id'])) {
			$data['selected_layout'] = 1;
		} else {
			$data['selected_layout'] = $this->request->get['layout_id'];
		}
		
		$data['action'] = $this->url->link('extension/module/visualbuilder/edit', 'token=' . $this->session->data['token'] . '&layout_id=' . $data['selected_layout'] . $url, 'SSL');

		$data['cancel'] = $this->url->link('extension/module/visualbuilder', 'token=' . $this->session->data['token'] . $url, 'SSL');


		$layout_info = $this->model_extension_module_visualbuilder->getLayout($data['selected_layout']);
		
		$data['layoutmodules'] = $this->model_extension_module_visualbuilder->getLayoutModules($data['selected_layout']);
		

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($layout_info)) {
			$data['name'] = $layout_info['name'];
		} else {
			$data['name'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['layout_route'])) {
			$data['layout_routes'] = $this->request->post['layout_route'];
		} elseif (isset($data['selected_layout'])) {
			$data['layout_routes'] = $this->model_extension_module_visualbuilder->getLayoutRoutes($data['selected_layout']);
		} else {
			$data['layout_routes'] = array();
		}
		
		if (isset($this->request->post['layout_module'])) {
			$data['layout_modules'] = $this->request->post['layout_module'];
		} elseif (isset($data['selected_layout'])) {
			$data['layout_modules'] = $this->model_extension_module_visualbuilder->getLayoutModules($data['selected_layout']);
		} else {
			$data['layout_modules'] = array();
		}
		
		$this->load->model('extension/extension');

		$this->load->model('extension/module');
		
		$data['modules'] = array();
		
		$extensions = $this->model_extension_extension->getInstalled('module');
		
		foreach ($extensions as $code) {
			$this->load->language('extension/module/' . $code);
		
			$module_data = array();
			$settings_data = array();

			$modules = $this->model_extension_module->getModulesByCode($code);
			
			foreach ($modules as $module) {
				$module_data[] = array(
					'name' => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
					'code' => $code . '.' .  $module['module_id'],
					'setting' => json_decode($module['setting'], true),
					'href' => $this->url->link('extension/module/' . $code . '&module_id='.$module['module_id'], 'token=' . $this->session->data['token'] . $url, 'SSL'),
					'group' => $code
				);
				}
			
			if ($module_data) {
				$data['modules'][] = array(
					'name'   => $this->language->get('heading_title'),
					'hasSettings'   => true,
					'module' => $module_data,
					'module_link' => $this->url->link('extension/module/' . $code . '', 'token=' . $this->session->data['token'] . $url, 'SSL'),
					'group' => $code
				);
			} else {
				if($code!="visualbuilder"){
					$settings_data = array(
						'name' => $this->language->get('heading_title'),
						'status' => $this->config->get($code.'_status')
					);
				
					$module_data[] = array(
						'name' => $this->language->get('heading_title'),
						'code' => $code,
						'setting' => $settings_data,
						'href' => $this->url->link('extension/module/' . $code . '', 'token=' . $this->session->data['token'] . $url, 'SSL'),
						'group' => $code
					);
					
					$data['modules'][] = array(
						'name'   => $this->language->get('heading_title'),
						'hasSettings'   => false,
						'module' => $module_data,
						'module_link' => $this->url->link('extension/module/' . $code . '', 'token=' . $this->session->data['token'] . $url, 'SSL'),
						'group' => $code
					);
					
					}
			}
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/visualbuilder_form', $data));
	}

	protected function getProductId(){
		return $data['productId'] = $this->model_extension_module_visualbuilder->getProductId();
	} 
	 
	protected function getCategoryId(){
		return $data['categoryId'] = $this->model_extension_module_visualbuilder->getCategoryId();
	} 
	protected function getInformationId(){
		return $data['informationId'] = $this->model_extension_module_visualbuilder->getInformationId();
	} 
	
	protected function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/visualbuilder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}


}