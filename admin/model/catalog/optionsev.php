<?php
class ModelCatalogOptionsev extends Model {
	public function addOptionsev($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "optionsev` SET type = '" . $this->db->escape($data['type']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$optionsev_id = $this->db->getLastId();

		foreach ($data['optionsev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_description SET optionsev_id = '" . (int)$optionsev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['optionsev_value'])) {
			foreach ($data['optionsev_value'] as $optionsev_value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_value SET optionsev_id = '" . (int)$optionsev_id . "', image = '" . $this->db->escape(html_entity_decode($optionsev_value['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$optionsev_value['sort_order'] . "'");

				$optionsev_value_id = $this->db->getLastId();

				foreach ($optionsev_value['optionsev_value_description'] as $language_id => $optionsev_value_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_value_description SET optionsev_value_id = '" . (int)$optionsev_value_id . "', language_id = '" . (int)$language_id . "', optionsev_id = '" . (int)$optionsev_id . "', name = '" . $this->db->escape($optionsev_value_description['name']) . "'");
				}
			}
		}

		return $optionsev_id;
	}

	public function editOptionsev($optionsev_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "optionsev` SET type = '" . $this->db->escape($data['type']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE optionsev_id = '" . (int)$optionsev_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "optionsev_description WHERE optionsev_id = '" . (int)$optionsev_id . "'");

		foreach ($data['optionsev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_description SET optionsev_id = '" . (int)$optionsev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "optionsev_value WHERE optionsev_id = '" . (int)$optionsev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "optionsev_value_description WHERE optionsev_id = '" . (int)$optionsev_id . "'");

		if (isset($data['optionsev_value'])) {
			foreach ($data['optionsev_value'] as $optionsev_value) {
				if ($optionsev_value['optionsev_value_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_value SET optionsev_value_id = '" . (int)$optionsev_value['optionsev_value_id'] . "', optionsev_id = '" . (int)$optionsev_id . "', image = '" . $this->db->escape(html_entity_decode($optionsev_value['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$optionsev_value['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_value SET optionsev_id = '" . (int)$optionsev_id . "', image = '" . $this->db->escape(html_entity_decode($optionsev_value['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$optionsev_value['sort_order'] . "'");
				}

				$optionsev_value_id = $this->db->getLastId();

				foreach ($optionsev_value['optionsev_value_description'] as $language_id => $optionsev_value_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "optionsev_value_description SET optionsev_value_id = '" . (int)$optionsev_value_id . "', language_id = '" . (int)$language_id . "', optionsev_id = '" . (int)$optionsev_id . "', name = '" . $this->db->escape($optionsev_value_description['name']) . "'");
				}
			}

		}
	}

	public function deleteOptionsev($optionsev_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "optionsev` WHERE optionsev_id = '" . (int)$optionsev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "optionsev_description WHERE optionsev_id = '" . (int)$optionsev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "optionsev_value WHERE optionsev_id = '" . (int)$optionsev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "optionsev_value_description WHERE optionsev_id = '" . (int)$optionsev_id . "'");
	}

	public function getOptionsev($optionsev_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "optionsev` o LEFT JOIN " . DB_PREFIX . "optionsev_description od ON (o.optionsev_id = od.optionsev_id) WHERE o.optionsev_id = '" . (int)$optionsev_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptionsevs($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "optionsev` o LEFT JOIN " . DB_PREFIX . "optionsev_description od ON (o.optionsev_id = od.optionsev_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND od.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'od.name',
			'o.type',
			'o.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY od.name";
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

	public function getOptionsevDescriptions($optionsev_id) {
		$optionsev_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "optionsev_description WHERE optionsev_id = '" . (int)$optionsev_id . "'");

		foreach ($query->rows as $result) {
			$optionsev_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $optionsev_data;
	}

	public function getOptionsevValue($optionsev_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "optionsev_value ov LEFT JOIN " . DB_PREFIX . "optionsev_value_description ovd ON (ov.optionsev_value_id = ovd.optionsev_value_id) WHERE ov.optionsev_value_id = '" . (int)$optionsev_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptionsevValues($optionsev_id) {
		$optionsev_value_data = array();

		$optionsev_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "optionsev_value ov LEFT JOIN " . DB_PREFIX . "optionsev_value_description ovd ON (ov.optionsev_value_id = ovd.optionsev_value_id) WHERE ov.optionsev_id = '" . (int)$optionsev_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order, ovd.name");

		foreach ($optionsev_value_query->rows as $optionsev_value) {
			$optionsev_value_data[] = array(
				'optionsev_value_id' => $optionsev_value['optionsev_value_id'],
				'name'            => $optionsev_value['name'],
				'image'           => $optionsev_value['image'],
				'sort_order'      => $optionsev_value['sort_order']
			);
		}

		return $optionsev_value_data;
	}

	public function getOptionsevValueDescriptions($optionsev_id) {
		$optionsev_value_data = array();

		$optionsev_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "optionsev_value WHERE optionsev_id = '" . (int)$optionsev_id . "' ORDER BY sort_order");

		foreach ($optionsev_value_query->rows as $optionsev_value) {
			$optionsev_value_description_data = array();

			$optionsev_value_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "optionsev_value_description WHERE optionsev_value_id = '" . (int)$optionsev_value['optionsev_value_id'] . "'");

			foreach ($optionsev_value_description_query->rows as $optionsev_value_description) {
				$optionsev_value_description_data[$optionsev_value_description['language_id']] = array('name' => $optionsev_value_description['name']);
			}

			$optionsev_value_data[] = array(
				'optionsev_value_id'          => $optionsev_value['optionsev_value_id'],
				'optionsev_value_description' => $optionsev_value_description_data,
				'image'                    => $optionsev_value['image'],
				'sort_order'               => $optionsev_value['sort_order']
			);
		}

		return $optionsev_value_data;
	}

	public function getTotalOptionsevs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "optionsev`");

		return $query->row['total'];
	}
}