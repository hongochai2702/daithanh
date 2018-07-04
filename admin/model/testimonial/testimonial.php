<?php
class ModelTestimonialTestimonial extends Model {
	public function addTestimonial($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', social_meta = '" . $this->db->escape($data['social_meta']) . "', position = '" . $this->db->escape($data['position']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");

		$testimonial_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET image = '" . $this->db->escape($data['image']) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		foreach ($data['testimonial_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_description SET testimonial_id = '" . (int)$testimonial_id . "', language_id = '" . (int)$language_id .  "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");

		}

		if (isset($data['testimonial_store'])) {
			foreach ($data['testimonial_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_to_store SET testimonial_id = '" . (int)$testimonial_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['testimonial_image'])) {
			foreach ($data['testimonial_image'] as $testimonial_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_image SET testimonial_id = '" . (int)$testimonial_id . "', image = '" . $this->db->escape($testimonial_image['image']) . "', sort_order = '" . (int)$testimonial_image['sort_order'] . "'");
			}
		}

		

		if (isset($data['testimonial_category'])) {
			foreach ($data['testimonial_category'] as $testimonial_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_to_category SET testimonial_id = '" . (int)$testimonial_id . "', testimonial_category_id = '" . (int)$testimonial_category_id . "'");
			}
		}

		

		// SEO URL
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'testimonial_id=" . (int)$testimonial_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		
		if (isset($data['testimonial_layout'])) {
			foreach ($data['testimonial_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_to_layout SET testimonial_id = '" . (int)$testimonial_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}


		$this->cache->delete('post_type','testimonial');

		return $testimonial_id;
	}

	public function editTestimonial($testimonial_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', position = '" . $this->db->escape($data['position']) . "', social_meta = '" . $this->db->escape($data['social_meta']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET image = '" . $this->db->escape($data['image']) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_description WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($data['testimonial_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_description SET testimonial_id = '" . (int)$testimonial_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_to_store WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['testimonial_store'])) {
			foreach ($data['testimonial_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_to_store SET testimonial_id = '" . (int)$testimonial_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_image WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['testimonial_image'])) {
			foreach ($data['testimonial_image'] as $testimonial_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_image SET testimonial_id = '" . (int)$testimonial_id . "', image = '" . $this->db->escape($testimonial_image['image']) . "', sort_order = '" . (int)$testimonial_image['sort_order'] . "'");
			}
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_to_category WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['testimonial_category'])) {
			foreach ($data['testimonial_category'] as $testimonial_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_to_category SET testimonial_id = '" . (int)$testimonial_id . "', testimonial_category_id = '" . (int)$testimonial_category_id . "'");
			}
		}

		// SEO URL
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'testimonial_id=" . (int)$testimonial_id . "'");
		
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'testimonial_id=" . (int)$testimonial_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_to_layout WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['testimonial_layout'])) {
			foreach ($data['testimonial_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial_to_layout SET testimonial_id = '" . (int)$testimonial_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('post_type','testimonial');
	}

	public function copyTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "testimonial p WHERE p.testimonial_id = '" . (int)$testimonial_id . "'");

		if ($query->row) {
			$data = $query->row;

			$data['testimonial_description'] = $this->getTestimonialDescriptions($testimonial_id);
			$data['testimonial_image'] = $this->getTestimonialImages($testimonial_id);
			
			$data['testimonial_category'] = $this->getTestimonialCategories($testimonial_id);
			$data['testimonial_layout'] = $this->getTestimonialLayouts($testimonial_id);
			$data['testimonial_store'] = $this->getTestimonialStores($testimonial_id);
			$this->addTestimonial($data);
		}
	}

	public function deleteTestimonial($testimonial_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_description WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_image WHERE testimonial_id = '" . (int)$testimonial_id . "'");
	
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_to_category WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_to_layout WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial_to_store WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'testimonial_id=" . (int)$testimonial_id . "'");
		

		$this->cache->delete('post_type','testimonial');
	}

	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'testimonial_id=" . (int)$testimonial_id . "') AS keyword FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) WHERE p.testimonial_id = '" . (int)$testimonial_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getTestimonials($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.testimonial_id";

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

	public function getTestimonialsByCategoryId($testimonial_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_category p2c ON (p.testimonial_id = p2c.testimonial_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.testimonial_category_id = '" . (int)$testimonial_category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getTestimonialDescriptions($testimonial_id) {
		$testimonial_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_description WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'position'         => $result['position'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $testimonial_description_data;
	}

	public function getTestimonialCategories($testimonial_id) {
		$testimonial_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_to_category WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_category_data[] = $result['testimonial_category_id'];
		}
		return $testimonial_category_data;
	}

	public function getTestimonialFilters($testimonial_id) {
		$testimonial_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_filter WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_filter_data[] = $result['filter_id'];
		}

		return $testimonial_filter_data;
	}

	
	public function getTestimonialImages($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_image WHERE testimonial_id = '" . (int)$testimonial_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTestimonialDiscounts($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_discount WHERE testimonial_id = '" . (int)$testimonial_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getTestimonialSpecials($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_special WHERE testimonial_id = '" . (int)$testimonial_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getTestimonialRewards($testimonial_id) {
		$testimonial_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_reward WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $testimonial_reward_data;
	}

	public function getTestimonialStores($testimonial_id) {
		$testimonial_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_to_store WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_store_data[] = $result['store_id'];
		}

		return $testimonial_store_data;
	}
	
	public function getTestimonialSeoUrls($testimonial_id) {
		$testimonial_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'testimonial_id=" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $testimonial_seo_url_data;
	}
	
	public function getTestimonialLayouts($testimonial_id) {
		$testimonial_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_to_layout WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		foreach ($query->rows  as $result) {
			$testimonial_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $testimonial_layout_data;
	}


	public function getTotalTestimonials($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.testimonial_id) AS total FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);
		$result = $query->row;
		return $result['total'];
	}


	public function getTotalTestimonialsByLayoutId($layout_id) {
		return $this->db->where('layout_id', (int)$layout_id)->count_all('testimonial_to_layout');
	}
}
