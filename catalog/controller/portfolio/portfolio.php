<?php
class ControllerPortfolioPortfolio extends Controller {
	public function index() {
		$this->load->language('portfolio/portfolio');

		$this->load->model('catalog/portfolio');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_portfolio'),
			'href' => $this->url->link('portfolio/portfolio')
		);

		// Flexslider thumnail.
		$this->document->addStyle('catalog/view/theme/default/stylesheet/flexslider/flexslider.css');
		$this->document->addScript('catalog/view/theme/default/stylesheet/flexslider/jquery.flexslider-min.js');
		$this->document->addScript('catalog/view/theme/default/stylesheet/flexslider/jquery.flexslider.lazyloader.js');

		// Fancybox version3.
		$this->document->addStyle('catalog/view/theme/default/javascript/jquery/fancybox3/jquery.fancybox.min.css');
		$this->document->addScript('catalog/view/theme/default/javascript/jquery/fancybox3/jquery.fancybox.min.js');

		if (isset($this->request->get['portfolio_id'])) {
			$portfolio_id = (int)$this->request->get['portfolio_id'];
		} else {
			$portfolio_id = 0;
		}

		$this->load->model('catalog/portfolio_category');
		$data['categories'] = array();
		$results = $this->model_catalog_portfolio_category->getPortfolioCategories(0);
		foreach ($results as $result) {
			$filter_data = array(
				'filter_portfolio_category_id'  => $result['portfolio_category_id'],
				'filter_sub_portfolio_category' => true
			);
			$data['categories'][] = array(
				'name' => $result['name'] . ($this->config->get('config_portfolio_count') ? ' (' . $this->model_catalog_portfolio->getTotalPortfolios($filter_data) . ')' : ''),
				'href' => $this->url->link('portfolio/category', 'pathpor=' . $result['portfolio_category_id'] . $url)
			);
		}

		$portfolio_info = $this->model_catalog_portfolio->getPortfolio($portfolio_id);
		if ($portfolio_info) {
			
			$this->document->setTitle($portfolio_info['meta_title']);
			$this->document->setDescription($portfolio_info['meta_description']);
			$this->document->setKeywords($portfolio_info['meta_keyword']);
			
			if ( !$portfolio_info['meta_title'] ) {
				$this->document->setTitle($portfolio_info['name']);
			}

			$data['heading_title'] = $portfolio_info['name'];
			$data['breadcrumbs'][] = array(
				'text' => $portfolio_info['name'],
				'href' => $this->url->link('portfolio/portfolio', 'portfolio_id=' .  $portfolio_id)
			);

			// Get data portfolio/
			$data['name'] 	= $portfolio_info['name'];
			$data['description'] 			= html_entity_decode($portfolio_info['description'], ENT_QUOTES, 'UTF-8');
			$data['challenge_description'] 	= html_entity_decode($portfolio_info['challenge_description'], ENT_QUOTES, 'UTF-8');

			// Get featured image.
			$this->load->model('tool/image');
			if ( !empty($portfolio_info['image']) ) {
				$data['popup'] 	= URL_HOME . 'image/' . $portfolio_info['image'];
				$data['thumb'] 	= $this->model_tool_image->resize($portfolio_info['image'],150,85 );
				$data['image'] 	= $this->model_tool_image->resize($portfolio_info['image'],640,385 );
			}

			// Get gallery image in portfolio.
			$data['gallery_thumb']  = array();
			$gallery_thumb = $this->model_catalog_portfolio->getPortfolioImages($portfolio_id); 
			if ( !empty($gallery_thumb) ) {
				foreach ($gallery_thumb as $image) {
					$data['gallery_thumb'][] = array(
						'image_id' 	=> $image['portfolio_image_id'],
						'thumb'		=> $this->model_tool_image->resize( $image['image'], 150, 85 ),
						'popup'		=> URL_HOME . 'image/' . $image['image'],
						'image'		=> $this->model_tool_image->resize( $image['image'], 640, 385 ),
					);
				}
			}

			// Get gallery image in portfolio.
			$data['portfolio_options']  = array();
			$portfolio_options = $this->model_catalog_portfolio->getPortfolioOptions($portfolio_id); 
			if ( !empty($portfolio_options) ) {
				foreach ($portfolio_options as $key => $option) {
					$data['portfolio_options'][$option['option_key']] = $option['value'];
				}
			}

			// Get related portfolio.
			$data['portfolio_related']  = array();
			$portfolio_related = $this->model_catalog_portfolio->getPortfolioRelated($portfolio_id); 
			if ( !empty($portfolio_related) ) {
				foreach ($portfolio_related as $related) {
					if ($related['image']) {
						$image = $this->model_tool_image->resize($related['image'], 336, 285 );
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 336, 285);
					}

					$data['portfolio_related'][] = array(
						'portfolio_id'  => $related['portfolio_id'],
						'thumb'       => $image,
						'image'       => URL_HOME . 'image/' . $related['image'],
						'name'        => $related['name'],
						'short_description' => html_entity_decode($related['short_description'], ENT_QUOTES, 'UTF-8'),
						'href'        => $this->url->link('portfolio/portfolio', 'portfolio_id=' . $related['portfolio_id'])
					);
				}
				
			}
			$data['continue'] = $this->url->link('common/home');
		}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('portfolio/portfolio_single', $data));
	}
}