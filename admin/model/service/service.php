<?php
class ModelServiceService extends Model {
	public function addService($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "service SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");

		$service_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "service SET image = '" . $this->db->escape($data['image']) . "' WHERE service_id = '" . (int)$service_id . "'");
		}

		foreach ($data['service_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "service_description SET service_id = '" . (int)$service_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['service_store'])) {
			foreach ($data['service_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['service_image'])) {
			foreach ($data['service_image'] as $service_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_image SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape($service_image['image']) . "', sort_order = '" . (int)$service_image['sort_order'] . "'");
			}
		}

		

		if (isset($data['service_category'])) {
			foreach ($data['service_category'] as $service_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_category SET service_id = '" . (int)$service_id . "', service_category_id = '" . (int)$service_category_id . "'");
			}
		}

		

		// SEO URL
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'service_id=" . (int)$service_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		
		if (isset($data['service_layout'])) {
			foreach ($data['service_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_layout SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}


		$this->cache->delete('post_type','service');

		return $service_id;
	}

	public function editService($service_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "service SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "service SET image = '" . $this->db->escape($data['image']) . "' WHERE service_id = '" . (int)$service_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_description WHERE service_id = '" . (int)$service_id . "'");

		foreach ($data['service_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "service_description SET service_id = '" . (int)$service_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_store WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_store'])) {
			foreach ($data['service_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_image'])) {
			foreach ($data['service_image'] as $service_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_image SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape($service_image['image']) . "', sort_order = '" . (int)$service_image['sort_order'] . "'");
			}
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_category WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_category'])) {
			foreach ($data['service_category'] as $service_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_category SET service_id = '" . (int)$service_id . "', service_category_id = '" . (int)$service_category_id . "'");
			}
		}

		// SEO URL
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "'");
		
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'service_id=" . (int)$service_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "'");

		if (isset($data['service_layout'])) {
			foreach ($data['service_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_layout SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('post_type','service');
	}

	public function copyService($service_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "service p WHERE p.service_id = '" . (int)$service_id . "'");

		if ($query->row) {
			$data = $query->row;

			$data['service_description'] = $this->getServiceDescriptions($service_id);
			$data['service_image'] = $this->getServiceImages($service_id);
			
			$data['service_category'] = $this->getServiceCategories($service_id);
			$data['service_layout'] = $this->getServiceLayouts($service_id);
			$data['service_store'] = $this->getServiceStores($service_id);

			$this->addService($data);
		}
	}

	public function deleteService($service_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "service WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_description WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "'");
	
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_category WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_store WHERE service_id = '" . (int)$service_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "'");
		

		$this->cache->delete('post_type','service');
	}

	public function getService($service_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "') AS keyword FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.service_id = '" . (int)$service_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getServices($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.service_id";

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

	public function getServicesByCategoryId($service_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) LEFT JOIN " . DB_PREFIX . "service_to_category p2c ON (p.service_id = p2c.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.service_category_id = '" . (int)$service_category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getServiceDescriptions($service_id) {
		$service_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_description WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $service_description_data;
	}

	public function getServiceCategories($service_id) {
		$service_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_category WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_category_data[] = $result['service_category_id'];
		}

		return $service_category_data;
	}

	public function getServiceFilters($service_id) {
		$service_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_filter WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_filter_data[] = $result['filter_id'];
		}

		return $service_filter_data;
	}

	
	public function getServiceImages($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getServiceDiscounts($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_discount WHERE service_id = '" . (int)$service_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getServiceSpecials($service_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_special WHERE service_id = '" . (int)$service_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getServiceRewards($service_id) {
		$service_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_reward WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $service_reward_data;
	}

	public function getServiceStores($service_id) {
		$service_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_store WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_store_data[] = $result['store_id'];
		}

		return $service_store_data;
	}
	
	public function getServiceSeoUrls($service_id) {
		$service_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'service_id=" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $service_seo_url_data;
	}
	
	public function getServiceLayouts($service_id) {
		$service_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "'");

		foreach ($query->rows  as $result) {
			$service_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $service_layout_data;
	}


	public function getTotalServices($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.service_id) AS total FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id)";

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


	public function getTotalServicesByLayoutId($layout_id) {
		return $this->db->where('layout_id', (int)$layout_id)->count_all('service_to_layout');
	}
}
