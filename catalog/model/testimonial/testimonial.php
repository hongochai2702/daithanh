<?php
class ModelTestimonialTestimonial extends Model {
	public function updateViewed($testimonial_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET viewed = (viewed + 1) WHERE testimonial_id = '" . (int)$testimonial_id . "'");
	}

	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, p.sort_order FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE p.testimonial_id = '" . (int)$testimonial_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'testimonial_id'       => $query->row['testimonial_id'],
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

	public function getTestimonials($data = array()) {
		$sql = "SELECT p.testimonial_id";

		if (!empty($data['filter_testimonial_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "testimonial_category_path cp LEFT JOIN " . DB_PREFIX . "testimonial_to_category p2c ON (cp.testimonial_category_id = p2c.testimonial_category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "testimonial_to_category p2c";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "testimonial p ON (p2c.testimonial_id = p.testimonial_id)";
			
		} else {
			$sql .= " FROM " . DB_PREFIX . "testimonial p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_testimonial_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_testimonial_category_id'] . "'";
			} else {
				$sql .= " AND p2c.testimonial_category_id = '" . (int)$data['filter_testimonial_category_id'] . "'";
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

		$sql .= " GROUP BY p.testimonial_id";

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

		$testimonial_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$testimonial_data[$result['testimonial_id']] = $this->getTestimonial($result['testimonial_id']);
		}

		return $testimonial_data;
	}

	public function getTestimonialSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.testimonial_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.testimonial_id = ps.testimonial_id AND r1.status = '1' GROUP BY r1.testimonial_id) AS rating FROM " . DB_PREFIX . "testimonial_special ps LEFT JOIN " . DB_PREFIX . "testimonial p ON (ps.testimonial_id = p.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.testimonial_id";

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

		$testimonial_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$testimonial_data[$result['testimonial_id']] = $this->getTestimonial($result['testimonial_id']);
		}

		return $testimonial_data;
	}

