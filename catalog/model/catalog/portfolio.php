<?php
class ModelCatalogPortfolio extends Model {
	public function updateViewed($portfolio_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "portfolio SET viewed = (viewed + 1) WHERE portfolio_id = '" . (int)$portfolio_id . "'");
	}

	public function getPortfolio($portfolio_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, p.sort_order FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE p.portfolio_id = '" . (int)$portfolio_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'portfolio_id'      => $query->row['portfolio_id'],
				'name'             	=> $query->row['name'],
				'short_description' => $query->row['short_description'],
				'description'      	=> $query->row['description'],
				'challenge_description' => $query->row['challenge_description'],
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

	public function getPortfolios($data = array()) {
		$sql = "SELECT p.portfolio_id";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "portfolio_category_path cp LEFT JOIN " . DB_PREFIX . "portfolio_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "portfolio_to_category p2c";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "portfolio p ON (p2c.portfolio_id = p.portfolio_id)";
			
		} else {
			$sql .= " FROM " . DB_PREFIX . "portfolio p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
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

		$sql .= " GROUP BY p.portfolio_id";

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

		$portfolio_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$portfolio_data[$result['portfolio_id']] = $this->getPortfolio($result['portfolio_id']);
		}

		return $portfolio_data;
	}

	public function getPortfolioSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.portfolio_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.portfolio_id = ps.portfolio_id AND r1.status = '1' GROUP BY r1.portfolio_id) AS rating FROM " . DB_PREFIX . "portfolio_special ps LEFT JOIN " . DB_PREFIX . "portfolio p ON (ps.portfolio_id = p.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.portfolio_id";

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

		$portfolio_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$portfolio_data[$result['portfolio_id']] = $this->getPortfolio($result['portfolio_id']);
		}

		return $portfolio_data;
	}

	public function getLatestPortfolios($limit) {
		$portfolio_data = $this->cache->get('portfolio.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$portfolio_data) {
			$query = $this->db->query("SELECT p.portfolio_id FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$portfolio_data[$result['portfolio_id']] = $this->getPortfolio($result['portfolio_id']);
			}

			$this->cache->set('portfolio.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $portfolio_data);
		}

		return $portfolio_data;
	}

	public function getPopularPortfolios($limit) {
		$portfolio_data = $this->cache->get('portfolio.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
	
		if (!$portfolio_data) {
			$query = $this->db->query("SELECT p.portfolio_id FROM " . DB_PREFIX . "portfolio p LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
	
			foreach ($query->rows as $result) {
				$portfolio_data[$result['portfolio_id']] = $this->getPortfolio($result['portfolio_id']);
			}
			
			$this->cache->set('portfolio.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $portfolio_data);
		}
		
		return $portfolio_data;
	}

	public function getBestSellerPortfolios($limit) {
		$portfolio_data = $this->cache->get('portfolio.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$portfolio_data) {
			$portfolio_data = array();

			$query = $this->db->query("SELECT op.portfolio_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_portfolio op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "portfolio` p ON (op.portfolio_id = p.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.portfolio_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$portfolio_data[$result['portfolio_id']] = $this->getPortfolio($result['portfolio_id']);
			}

			$this->cache->set('portfolio.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $portfolio_data);
		}

		return $portfolio_data;
	}

	public function getPortfolioAttributes($portfolio_id) {
		$portfolio_attribute_group_data = array();

		$portfolio_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "portfolio_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.portfolio_id = '" . (int)$portfolio_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($portfolio_attribute_group_query->rows as $portfolio_attribute_group) {
			$portfolio_attribute_data = array();

			$portfolio_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "portfolio_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.portfolio_id = '" . (int)$portfolio_id . "' AND a.attribute_group_id = '" . (int)$portfolio_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($portfolio_attribute_query->rows as $portfolio_attribute) {
				$portfolio_attribute_data[] = array(
					'attribute_id' => $portfolio_attribute['attribute_id'],
					'name'         => $portfolio_attribute['name'],
					'text'         => $portfolio_attribute['text']
				);
			}

			$portfolio_attribute_group_data[] = array(
				'attribute_group_id' => $portfolio_attribute_group['attribute_group_id'],
				'name'               => $portfolio_attribute_group['name'],
				'attribute'          => $portfolio_attribute_data
			);
		}

		return $portfolio_attribute_group_data;
	}

	public function getPortfolioOptions($portfolio_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_options WHERE portfolio_id = '" . (int)$portfolio_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY option_id ASC");

		return $query->rows;
	}

	public function getPortfolioDiscounts($portfolio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_discount WHERE portfolio_id = '" . (int)$portfolio_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getPortfolioImages($portfolio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_image WHERE portfolio_id = '" . (int)$portfolio_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getPortfolioRelated($portfolio_id) {
		$portfolio_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_related pr LEFT JOIN " . DB_PREFIX . "portfolio p ON (pr.related_id = p.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE pr.portfolio_id = '" . (int)$portfolio_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$portfolio_data[$result['related_id']] = $this->getPortfolio($result['related_id']);
		}

		return $portfolio_data;
	}

	public function getPortfolioLayoutId($portfolio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_to_layout WHERE portfolio_id = '" . (int)$portfolio_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($portfolio_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "portfolio_to_category WHERE portfolio_id = '" . (int)$portfolio_id . "'");

		return $query->rows;
	}

	public function getTotalPortfolios($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.portfolio_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "portfolio_category_path cp LEFT JOIN " . DB_PREFIX . "portfolio_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "portfolio_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "portfolio_filter pf ON (p2c.portfolio_id = pf.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio p ON (pf.portfolio_id = p.portfolio_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "portfolio p ON (p2c.portfolio_id = p.portfolio_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "portfolio p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "portfolio_description pd ON (p.portfolio_id = pd.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
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

	public function getProfile($portfolio_id, $recurring_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "portfolio_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.portfolio_id = '" . (int)$portfolio_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

		return $query->row;
	}

	public function getProfiles($portfolio_id) {
		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "portfolio_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.portfolio_id = " . (int)$portfolio_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTotalPortfolioSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.portfolio_id) AS total FROM " . DB_PREFIX . "portfolio_special ps LEFT JOIN " . DB_PREFIX . "portfolio p ON (ps.portfolio_id = p.portfolio_id) LEFT JOIN " . DB_PREFIX . "portfolio_to_store p2s ON (p.portfolio_id = p2s.portfolio_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
