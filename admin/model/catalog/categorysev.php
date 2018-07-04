<?php
class ModelCatalogCategorysev extends Model {
	public function addCategorysev($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$categorysev_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "categorysev SET image = '" . $this->db->escape($data['image']) . "' WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		}

		foreach ($data['categorysev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_description SET categorysev_id = '" . (int)$categorysev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "categorysev_pathsev` SET `categorysev_id` = '" . (int)$categorysev_id . "', `pathsev_id` = '" . (int)$result['pathsev_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "categorysev_pathsev` SET `categorysev_id` = '" . (int)$categorysev_id . "', `pathsev_id` = '" . (int)$categorysev_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['categorysev_filter'])) {
			foreach ($data['categorysev_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_filter SET categorysev_id = '" . (int)$categorysev_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['categorysev_store'])) {
			foreach ($data['categorysev_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_to_store SET categorysev_id = '" . (int)$categorysev_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this categorysev
		if (isset($data['categorysev_layout'])) {
			foreach ($data['categorysev_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_to_layout SET categorysev_id = '" . (int)$categorysev_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'categorysev_id=" . (int)$categorysev_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('categorysev');

		return $categorysev_id;
	}

	public function editCategorysev($categorysev_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "categorysev SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "categorysev SET image = '" . $this->db->escape($data['image']) . "' WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_description WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		foreach ($data['categorysev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_description SET categorysev_id = '" . (int)$categorysev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE pathsev_id = '" . (int)$categorysev_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $categorysev_pathsev) {
				// Delete the pathsev below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$categorysev_pathsev['categorysev_id'] . "' AND level < '" . (int)$categorysev_pathsev['level'] . "'");

				$pathsev = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$pathsev[] = $result['pathsev_id'];
				}

				// Get whats left of the nodes current pathsev
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$categorysev_pathsev['categorysev_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$pathsev[] = $result['pathsev_id'];
				}

				// Combine the pathsevs with a new level
				$level = 0;

				foreach ($pathsev as $pathsev_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "categorysev_pathsev` SET categorysev_id = '" . (int)$categorysev_pathsev['categorysev_id'] . "', `pathsev_id` = '" . (int)$pathsev_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the pathsev below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$categorysev_id . "'");

			// Fix for records with no pathsevs
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "categorysev_pathsev` SET categorysev_id = '" . (int)$categorysev_id . "', `pathsev_id` = '" . (int)$result['pathsev_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "categorysev_pathsev` SET categorysev_id = '" . (int)$categorysev_id . "', `pathsev_id` = '" . (int)$categorysev_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_filter WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		if (isset($data['categorysev_filter'])) {
			foreach ($data['categorysev_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_filter SET categorysev_id = '" . (int)$categorysev_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_to_store WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		if (isset($data['categorysev_store'])) {
			foreach ($data['categorysev_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_to_store SET categorysev_id = '" . (int)$categorysev_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_to_layout WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		if (isset($data['categorysev_layout'])) {
			foreach ($data['categorysev_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categorysev_to_layout SET categorysev_id = '" . (int)$categorysev_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'categorysev_id=" . (int)$categorysev_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'categorysev_id=" . (int)$categorysev_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('categorysev');
	}

	public function deleteCategorysev($categorysev_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_pathsev WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categorysev_pathsev WHERE pathsev_id = '" . (int)$categorysev_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategorysev($result['categorysev_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_description WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_filter WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_to_store WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categorysev_to_layout WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_categorysev WHERE categorysev_id = '" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'categorysev_id=" . (int)$categorysev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_categorysev WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		$this->cache->delete('categorysev');
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categorysev WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $categorysev) {
			// Delete the pathsev below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$categorysev['categorysev_id'] . "'");

			// Fix for records with no pathsevs
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categorysev_pathsev` WHERE categorysev_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "categorysev_pathsev` SET categorysev_id = '" . (int)$categorysev['categorysev_id'] . "', `pathsev_id` = '" . (int)$result['pathsev_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "categorysev_pathsev` SET categorysev_id = '" . (int)$categorysev['categorysev_id'] . "', `pathsev_id` = '" . (int)$categorysev['categorysev_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($categorysev['categorysev_id']);
		}
	}

	public function getCategorysev($categorysev_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "categorysev_pathsev cp LEFT JOIN " . DB_PREFIX . "categorysev_description cd1 ON (cp.pathsev_id = cd1.categorysev_id AND cp.categorysev_id != cp.pathsev_id) WHERE cp.categorysev_id = c.categorysev_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.categorysev_id) AS pathsev, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'categorysev_id=" . (int)$categorysev_id . "') AS keyword FROM " . DB_PREFIX . "categorysev c LEFT JOIN " . DB_PREFIX . "categorysev_description cd2 ON (c.categorysev_id = cd2.categorysev_id) WHERE c.categorysev_id = '" . (int)$categorysev_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.categorysev_id AS categorysev_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "categorysev_pathsev cp LEFT JOIN " . DB_PREFIX . "categorysev c1 ON (cp.categorysev_id = c1.categorysev_id) LEFT JOIN " . DB_PREFIX . "categorysev c2 ON (cp.pathsev_id = c2.categorysev_id) LEFT JOIN " . DB_PREFIX . "categorysev_description cd1 ON (cp.pathsev_id = cd1.categorysev_id) LEFT JOIN " . DB_PREFIX . "categorysev_description cd2 ON (cp.categorysev_id = cd2.categorysev_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.categorysev_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getCategorysevDescriptions($categorysev_id) {
		$categorysev_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categorysev_description WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		foreach ($query->rows as $result) {
			$categorysev_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $categorysev_description_data;
	}
	
	public function getCategorysevPathsev($categorysev_id) {
		$query = $this->db->query("SELECT categorysev_id, pathsev_id, level FROM " . DB_PREFIX . "categorysev_pathsev WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		return $query->rows;
	}
	
	public function getCategorysevFilters($categorysev_id) {
		$categorysev_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categorysev_filter WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		foreach ($query->rows as $result) {
			$categorysev_filter_data[] = $result['filter_id'];
		}

		return $categorysev_filter_data;
	}

	public function getCategorysevStores($categorysev_id) {
		$categorysev_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categorysev_to_store WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		foreach ($query->rows as $result) {
			$categorysev_store_data[] = $result['store_id'];
		}

		return $categorysev_store_data;
	}

	public function getCategorysevLayouts($categorysev_id) {
		$categorysev_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categorysev_to_layout WHERE categorysev_id = '" . (int)$categorysev_id . "'");

		foreach ($query->rows as $result) {
			$categorysev_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $categorysev_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "categorysev");

		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "categorysev_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
