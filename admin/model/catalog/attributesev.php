<?php
class ModelCatalogAttributesev extends Model {
	public function addAttributesev($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "attributesev SET attributesev_group_id = '" . (int)$data['attributesev_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$attributesev_id = $this->db->getLastId();

		foreach ($data['attributesev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attributesev_description SET attributesev_id = '" . (int)$attributesev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $attributesev_id;
	}

	public function editAttributesev($attributesev_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "attributesev SET attributesev_group_id = '" . (int)$data['attributesev_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE attributesev_id = '" . (int)$attributesev_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "attributesev_description WHERE attributesev_id = '" . (int)$attributesev_id . "'");

		foreach ($data['attributesev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attributesev_description SET attributesev_id = '" . (int)$attributesev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteAttributesev($attributesev_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attributesev WHERE attributesev_id = '" . (int)$attributesev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attributesev_description WHERE attributesev_id = '" . (int)$attributesev_id . "'");
	}

	public function getAttributesev($attributesev_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attributesev a LEFT JOIN " . DB_PREFIX . "attributesev_description ad ON (a.attributesev_id = ad.attributesev_id) WHERE a.attributesev_id = '" . (int)$attributesev_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getAttributesevs($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attributesev_group_description agd WHERE agd.attributesev_group_id = a.attributesev_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attributesev_group FROM " . DB_PREFIX . "attributesev a LEFT JOIN " . DB_PREFIX . "attributesev_description ad ON (a.attributesev_id = ad.attributesev_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attributesev_group_id'])) {
			$sql .= " AND a.attributesev_group_id = '" . $this->db->escape($data['filter_attributesev_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attributesev_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY attributesev_group, ad.name";
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

	public function getAttributesevDescriptions($attributesev_id) {
		$attributesev_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attributesev_description WHERE attributesev_id = '" . (int)$attributesev_id . "'");

		foreach ($query->rows as $result) {
			$attributesev_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $attributesev_data;
	}

	public function getTotalAttributesevs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attributesev");

		return $query->row['total'];
	}

	public function getTotalAttributesevsByAttributesevGroupId($attributesev_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attributesev WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");

		return $query->row['total'];
	}
}
