<?php
class ModelPortfolioPortfolio extends Model {
	public function addPortfolio($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");
		$portfolio_id = $this->db->getLastId();
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "portfolio SET image = '" . $this->db->escape($data['image']) . "' WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		}
		foreach ($data['portfolio_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_description SET portfolio_id = '" . (int)$portfolio_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', challenge_description = '" . $this->db->escape($value['challenge_description']) . "'");
		}
		if (isset($data['portfolio_store'])) {
			foreach ($data['portfolio_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_to_store SET portfolio_id = '" . (int)$portfolio_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		if (isset($data['portfolio_image'])) {
			foreach ($data['portfolio_image'] as $portfolio_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_image SET portfolio_id = '" . (int)$portfolio_id . "', image = '" . $this->db->escape($portfolio_image['image']) . "', sort_order = '" . (int)$portfolio_image['sort_order'] . "'");
			}
		}
		if (isset($data['portfolio_options'])) {
			foreach ($data['portfolio_options'] as $language_id => $options) {
				foreach ($options as $key => $value) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_options SET value ='" . $this->db->escape($value) . "', option_key = '" . $this->db->escape($key) . "', portfolio_id = '" . (int)$portfolio_id . "', language_id = '" . (int)$language_id . "'");
				}
			}		
		}
		if (isset($data['portfolio_category'])) {
			foreach ($data['portfolio_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_to_category SET portfolio_id = '" . (int)$portfolio_id . "', portfolio_category_id = '" . (int)$category_id . "'");
			}
		}
		if (isset($data['portfolio_related'])) {
			foreach ($data['portfolio_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_related WHERE portfolio_id = '" . (int)$portfolio_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_related SET portfolio_id = '" . (int)$portfolio_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_related WHERE portfolio_id = '" . (int)$related_id . "' AND related_id = '" . (int)$portfolio_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_related SET portfolio_id = '" . (int)$related_id . "', related_id = '" . (int)$portfolio_id . "'");
			}
		}
		// SEO URL
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'portfolio_id=" . (int)$portfolio_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		
		if (isset($data['portfolio_layout'])) {
			foreach ($data['portfolio_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_to_layout SET portfolio_id = '" . (int)$portfolio_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		$this->cache->delete('post_type','portfolio');
		return $portfolio_id;
	}
	public function insertPortfolioOptions($data, $portfolio_id, $language_id) {
		if ( !empty($data) ) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_options SET value ='" . $this->db->escape($data['value']) . "', option_key = '" . $this->db->escape($data['key']) . "', portfolio_id = '" . (int)$portfolio_id . "', language_id = '" . (int)$language_id . "'");
		}
	}

	public function editPortfolio($portfolio_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "portfolio SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "portfolio SET image = '" . $this->db->escape($data['image']) . "' WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_description WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($data['portfolio_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_description SET portfolio_id = '" . (int)$portfolio_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', challenge_description = '" . $this->db->escape($value['challenge_description']) . "'");
		}
		if (isset($data['portfolio_options'])) {
			foreach ($data['portfolio_options'] as $language_id => $options) {
				foreach ($options as $key => $value) {
					$update = $this->db->query("UPDATE " . DB_PREFIX . "portfolio_options SET value ='" . $this->db->escape($value) . "' WHERE option_key = '" . $this->db->escape($key) . "' AND portfolio_id = '" . (int)$portfolio_id . "' AND language_id = '" . (int)$language_id . "'");

					// IF option null. processing insert option.
					if( $update != 0 ) {
						$params = array( 'key' => $key, 'value' => $value );
						$this->insertPortfolioOptions($params, $portfolio_id, $language_id);
					}
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_to_store WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		if (isset($data['portfolio_store'])) {
			foreach ($data['portfolio_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_to_store SET portfolio_id = '" . (int)$portfolio_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_image WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		if (isset($data['portfolio_image'])) {
			foreach ($data['portfolio_image'] as $portfolio_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_image SET portfolio_id = '" . (int)$portfolio_id . "', image = '" . $this->db->escape($portfolio_image['image']) . "', sort_order = '" . (int)$portfolio_image['sort_order'] . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_to_category WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		if (isset($data['portfolio_category'])) {
			foreach ($data['portfolio_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_to_category SET portfolio_id = '" . (int)$portfolio_id . "', portfolio_category_id = '" . (int)$category_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_related WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_related WHERE related_id = '" . (int)$portfolio_id . "'");
		if (isset($data['portfolio_related'])) {
			foreach ($data['portfolio_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_related WHERE portfolio_id = '" . (int)$portfolio_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_related SET portfolio_id = '" . (int)$portfolio_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_related WHERE portfolio_id = '" . (int)$related_id . "' AND related_id = '" . (int)$portfolio_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_related SET portfolio_id = '" . (int)$related_id . "', related_id = '" . (int)$portfolio_id . "'");
			}
		}
		// SEO URL
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'portfolio_id=" . (int)$portfolio_id . "'");
		
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'portfolio_id=" . (int)$portfolio_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_to_layout WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		if (isset($data['portfolio_layout'])) {
			foreach ($data['portfolio_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "portfolio_to_layout SET portfolio_id = '" . (int)$portfolio_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		$this->cache->delete('post_type','portfolio');
	}
	public function copyPortfolio($portfolio_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "portfolio p WHERE p.portfolio_id = '" . (int)$portfolio_id . "'");
		if ($query->row) {
			$data = $query->row;
			$data['portfolio_description'] = $this->getPortfolioDescriptions($portfolio_id);
			$data['portfolio_image'] = $this->getPortfolioImages($portfolio_id);
			
			$data['portfolio_options'] = $this->getPortfolioOptions($portfolio_id);
			$data['portfolio_category'] = $this->getPortfolioCategories($portfolio_id);
			$data['portfolio_layout'] = $this->getPortfolioLayouts($portfolio_id);
			$data['portfolio_store'] = $this->getPortfolioStores($portfolio_id);
			$this->addPortfolio($data);
		}
	}
	public function deletePortfolio($portfolio_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_description WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_image WHERE portfolio_id = '" . (int)$portfolio_id . "'");
	
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_to_category WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_to_layout WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "portfolio_to_store WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'portfolio_id=" . (int)$portfolio_id . "'");
		
		$this->cache->delete('post_type','portfolio');
	}
	public function getPortfolio($portfolio_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'portfolio_id=" . (int)$portfolio_id . "') AS keyword FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) WHERE p.portfolio_id = '" . (int)$portfolio_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->row;
	}
	public function getPortfolios($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		$sql .= " GROUP BY p.portfolio_id";
		$sort_data = array(
			'pd.name',
			'p.status',
			'p.sort_order'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getPortfoliosByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_category p2c ON (p.portfolio_id = p2c.portfolio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
		return $query->rows;
	}
	public function getPortfolioDescriptions($portfolio_id) {
		$portfolio_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_description WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($query->rows  as $result) {
			$portfolio_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'short_description'      => $result['short_description'],
				'challenge_description'      => $result['challenge_description'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}
		return $portfolio_description_data;
	}
	public function getPortfolioCategories($portfolio_id) {
		$portfolio_category_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_to_category WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($query->rows  as $result) {
			$portfolio_category_data[] = $result['portfolio_category_id'];
		}
		return $portfolio_category_data;
	}
	public function getPortfolioFilters($portfolio_id) {
		$portfolio_filter_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_filter WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($query->rows  as $result) {
			$portfolio_filter_data[] = $result['filter_id'];
		}
		return $portfolio_filter_data;
	}
	public function getPortfolioOptions($portfolio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_options WHERE portfolio_id = '" . (int)$portfolio_id . "' ORDER BY option_id ASC");
		foreach ($query->rows as $options) {
			$data[$options['language_id']][$options['option_key']] = $options['value'];
		}
		return $data;
	}
	
	public function getPortfolioImages($portfolio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_image WHERE portfolio_id = '" . (int)$portfolio_id . "' ORDER BY sort_order ASC");
		return $query->rows;
	}
	public function getPortfolioStores($portfolio_id) {
		$portfolio_store_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_to_store WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($query->rows  as $result) {
			$portfolio_store_data[] = $result['store_id'];
		}
		return $portfolio_store_data;
	}
	
	public function getPortfolioRelated($portfolio_id) {
		$portfolio_related_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_related WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($query->rows as $result) {
			$portfolio_related_data[] = $result['related_id'];
		}
		return $portfolio_related_data;
	}
	public function getPortfolioSeoUrls($portfolio_id) {
		$portfolio_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'portfolio_id=" . (int)$portfolio_id . "'");
		foreach ($query->rows  as $result) {
			$portfolio_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}
		return $portfolio_seo_url_data;
	}
	
	public function getPortfolioLayouts($portfolio_id) {
		$portfolio_layout_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_to_layout WHERE portfolio_id = '" . (int)$portfolio_id . "'");
		foreach ($query->rows  as $result) {
			$portfolio_layout_data[$result['store_id']] = $result['layout_id'];
		}
		return $portfolio_layout_data;
	}
	public function getTotalPortfolios($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.portfolio_id) AS total FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id)";
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		$query = $this->db->query($sql);
		$result = $query->row;
		return $result['total'];
	}
	public function getTotalPortfoliosByLayoutId($layout_id) {
		return $this->db->where('layout_id', (int)$layout_id)->count_all('portfolio_to_layout');
	}
}