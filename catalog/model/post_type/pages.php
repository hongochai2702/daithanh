<?php
class ModelPostTypePages extends Model {
	public function getPostType($post_type_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "post_type i LEFT JOIN " . DB_PREFIX . "post_type_description id ON (i.post_type_id = id.post_type_id) LEFT JOIN " . DB_PREFIX . "post_type_to_store i2s ON (i.post_type_id = i2s.post_type_id) WHERE i.post_type_id = '" . (int)$post_type_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getPostTypes() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_type i LEFT JOIN " . DB_PREFIX . "post_type_description id ON (i.post_type_id = id.post_type_id) LEFT JOIN " . DB_PREFIX . "post_type_to_store i2s ON (i.post_type_id = i2s.post_type_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");

		return $query->rows;
	}

	public function getPostTypeLayoutId($post_type_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_type_to_layout WHERE post_type_id = '" . (int)$post_type_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}
}