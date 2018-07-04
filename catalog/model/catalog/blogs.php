<?php
class ModelCatalogBlogs extends Model {
	public function updateViewed($blogs_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "blogs SET viewed = (viewed + 1) WHERE blogs_id = '" . (int)$blogs_id . "'");
	}

	public function getBlogs($blogs_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, p.sort_order FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE p.blogs_id = '" . (int)$blogs_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'blogs_id'       => $query->row['blogs_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'position'      => $query->row['position'],
				'social_meta'      => json_decode($query->row['social_meta']),
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'image'            => $query->row['image'],
				'date_available'   => $query->row['date_available'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}

	public function getBlogss($data = array()) {
		$sql = "SELECT p.blogs_id";

		if (!empty($data['filter_blogs_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "blogs_category_path cp LEFT JOIN " . DB_PREFIX . "blogs_to_category p2c ON (cp.blogs_category_id = p2c.blogs_category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "blogs_to_category p2c";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "blogs p ON (p2c.blogs_id = p.blogs_id)";
			
		} else {
			$sql .= " FROM " . DB_PREFIX . "blogs p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_blogs_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_blogs_category_id'] . "'";
			} else {
				$sql .= " AND p2c.blogs_category_id = '" . (int)$data['filter_blogs_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			$sql .= ")";
		}

		$sql .= " GROUP BY p.blogs_id";

		$sort_data = array(
			'pd.name',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$blogs_data = array();

		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$blogs_data[$result['blogs_id']] = $this->getBlogs($result['blogs_id']);
		}

		return $blogs_data;
	}

	public function getBlogsSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.blogs_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.blogs_id = ps.blogs_id AND r1.status = '1' GROUP BY r1.blogs_id) AS rating FROM " . DB_PREFIX . "blogs_special ps LEFT JOIN " . DB_PREFIX . "blogs p ON (ps.blogs_id = p.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.blogs_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$blogs_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$blogs_data[$result['blogs_id']] = $this->getBlogs($result['blogs_id']);
		}

		return $blogs_data;
	}

	public function getLatestBlogss($limit) {
		$blogs_data = $this->cache->get('blogs.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$blogs_data) {
			$query = $this->db->query("SELECT p.blogs_id FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$blogs_data[$result['blogs_id']] = $this->getBlogs($result['blogs_id']);
			}

			$this->cache->set('blogs.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $blogs_data);
		}

		return $blogs_data;
	}

	public function getPopularBlogss($limit) {
		$blogs_data = $this->cache->get('blogs.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
	
		if (!$blogs_data) {
			$query = $this->db->query("SELECT p.blogs_id FROM " . DB_PREFIX . "blogs p LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
	
			foreach ($query->rows as $result) {
				$blogs_data[$result['blogs_id']] = $this->getBlogs($result['blogs_id']);
			}
			
			$this->cache->set('blogs.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $blogs_data);
		}
		
		return $blogs_data;
	}

	public function getBestSellerBlogss($limit) {
		$blogs_data = $this->cache->get('blogs.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$blogs_data) {
			$blogs_data = array();

			$query = $this->db->query("SELECT op.blogs_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_blogs op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "blogs` p ON (op.blogs_id = p.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.blogs_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$blogs_data[$result['blogs_id']] = $this->getBlogs($result['blogs_id']);
			}

			$this->cache->set('blogs.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $blogs_data);
		}

		return $blogs_data;
	}

	public function getBlogsAttributes($blogs_id) {
		$blogs_attribute_group_data = array();

		$blogs_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "blogs_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.blogs_id = '" . (int)$blogs_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($blogs_attribute_group_query->rows as $blogs_attribute_group) {
			$blogs_attribute_data = array();

			$blogs_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "blogs_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.blogs_id = '" . (int)$blogs_id . "' AND a.attribute_group_id = '" . (int)$blogs_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($blogs_attribute_query->rows as $blogs_attribute) {
				$blogs_attribute_data[] = array(
					'attribute_id' => $blogs_attribute['attribute_id'],
					'name'         => $blogs_attribute['name'],
					'text'         => $blogs_attribute['text']
				);
			}

			$blogs_attribute_group_data[] = array(
				'attribute_group_id' => $blogs_attribute_group['attribute_group_id'],
				'name'               => $blogs_attribute_group['name'],
				'attribute'          => $blogs_attribute_data
			);
		}

		return $blogs_attribute_group_data;
	}

	public function getBlogsOptions($blogs_id) {
		$blogs_option_data = array();

		$blogs_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.blogs_id = '" . (int)$blogs_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($blogs_option_query->rows as $blogs_option) {
			$blogs_option_value_data = array();

			$blogs_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.blogs_id = '" . (int)$blogs_id . "' AND pov.blogs_option_id = '" . (int)$blogs_option['blogs_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($blogs_option_value_query->rows as $blogs_option_value) {
				$blogs_option_value_data[] = array(
					'blogs_option_value_id' => $blogs_option_value['blogs_option_value_id'],
					'option_value_id'         => $blogs_option_value['option_value_id'],
					'name'                    => $blogs_option_value['name'],
					'image'                   => $blogs_option_value['image'],
					'quantity'                => $blogs_option_value['quantity'],
					'subtract'                => $blogs_option_value['subtract'],
					'price'                   => $blogs_option_value['price'],
					'price_prefix'            => $blogs_option_value['price_prefix'],
					'weight'                  => $blogs_option_value['weight'],
					'weight_prefix'           => $blogs_option_value['weight_prefix']
				);
			}

			$blogs_option_data[] = array(
				'blogs_option_id'    => $blogs_option['blogs_option_id'],
				'blogs_option_value' => $blogs_option_value_data,
				'option_id'            => $blogs_option['option_id'],
				'name'                 => $blogs_option['name'],
				'type'                 => $blogs_option['type'],
				'value'                => $blogs_option['value'],
				'required'             => $blogs_option['required']
			);
		}

		return $blogs_option_data;
	}

	public function getBlogsDiscounts($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_discount WHERE blogs_id = '" . (int)$blogs_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getBlogsImages($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_image WHERE blogs_id = '" . (int)$blogs_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getBlogsRelated($blogs_id) {
		$blogs_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_related pr LEFT JOIN " . DB_PREFIX . "blogs p ON (pr.related_id = p.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE pr.blogs_id = '" . (int)$blogs_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$blogs_data[$result['related_id']] = $this->getBlogs($result['related_id']);
		}

		return $blogs_data;
	}

	public function getBlogsLayoutId($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_to_layout WHERE blogs_id = '" . (int)$blogs_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($blogs_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_to_category WHERE blogs_id = '" . (int)$blogs_id . "'");

		return $query->rows;
	}

	public function getTotalBlogss($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.blogs_id) AS total";

		if (!empty($data['filter_blogs_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "blogs_category_path cp LEFT JOIN " . DB_PREFIX . "blogs_to_category p2c ON (cp.blogs_category_id = p2c.blogs_category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "blogs_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blogs_filter pf ON (p2c.blogs_id = pf.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs p ON (pf.blogs_id = p.blogs_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blogs p ON (p2c.blogs_id = p.blogs_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "blogs p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "blogs_description pd ON (p.blogs_id = pd.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_blogs_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_blogs_category_id'] . "'";
			} else {
				$sql .= " AND p2c.blogs_category_id = '" . (int)$data['filter_blogs_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProfile($blogs_id, $recurring_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "blogs_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.blogs_id = '" . (int)$blogs_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

		return $query->row;
	}

	public function getProfiles($blogs_id) {
		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "blogs_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.blogs_id = " . (int)$blogs_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTotalBlogsSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.blogs_id) AS total FROM " . DB_PREFIX . "blogs_special ps LEFT JOIN " . DB_PREFIX . "blogs p ON (ps.blogs_id = p.blogs_id) LEFT JOIN " . DB_PREFIX . "blogs_to_store p2s ON (p.blogs_id = p2s.blogs_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
