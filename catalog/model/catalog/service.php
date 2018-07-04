<?php

class ModelCatalogService extends Model {

	public function updateViewed($service_id) {

		$this->db->query("UPDATE " . DB_PREFIX . "service SET viewed = (viewed + 1) WHERE service_id = '" . (int)$service_id . "'");

	}



	public function getService($service_id) {

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturersev, (SELECT price FROM " . DB_PREFIX . "service_discount pd2 WHERE pd2.service_id = p.service_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "service_special ps WHERE ps.service_id = p.service_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "service_reward pr WHERE pr.service_id = p.service_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "reviewsev r1 WHERE r1.service_id = p.service_id AND r1.status = '1' GROUP BY r1.service_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "reviewsev r2 WHERE r2.service_id = p.service_id AND r2.status = '1' GROUP BY r2.service_id) AS reviewsevs, p.sort_order FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) LEFT JOIN " . DB_PREFIX . "manufacturersev m ON (p.manufacturersev_id = m.manufacturersev_id) WHERE p.service_id = '" . (int)$service_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");



		if ($query->num_rows) {

			return array(

				'service_id'       => $query->row['service_id'],

				'name'             => $query->row['name'],

				'description'      => $query->row['description'],

				'meta_title'       => $query->row['meta_title'],

				'meta_description' => $query->row['meta_description'],

				'meta_keyword'     => $query->row['meta_keyword'],

				'tag'              => $query->row['tag'],

				'model'            => $query->row['model'],

				'sku'              => $query->row['sku'],

				'upc'              => $query->row['upc'],

				'ean'              => $query->row['ean'],

				'jan'              => $query->row['jan'],

				'isbn'             => $query->row['isbn'],

				'mpn'              => $query->row['mpn'],

				'location'         => $query->row['location'],

				'quantity'         => $query->row['quantity'],

				'stock_status'     => $query->row['stock_status'],

				'image'            => $query->row['image'],

				'manufacturersev_id'  => $query->row['manufacturersev_id'],

				'manufacturersev'     => $query->row['manufacturersev'],

				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),

				'special'          => $query->row['special'],

				'reward'           => $query->row['reward'],

				'points'           => $query->row['points'],

				'tax_class_id'     => $query->row['tax_class_id'],

				'date_available'   => $query->row['date_available'],

				'weight'           => $query->row['weight'],

				'weight_class_id'  => $query->row['weight_class_id'],

				'length'           => $query->row['length'],

				'width'            => $query->row['width'],

				'height'           => $query->row['height'],

				'length_class_id'  => $query->row['length_class_id'],

				'subtract'         => $query->row['subtract'],

				'rating'           => round($query->row['rating']),

				'reviewsevs'          => $query->row['reviewsevs'] ? $query->row['reviewsevs'] : 0,

				'minimum'          => $query->row['minimum'],

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



	public function getServices($data = array()) {

		$sql = "SELECT p.service_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "reviewsev r1 WHERE r1.service_id = p.service_id AND r1.status = '1' GROUP BY r1.service_id) AS rating, (SELECT price FROM " . DB_PREFIX . "service_discount pd2 WHERE pd2.service_id = p.service_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "service_special ps WHERE ps.service_id = p.service_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";



		if (!empty($data['filter_categorysev_id'])) {

			if (!empty($data['filter_sub_categorysev'])) {

				$sql .= " FROM " . DB_PREFIX . "categorysev_pathsev cp LEFT JOIN " . DB_PREFIX . "service_to_categorysev p2c ON (cp.categorysev_id = p2c.categorysev_id)";

			} else {

				$sql .= " FROM " . DB_PREFIX . "service_to_categorysev p2c";

			}



			if (!empty($data['filter_filter'])) {

				$sql .= " LEFT JOIN " . DB_PREFIX . "service_filter pf ON (p2c.service_id = pf.service_id) LEFT JOIN " . DB_PREFIX . "service p ON (pf.service_id = p.service_id)";

			} else {

				$sql .= " LEFT JOIN " . DB_PREFIX . "service p ON (p2c.service_id = p.service_id)";

			}

		} else {

			$sql .= " FROM " . DB_PREFIX . "service p";

		}



		$sql .= " LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";



		if (!empty($data['filter_categorysev_id'])) {

			if (!empty($data['filter_sub_categorysev'])) {

				$sql .= " AND cp.pathsev_id = '" . (int)$data['filter_categorysev_id'] . "'";

			} else {

				$sql .= " AND p2c.categorysev_id = '" . (int)$data['filter_categorysev_id'] . "'";

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



		if (!empty($data['filter_manufacturersev_id'])) {

			$sql .= " AND p.manufacturersev_id = '" . (int)$data['filter_manufacturersev_id'] . "'";

		}



		$sql .= " GROUP BY p.service_id";



		$sort_data = array(

			'pd.name',

			'p.model',

			'p.quantity',

			'p.price',

			'rating',

			'p.sort_order',

			'p.date_added'

		);



		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {

			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {

				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";

			} elseif ($data['sort'] == 'p.price') {

				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";

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



		$service_data = array();



		$query = $this->db->query($sql);



		foreach ($query->rows as $result) {

			$service_data[$result['service_id']] = $this->getService($result['service_id']);

		}



		return $service_data;

	}



	public function getServiceSpecials($data = array()) {

		$sql = "SELECT DISTINCT ps.service_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "reviewsev r1 WHERE r1.service_id = ps.service_id AND r1.status = '1' GROUP BY r1.service_id) AS rating FROM " . DB_PREFIX . "service_special ps LEFT JOIN " . DB_PREFIX . "service p ON (ps.service_id = p.service_id) LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.service_id";



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



		$service_data = array();



		$query = $this->db->query($sql);



		foreach ($query->rows as $result) {

			$service_data[$result['service_id']] = $this->getService($result['service_id']);

		}



		return $service_data;

	}



	public function getLatestServices($limit) {

		$service_data = $this->cache->get('service.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);



		if (!$service_data) {

			$query = $this->db->query("SELECT p.service_id FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);



			foreach ($query->rows as $result) {

				$service_data[$result['service_id']] = $this->getService($result['service_id']);

			}



			$this->cache->set('service.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $service_data);

		}



		return $service_data;

	}



	public function getPopularServices($limit) {

		$service_data = $this->cache->get('service.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

	

		if (!$service_data) {

			$query = $this->db->query("SELECT p.service_id FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

	

			foreach ($query->rows as $result) {

				$service_data[$result['service_id']] = $this->getService($result['service_id']);

			}

			

			$this->cache->set('service.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $service_data);

		}

		

		return $service_data;

	}



	public function getBestSellerServices($limit) {

		$service_data = $this->cache->get('service.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);



		if (!$service_data) {

			$service_data = array();



			$query = $this->db->query("SELECT op.service_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_service op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "service` p ON (op.service_id = p.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.service_id ORDER BY total DESC LIMIT " . (int)$limit);



			foreach ($query->rows as $result) {

				$service_data[$result['service_id']] = $this->getService($result['service_id']);

			}



			$this->cache->set('service.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $service_data);

		}



		return $service_data;

	}



	public function getServiceAttributes($service_id) {

		$service_attributesev_group_data = array();



		$service_attributesev_group_query = $this->db->query("SELECT ag.attributesev_group_id, agd.name FROM " . DB_PREFIX . "service_attributesev pa LEFT JOIN " . DB_PREFIX . "attributesev a ON (pa.attributesev_id = a.attributesev_id) LEFT JOIN " . DB_PREFIX . "attributesev_group ag ON (a.attributesev_group_id = ag.attributesev_group_id) LEFT JOIN " . DB_PREFIX . "attributesev_group_description agd ON (ag.attributesev_group_id = agd.attributesev_group_id) WHERE pa.service_id = '" . (int)$service_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attributesev_group_id ORDER BY ag.sort_order, agd.name");



		foreach ($service_attributesev_group_query->rows as $service_attributesev_group) {

			$service_attributesev_data = array();



			$service_attributesev_query = $this->db->query("SELECT a.attributesev_id, ad.name, pa.text FROM " . DB_PREFIX . "service_attributesev pa LEFT JOIN " . DB_PREFIX . "attributesev a ON (pa.attributesev_id = a.attributesev_id) LEFT JOIN " . DB_PREFIX . "attributesev_description ad ON (a.attributesev_id = ad.attributesev_id) WHERE pa.service_id = '" . (int)$service_id . "' AND a.attributesev_group_id = '" . (int)$service_attributesev_group['attributesev_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");



			foreach ($service_attributesev_query->rows as $service_attributesev) {

				$service_attributesev_data[] = array(

					'attributesev_id' => $service_attributesev['attributesev_id'],

					'name'         => $service_attributesev['name'],

					'text'         => $service_attributesev['text']

				);

			}



			$service_attributesev_group_data[] = array(

				'attributesev_group_id' => $service_attributesev_group['attributesev_group_id'],

				'name'               => $service_attributesev_group['name'],

				'attributesev'          => $service_attributesev_data

			);

		}



		return $service_attributesev_group_data;

	}



	public function getServiceOptions($service_id) {

		$service_optionsev_data = array();



		$service_optionsev_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_optionsev po LEFT JOIN `" . DB_PREFIX . "optionsev` o ON (po.optionsev_id = o.optionsev_id) LEFT JOIN " . DB_PREFIX . "optionsev_description od ON (o.optionsev_id = od.optionsev_id) WHERE po.service_id = '" . (int)$service_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");



		foreach ($service_optionsev_query->rows as $service_optionsev) {

			$service_optionsev_value_data = array();



			$service_optionsev_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_optionsev_value pov LEFT JOIN " . DB_PREFIX . "optionsev_value ov ON (pov.optionsev_value_id = ov.optionsev_value_id) LEFT JOIN " . DB_PREFIX . "optionsev_value_description ovd ON (ov.optionsev_value_id = ovd.optionsev_value_id) WHERE pov.service_id = '" . (int)$service_id . "' AND pov.service_optionsev_id = '" . (int)$service_optionsev['service_optionsev_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");



			foreach ($service_optionsev_value_query->rows as $service_optionsev_value) {

				$service_optionsev_value_data[] = array(

					'service_optionsev_value_id' => $service_optionsev_value['service_optionsev_value_id'],

					'optionsev_value_id'         => $service_optionsev_value['optionsev_value_id'],

					'name'                    => $service_optionsev_value['name'],

					'image'                   => $service_optionsev_value['image'],

					'quantity'                => $service_optionsev_value['quantity'],

					'subtract'                => $service_optionsev_value['subtract'],

					'price'                   => $service_optionsev_value['price'],

					'price_prefix'            => $service_optionsev_value['price_prefix'],

					'weight'                  => $service_optionsev_value['weight'],

					'weight_prefix'           => $service_optionsev_value['weight_prefix']

				);

			}



			$service_optionsev_data[] = array(

				'service_optionsev_id'    => $service_optionsev['service_optionsev_id'],

				'service_optionsev_value' => $service_optionsev_value_data,

				'optionsev_id'            => $service_optionsev['optionsev_id'],

				'name'                 => $service_optionsev['name'],

				'type'                 => $service_optionsev['type'],

				'value'                => $service_optionsev['value'],

				'required'             => $service_optionsev['required']

			);

		}



		return $service_optionsev_data;

	}



	public function getServiceDiscounts($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_discount WHERE service_id = '" . (int)$service_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");



		return $query->rows;

	}



	public function getServiceImages($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "' ORDER BY sort_order ASC");



		return $query->rows;

	}



	public function getServiceRelated($service_id) {

		$service_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_related pr LEFT JOIN " . DB_PREFIX . "service p ON (pr.related_id = p.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE pr.service_id = '" . (int)$service_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");



		foreach ($query->rows as $result) {

			$service_data[$result['related_id']] = $this->getService($result['related_id']);

		}



		return $service_data;

	}



	public function getServiceLayoutId($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");



		if ($query->num_rows) {

			return $query->row['layout_id'];

		} else {

			return 0;

		}

	}



	public function getCategories($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_categorysev WHERE service_id = '" . (int)$service_id . "'");



		return $query->rows;

	}



	public function getTotalServices($data = array()) {

		$sql = "SELECT COUNT(DISTINCT p.service_id) AS total";



		if (!empty($data['filter_categorysev_id'])) {

			if (!empty($data['filter_sub_categorysev'])) {

				$sql .= " FROM " . DB_PREFIX . "categorysev_pathsev cp LEFT JOIN " . DB_PREFIX . "service_to_categorysev p2c ON (cp.categorysev_id = p2c.categorysev_id)";

			} else {

				$sql .= " FROM " . DB_PREFIX . "service_to_categorysev p2c";

			}



			if (!empty($data['filter_filter'])) {

				$sql .= " LEFT JOIN " . DB_PREFIX . "service_filter pf ON (p2c.service_id = pf.service_id) LEFT JOIN " . DB_PREFIX . "service p ON (pf.service_id = p.service_id)";

			} else {

				$sql .= " LEFT JOIN " . DB_PREFIX . "service p ON (p2c.service_id = p.service_id)";

			}

		} else {

			$sql .= " FROM " . DB_PREFIX . "service p";

		}



		$sql .= " LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";



		if (!empty($data['filter_categorysev_id'])) {

			if (!empty($data['filter_sub_categorysev'])) {

				$sql .= " AND cp.pathsev_id = '" . (int)$data['filter_categorysev_id'] . "'";

			} else {

				$sql .= " AND p2c.categorysev_id = '" . (int)$data['filter_categorysev_id'] . "'";

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



		if (!empty($data['filter_manufacturersev_id'])) {

			$sql .= " AND p.manufacturersev_id = '" . (int)$data['filter_manufacturersev_id'] . "'";

		}



		$query = $this->db->query($sql);



		return $query->row['total'];

	}



	public function getProfile($service_id, $recurring_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "service_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.service_id = '" . (int)$service_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");



		return $query->row;

	}



	public function getProfiles($service_id) {

		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "service_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.service_id = " . (int)$service_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");



		return $query->rows;

	}



	public function getTotalServiceSpecials() {

		$query = $this->db->query("SELECT COUNT(DISTINCT ps.service_id) AS total FROM " . DB_PREFIX . "service_special ps LEFT JOIN " . DB_PREFIX . "service p ON (ps.service_id = p.service_id) LEFT JOIN " . DB_PREFIX . "service_to_store p2s ON (p.service_id = p2s.service_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");



		if (isset($query->row['total'])) {

			return $query->row['total'];

		} else {

			return 0;

		}

	}

}

