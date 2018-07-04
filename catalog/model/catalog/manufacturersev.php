<?php
class ModelCatalogManufacturersev extends Model {
	public function getManufacturersev($manufacturersev_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturersev m LEFT JOIN " . DB_PREFIX . "manufacturersev_to_store m2s ON (m.manufacturersev_id = m2s.manufacturersev_id) WHERE m.manufacturersev_id = '" . (int)$manufacturersev_id . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row;
	}

	public function getManufacturersevs($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturersev m LEFT JOIN " . DB_PREFIX . "manufacturersev_to_store m2s ON (m.manufacturersev_id = m2s.manufacturersev_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

			$sort_data = array(
				'name',
				'sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY name";
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
		} else {
			$manufacturersev_data = $this->cache->get('manufacturersev.' . (int)$this->config->get('config_store_id'));

			if (!$manufacturersev_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturersev m LEFT JOIN " . DB_PREFIX . "manufacturersev_to_store m2s ON (m.manufacturersev_id = m2s.manufacturersev_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY name");

				$manufacturersev_data = $query->rows;

				$this->cache->set('manufacturersev.' . (int)$this->config->get('config_store_id'), $manufacturersev_data);
			}

			return $manufacturersev_data;
		}
	}
}