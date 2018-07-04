<?php
class ControllerStartupSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		// Decode URL
		if (isset($this->request->get['_routes_'])) {
			$parts = explode('/', $this->request->get['_routes_']);
			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					if ($url[0] == 'service_id') {
						$this->request->get['service_id'] = $url[1];
					}
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}
					if ($url[0] == 'categorysev_id') {
						if (!isset($this->request->get['pathsev'])) {
							$this->request->get['pathsev'] = $url[1];
						} else {
							$this->request->get['pathsev'] .= '_' . $url[1];
						}
					}
					if ($url[0] == 'portfolio_category_id') {
						if (!isset($this->request->get['pathpor'])) {
							$this->request->get['pathpor'] = $url[1];
						} else {
							$this->request->get['pathpor'] .= '_' . $url[1];
						}
					}
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}
					if ($url[0] == 'post_type_id') {
						$this->request->get['post_type_id'] = $url[1];
					}
					if ($url[0] == 'service_id') {
						$this->request->get['service_id'] = $url[1];
					}
					if ($url[0] == 'portfolio_id') {
						$this->request->get['portfolio_id'] = $url[1];
					}
					if ($url[0] == 'testimonial_id') {
						$this->request->get['testimonial_id'] = $url[1];
					}
					if ($url[0] == 'blogs_id') {
						$this->request->get['blogs_id'] = $url[1];
					}
					if ($url[0] == 'blogs_category_id') {
						$this->request->get['blogs_category_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'blogs_category_id' && $url[0] != 'category_id' && $url[0] != 'portfolio_category_id' && $url[0] != 'categorysev_id'  && $url[0] != 'product_id' && $url[0] != 'service_id' && $url[0] != 'post_type_id' && $url[0] != 'service_id' && $url[0] != 'portfolio_id' && $url[0] != 'testimonial_id' && $url[0] != 'blogs_id') {
						$this->request->get['routes'] = $query->row['query'];
					}
				} else {
				//	$this->request->get['routes'] = 'error/not_found';
					break;
				}
			}
			if (!isset($this->request->get['routes'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['routes'] = 'product/product';
				} if (isset($this->request->get['service_id'])) {
					$this->request->get['routes'] = 'product/service';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['routes'] = 'product/category';
				} elseif (isset($this->request->get['pathsev'])) {
					$this->request->get['routes'] = 'product/categorysev';
				} elseif (isset($this->request->get['portfolio_id'])) {
					$this->request->get['routes'] = 'portfolio/portfolio';
				} elseif (isset($this->request->get['pathpor'])) {
					$this->request->get['routes'] = 'portfolio/category';
				} elseif (isset($this->request->get['blogs_category_id'])) {
					$this->request->get['routes'] = 'blogs/blogs_category';
				} elseif (isset($this->request->get['service_category_id'])) {
					$this->request->get['routes'] = 'service/service_category';
				} elseif (isset($this->request->get['testimonial_category_id'])) {
					$this->request->get['routes'] = 'testimonial/testimonial_category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['routes'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['routes'] = 'information/information';
				} elseif (isset($this->request->get['post_type_id'])) {
					$this->request->get['routes'] = 'post_type/pages';
				} elseif (isset($this->request->get['service_id'])) {
					$this->request->get['routes'] = 'service/service';
				} elseif (isset($this->request->get['testimonial_id'])) {
					$this->request->get['routes'] = 'testimonial/testimonial';
				} elseif (isset($this->request->get['blogs_id'])) {
					$this->request->get['routes'] = 'blogs/blogs';
				}
	
			}
		}
	}
	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));
		$url = '';
		$data = array();
		parse_str($url_info['query'], $data);
		foreach ($data as $key => $value) {
			if (isset($data['routes'])) {
				if (($data['routes'] == 'product/product' && $key == 'product_id') || 
					($data['routes'] == 'product/service' && $key == 'service_id') || 
					(($data['routes'] == 'product/manufacturer/info' || $data['routes'] == 'product/product') && $key == 'manufacturer_id') || ($data['routes'] == 'information/information' && $key == 'information_id') || ($data['routes'] == 'post_type/pages' && $key == 'post_type_id') || ($data['routes'] == 'service/service' && $key == 'service_id') || ($data['routes'] == 'portfolio/portfolio' && $key == 'portfolio_id') || ($data['routes'] == 'blogs/blogs' && $key == 'blogs_id') || ($data['routes'] == 'blogs/blogs_category' && $key == 'blogs_category_id') 
				    || ($data['routes'] == 'testimonial/testimonial' && $key == 'testimonial_id') ) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					}
				} elseif ($key == 'path') {
					$categories = explode('_', $value);
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';
							break;
						}
					}
					unset($data[$key]);
				} elseif ($key == 'pathsev') {
					$categories = explode('_', $value);
					foreach ($categories as $categorysev) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'categorysev_id=" . (int)$categorysev . "'");
						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';
							break;
						}
					}
					unset($data[$key]);
				} elseif ($key == 'pathpor') {
					$categories = explode('_', $value);
					foreach ($categories as $categorypor) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'portfolio_category_id=" . (int)$categorypor . "'");
						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';
							break;
						}
					}
					unset($data[$key]);
				}
			}
		}
		if ($url) {
			unset($data['routes']);
			$query = '';
			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
				}
				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}
			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}