<?php
class ModelCatalogFiltersev extends Model {
	public function addFiltersev($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "filtersev_group` SET sort_order = '" . (int)$data['sort_order'] . "'");

		$filtersev_group_id = $this->db->getLastId();

		foreach ($data['filtersev_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev_group_description SET filtersev_group_id = '" . (int)$filtersev_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['filtersev'])) {
			foreach ($data['filtersev'] as $filtersev) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev SET filtersev_group_id = '" . (int)$filtersev_group_id . "', sort_order = '" . (int)$filtersev['sort_order'] . "'");

				$filtersev_id = $this->db->getLastId();

				foreach ($filtersev['filtersev_description'] as $language_id => $filtersev_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev_description SET filtersev_id = '" . (int)$filtersev_id . "', language_id = '" . (int)$language_id . "', filtersev_group_id = '" . (int)$filtersev_group_id . "', name = '" . $this->db->escape($filtersev_description['name']) . "'");
				}
			}
		}

		return $filtersev_group_id;
	}

	public function editFiltersev($filtersev_group_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "filtersev_group` SET sort_order = '" . (int)$data['sort_order'] . "' WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "filtersev_group_description WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");

		foreach ($data['filtersev_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev_group_description SET filtersev_group_id = '" . (int)$filtersev_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "filtersev WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "filtersev_description WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");

		if (isset($data['filtersev'])) {
			foreach ($data['filtersev'] as $filtersev) {
				if ($filtersev['filtersev_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev SET filtersev_id = '" . (int)$filtersev['filtersev_id'] . "', filtersev_group_id = '" . (int)$filtersev_group_id . "', sort_order = '" . (int)$filtersev['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev SET filtersev_group_id = '" . (int)$filtersev_group_id . "', sort_order = '" . (int)$filtersev['sort_order'] . "'");
				}

				$filtersev_id = $this->db->getLastId();

				foreach ($filtersev['filtersev_description'] as $language_id => $filtersev_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "filtersev_description SET filtersev_id = '" . (int)$filtersev_id . "', language_id = '" . (int)$language_id . "', filtersev_group_id = '" . (int)$filtersev_group_id . "', name = '" . $this->db->escape($filtersev_description['name']) . "'");
				}
			}
		}
	}

	public function deleteFiltersev($filtersev_group_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filtersev_group` WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filtersev_group_description` WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filtersev` WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "filtersev_description` WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");
	}

	public function getFiltersevGroup($filtersev_group_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "filtersev_group` fg LEFT JOIN " . DB_PREFIX . "filtersev_group_description fgd ON (fg.filtersev_group_id = fgd.filtersev_group_id) WHERE fg.filtersev_group_id = '" . (int)$filtersev_group_id . "' AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getFiltersevGroups($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "filtersev_group` fg LEFT JOIN " . DB_PREFIX . "filtersev_group_description fgd ON (fg.filtersev_group_id = fgd.filtersev_group_id) WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'fgd.name',
			'fg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY fgd.name";
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

	public function getFiltersevGroupDescriptions($filtersev_group_id) {
		$filtersev_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filtersev_group_description WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");

		foreach ($query->rows as $result) {
			$filtersev_group_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $filtersev_group_data;
	}

	public function getFiltersev($filtersev_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filtersev_group_description fgd WHERE f.filtersev_group_id = fgd.filtersev_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filtersev f LEFT JOIN " . DB_PREFIX . "filtersev_description fd ON (f.filtersev_id = fd.filtersev_id) WHERE f.filtersev_id = '" . (int)$filtersev_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getFiltersevs($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "filtersev_group_description fgd WHERE f.filtersev_group_id = fgd.filtersev_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filtersev f LEFT JOIN " . DB_PREFIX . "filtersev_description fd ON (f.filtersev_id = fd.filtersev_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filtersev_name'])) {
			$sql .= " AND fd.name LIKE '" . $this->db->escape($data['filtersev_name']) . "%'";
		}

		$sql .= " ORDER BY f.sort_order ASC";

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

	public function getFiltersevDescriptions($filtersev_group_id) {
		$filtersev_data = array();

		$filtersev_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filtersev WHERE filtersev_group_id = '" . (int)$filtersev_group_id . "'");

		foreach ($filtersev_query->rows as $filtersev) {
			$filtersev_description_data = array();

			$filtersev_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filtersev_description WHERE filtersev_id = '" . (int)$filtersev['filtersev_id'] . "'");

			foreach ($filtersev_description_query->rows as $filtersev_description) {
				$filtersev_description_data[$filtersev_description['language_id']] = array('name' => $filtersev_description['name']);
			}

			$filtersev_data[] = array(
				'filtersev_id'          => $filtersev['filtersev_id'],
				'filtersev_description' => $filtersev_description_data,
				'sort_order'         => $filtersev['sort_order']
			);
		}

		return $filtersev_data;
	}

	public function getTotalFiltersevGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "filtersev_group`");

		return $query->row['total'];
	}
}
