<?php
class ModelBlogsBlogs extends Model {
	public function addBlogs($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blogs SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', position = '" . $this->db->escape($data['position']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");

		$blogs_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs SET image = '" . $this->db->escape($data['image']) . "' WHERE blogs_id = '" . (int)$blogs_id . "'");
		}

		foreach ($data['blogs_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_description SET blogs_id = '" . (int)$blogs_id . "', language_id = '" . (int)$language_id .  "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");

		}

		if (isset($data['blogs_store'])) {
			foreach ($data['blogs_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_to_store SET blogs_id = '" . (int)$blogs_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['blogs_image'])) {
			foreach ($data['blogs_image'] as $blogs_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_image SET blogs_id = '" . (int)$blogs_id . "', image = '" . $this->db->escape($blogs_image['image']) . "', sort_order = '" . (int)$blogs_image['sort_order'] . "'");
			}
		}

		

		if (isset($data['blogs_category'])) {
			foreach ($data['blogs_category'] as $blogs_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_to_category SET blogs_id = '" . (int)$blogs_id . "', blogs_category_id = '" . (int)$blogs_category_id . "'");
			}
		}

		

		// SEO URL
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blogs_id=" . (int)$blogs_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		
		if (isset($data['blogs_layout'])) {
			foreach ($data['blogs_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_to_layout SET blogs_id = '" . (int)$blogs_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}


		$this->cache->delete('post_type','blogs');

		return $blogs_id;
	}

	public function editBlogs($blogs_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blogs SET date_available = '" . $this->db->escape($data['date_available']) . "', status = '" . (int)$data['status'] . "', position = '" . $this->db->escape($data['position']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE blogs_id = '" . (int)$blogs_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs SET image = '" . $this->db->escape($data['image']) . "' WHERE blogs_id = '" . (int)$blogs_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_description WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($data['blogs_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_description SET blogs_id = '" . (int)$blogs_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_store WHERE blogs_id = '" . (int)$blogs_id . "'");

		if (isset($data['blogs_store'])) {
			foreach ($data['blogs_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_to_store SET blogs_id = '" . (int)$blogs_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_image WHERE blogs_id = '" . (int)$blogs_id . "'");

		if (isset($data['blogs_image'])) {
			foreach ($data['blogs_image'] as $blogs_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_image SET blogs_id = '" . (int)$blogs_id . "', image = '" . $this->db->escape($blogs_image['image']) . "', sort_order = '" . (int)$blogs_image['sort_order'] . "'");
			}
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_category WHERE blogs_id = '" . (int)$blogs_id . "'");

		if (isset($data['blogs_category'])) {
			foreach ($data['blogs_category'] as $blogs_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_to_category SET blogs_id = '" . (int)$blogs_id . "', blogs_category_id = '" . (int)$blogs_category_id . "'");
			}
		}

		// SEO URL
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_id=" . (int)$blogs_id . "'");
		
		if (isset($data['keyword'])) {
			if (!empty($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blogs_id=" . (int)$blogs_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_layout WHERE blogs_id = '" . (int)$blogs_id . "'");

		if (isset($data['blogs_layout'])) {
			foreach ($data['blogs_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_to_layout SET blogs_id = '" . (int)$blogs_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('post_type','blogs');
	}

	public function copyBlogs($blogs_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blogs p WHERE p.blogs_id = '" . (int)$blogs_id . "'");

		if ($query->row) {
			$data = $query->row;

			$data['blogs_description'] = $this->getBlogsDescriptions($blogs_id);
			$data['blogs_image'] = $this->getBlogsImages($blogs_id);
			
			$data['blogs_category'] = $this->getBlogsCategories($blogs_id);
			$data['blogs_layout'] = $this->getBlogsLayouts($blogs_id);
			$data['blogs_store'] = $this->getBlogsStores($blogs_id);
			$this->addBlogs($data);
		}
	}

	public function deleteBlogs($blogs_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs WHERE blogs_id = '" . (int)$blogs_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_description WHERE blogs_id = '" . (int)$blogs_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_image WHERE blogs_id = '" . (int)$blogs_id . "'");
	
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_category WHERE blogs_id = '" . (int)$blogs_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_layout WHERE blogs_id = '" . (int)$blogs_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_store WHERE blogs_id = '" . (int)$blogs_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_id=" . (int)$blogs_id . "'");
		

		$this->cache->delete('post_type','blogs');
	}

	public function getBlogs($blogs_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_id=" . (int)$blogs_id . "') AS keyword FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) WHERE p.blogs_id = '" . (int)$blogs_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getBlogss($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.blogs_id";

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

	public function getBlogssByCategoryId($blogs_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_category p2c ON (p.blogs_id = p2c.blogs_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.blogs_category_id = '" . (int)$blogs_category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getBlogsDescriptions($blogs_id) {
		$blogs_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_description WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'position'         => $result['position'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $blogs_description_data;
	}

	public function getBlogsCategories($blogs_id) {
		$blogs_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_to_category WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_category_data[] = $result['blogs_category_id'];
		}
		return $blogs_category_data;
	}

	public function getBlogsFilters($blogs_id) {
		$blogs_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_filter WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_filter_data[] = $result['filter_id'];
		}

		return $blogs_filter_data;
	}

	
	public function getBlogsImages($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_image WHERE blogs_id = '" . (int)$blogs_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getBlogsDiscounts($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_discount WHERE blogs_id = '" . (int)$blogs_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getBlogsSpecials($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_special WHERE blogs_id = '" . (int)$blogs_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getBlogsRewards($blogs_id) {
		$blogs_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_reward WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $blogs_reward_data;
	}

	public function getBlogsStores($blogs_id) {
		$blogs_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_to_store WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_store_data[] = $result['store_id'];
		}

		return $blogs_store_data;
	}
	
	public function getBlogsSeoUrls($blogs_id) {
		$blogs_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'blogs_id=" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $blogs_seo_url_data;
	}
	
	public function getBlogsLayouts($blogs_id) {
		$blogs_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_to_layout WHERE blogs_id = '" . (int)$blogs_id . "'");

		foreach ($query->rows  as $result) {
			$blogs_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $blogs_layout_data;
	}


	public function getTotalBlogss($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.blogs_id) AS total FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id)";

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


	public function getTotalBlogssByLayoutId($layout_id) {
		return $this->db->where('layout_id', (int)$layout_id)->count_all('blogs_to_layout');
	}
}