	public function getLatestTestimonials($limit) {
		$testimonial_data = $this->cache->get('testimonial.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$testimonial_data) {
			$query = $this->db->query("SELECT p.testimonial_id FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$testimonial_data[$result['testimonial_id']] = $this->getTestimonial($result['testimonial_id']);
			}

			$this->cache->set('testimonial.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $testimonial_data);
		}

		return $testimonial_data;
	}

	public function getPopularTestimonials($limit) {
		$testimonial_data = $this->cache->get('testimonial.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
	
		if (!$testimonial_data) {
			$query = $this->db->query("SELECT p.testimonial_id FROM " . DB_PREFIX . "testimonial p LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
	
			foreach ($query->rows as $result) {
				$testimonial_data[$result['testimonial_id']] = $this->getTestimonial($result['testimonial_id']);
			}
			
			$this->cache->set('testimonial.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $testimonial_data);
		}
		
		return $testimonial_data;
	}

	public function getBestSellerTestimonials($limit) {
		$testimonial_data = $this->cache->get('testimonial.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$testimonial_data) {
			$testimonial_data = array();

			$query = $this->db->query("SELECT op.testimonial_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_testimonial op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "testimonial` p ON (op.testimonial_id = p.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.testimonial_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$testimonial_data[$result['testimonial_id']] = $this->getTestimonial($result['testimonial_id']);
			}

			$this->cache->set('testimonial.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $testimonial_data);
		}

		return $testimonial_data;
	}

	public function getTestimonialAttributes($testimonial_id) {
		$testimonial_attribute_group_data = array();

		$testimonial_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "testimonial_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.testimonial_id = '" . (int)$testimonial_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($testimonial_attribute_group_query->rows as $testimonial_attribute_group) {
			$testimonial_attribute_data = array();

			$testimonial_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "testimonial_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.testimonial_id = '" . (int)$testimonial_id . "' AND a.attribute_group_id = '" . (int)$testimonial_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($testimonial_attribute_query->rows as $testimonial_attribute) {
				$testimonial_attribute_data[] = array(
					'attribute_id' => $testimonial_attribute['attribute_id'],
					'name'         => $testimonial_attribute['name'],
					'text'         => $testimonial_attribute['text']
				);
			}

			$testimonial_attribute_group_data[] = array(
				'attribute_group_id' => $testimonial_attribute_group['attribute_group_id'],
				'name'               => $testimonial_attribute_group['name'],
				'attribute'          => $testimonial_attribute_data
			);
		}

		return $testimonial_attribute_group_data;
	}

	public function getTestimonialOptions($testimonial_id) {
		$testimonial_option_data = array();

		$testimonial_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.testimonial_id = '" . (int)$testimonial_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($testimonial_option_query->rows as $testimonial_option) {
			$testimonial_option_value_data = array();

			$testimonial_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.testimonial_id = '" . (int)$testimonial_id . "' AND pov.testimonial_option_id = '" . (int)$testimonial_option['testimonial_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($testimonial_option_value_query->rows as $testimonial_option_value) {
				$testimonial_option_value_data[] = array(
					'testimonial_option_value_id' => $testimonial_option_value['testimonial_option_value_id'],
					'option_value_id'         => $testimonial_option_value['option_value_id'],
					'name'                    => $testimonial_option_value['name'],
					'image'                   => $testimonial_option_value['image'],
					'quantity'                => $testimonial_option_value['quantity'],
					'subtract'                => $testimonial_option_value['subtract'],
					'price'                   => $testimonial_option_value['price'],
					'price_prefix'            => $testimonial_option_value['price_prefix'],
					'weight'                  => $testimonial_option_value['weight'],
					'weight_prefix'           => $testimonial_option_value['weight_prefix']
				);
			}

			$testimonial_option_data[] = array(
				'testimonial_option_id'    => $testimonial_option['testimonial_option_id'],
				'testimonial_option_value' => $testimonial_option_value_data,
				'option_id'            => $testimonial_option['option_id'],
				'name'                 => $testimonial_option['name'],
				'type'                 => $testimonial_option['type'],
				'value'                => $testimonial_option['value'],
				'required'             => $testimonial_option['required']
			);
		}

		return $testimonial_option_data;
	}

	public function getTestimonialDiscounts($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_discount WHERE testimonial_id = '" . (int)$testimonial_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getTestimonialImages($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_image WHERE testimonial_id = '" . (int)$testimonial_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTestimonialRelated($testimonial_id) {
		$testimonial_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_related pr LEFT JOIN " . DB_PREFIX . "testimonial p ON (pr.related_id = p.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE pr.testimonial_id = '" . (int)$testimonial_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$testimonial_data[$result['related_id']] = $this->getTestimonial($result['related_id']);
		}

		return $testimonial_data;
	}

	public function getTestimonialLayoutId($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_to_layout WHERE testimonial_id = '" . (int)$testimonial_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial_to_category WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		return $query->rows;
	}

	public function getTotalTestimonials($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.testimonial_id) AS total";

		if (!empty($data['filter_testimonial_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "testimonial_category_path cp LEFT JOIN " . DB_PREFIX . "testimonial_to_category p2c ON (cp.testimonial_category_id = p2c.testimonial_category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "testimonial_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "testimonial_filter pf ON (p2c.testimonial_id = pf.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial p ON (pf.testimonial_id = p.testimonial_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "testimonial p ON (p2c.testimonial_id = p.testimonial_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "testimonial p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "testimonial_description pd ON (p.testimonial_id = pd.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_testimonial_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_testimonial_category_id'] . "'";
			} else {
				$sql .= " AND p2c.testimonial_category_id = '" . (int)$data['filter_testimonial_category_id'] . "'";
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

	public function getProfile($testimonial_id, $recurring_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "testimonial_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.testimonial_id = '" . (int)$testimonial_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

		return $query->row;
	}

	public function getProfiles($testimonial_id) {
		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "testimonial_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.testimonial_id = " . (int)$testimonial_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTotalTestimonialSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.testimonial_id) AS total FROM " . DB_PREFIX . "testimonial_special ps LEFT JOIN " . DB_PREFIX . "testimonial p ON (ps.testimonial_id = p.testimonial_id) LEFT JOIN " . DB_PREFIX . "testimonial_to_store p2s ON (p.testimonial_id = p2s.testimonial_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
