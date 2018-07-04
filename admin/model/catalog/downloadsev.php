<?php
class ModelCatalogDownloadsev extends Model {
	public function addDownloadsev($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "downloadsev SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_added = NOW()");

		$downloadsev_id = $this->db->getLastId();

		foreach ($data['downloadsev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "downloadsev_description SET downloadsev_id = '" . (int)$downloadsev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $downloadsev_id;
	}

	public function editDownloadsev($downloadsev_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "downloadsev SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE downloadsev_id = '" . (int)$downloadsev_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "downloadsev_description WHERE downloadsev_id = '" . (int)$downloadsev_id . "'");

		foreach ($data['downloadsev_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "downloadsev_description SET downloadsev_id = '" . (int)$downloadsev_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteDownloadsev($downloadsev_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "downloadsev WHERE downloadsev_id = '" . (int)$downloadsev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "downloadsev_description WHERE downloadsev_id = '" . (int)$downloadsev_id . "'");
	}

	public function getDownloadsev($downloadsev_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "downloadsev d LEFT JOIN " . DB_PREFIX . "downloadsev_description dd ON (d.downloadsev_id = dd.downloadsev_id) WHERE d.downloadsev_id = '" . (int)$downloadsev_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDownloadsevs($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "downloadsev d LEFT JOIN " . DB_PREFIX . "downloadsev_description dd ON (d.downloadsev_id = dd.downloadsev_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'dd.name',
			'd.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dd.name";
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

	public function getDownloadsevDescriptions($downloadsev_id) {
		$downloadsev_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "downloadsev_description WHERE downloadsev_id = '" . (int)$downloadsev_id . "'");

		foreach ($query->rows as $result) {
			$downloadsev_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $downloadsev_description_data;
	}

	public function getTotalDownloadsevs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "downloadsev");

		return $query->row['total'];
	}
}