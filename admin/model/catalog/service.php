<?php

class ModelCatalogService extends Model {

	public function addService($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "service SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturersev_id = '" . (int)$data['manufacturersev_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");



		$service_id = $this->db->getLastId();



		if (isset($data['image'])) {

			$this->db->query("UPDATE " . DB_PREFIX . "service SET image = '" . $this->db->escape($data['image']) . "' WHERE service_id = '" . (int)$service_id . "'");

		}



		foreach ($data['service_description'] as $language_id => $value) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "service_description SET service_id = '" . (int)$service_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");

		}



		if (isset($data['service_store'])) {

			foreach ($data['service_store'] as $store_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");

			}

		}



		if (isset($data['service_attributesev'])) {

			foreach ($data['service_attributesev'] as $service_attributesev) {

				if ($service_attributesev['attributesev_id']) {

					// Removes duplicates

					$this->db->query("DELETE FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "' AND attributesev_id = '" . (int)$service_attributesev['attributesev_id'] . "'");



					foreach ($service_attributesev['service_attributesev_description'] as $language_id => $service_attributesev_description) {

						$this->db->query("DELETE FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "' AND attributesev_id = '" . (int)$service_attributesev['attributesev_id'] . "' AND language_id = '" . (int)$language_id . "'");



						$this->db->query("INSERT INTO " . DB_PREFIX . "service_attributesev SET service_id = '" . (int)$service_id . "', attributesev_id = '" . (int)$service_attributesev['attributesev_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($service_attributesev_description['text']) . "'");

					}

				}

			}

		}



		if (isset($data['service_optionsev'])) {

			foreach ($data['service_optionsev'] as $service_optionsev) {

				if ($service_optionsev['type'] == 'select' || $service_optionsev['type'] == 'radio' || $service_optionsev['type'] == 'checkbox' || $service_optionsev['type'] == 'image') {

					if (isset($service_optionsev['service_optionsev_value'])) {

						$this->db->query("INSERT INTO " . DB_PREFIX . "service_optionsev SET service_id = '" . (int)$service_id . "', optionsev_id = '" . (int)$service_optionsev['optionsev_id'] . "', required = '" . (int)$service_optionsev['required'] . "'");



						$service_optionsev_id = $this->db->getLastId();



						foreach ($service_optionsev['service_optionsev_value'] as $service_optionsev_value) {

							$this->db->query("INSERT INTO " . DB_PREFIX . "service_optionsev_value SET service_optionsev_id = '" . (int)$service_optionsev_id . "', service_id = '" . (int)$service_id . "', optionsev_id = '" . (int)$service_optionsev['optionsev_id'] . "', optionsev_value_id = '" . (int)$service_optionsev_value['optionsev_value_id'] . "', quantity = '" . (int)$service_optionsev_value['quantity'] . "', subtract = '" . (int)$service_optionsev_value['subtract'] . "', price = '" . (float)$service_optionsev_value['price'] . "', price_prefix = '" . $this->db->escape($service_optionsev_value['price_prefix']) . "', points = '" . (int)$service_optionsev_value['points'] . "', points_prefix = '" . $this->db->escape($service_optionsev_value['points_prefix']) . "', weight = '" . (float)$service_optionsev_value['weight'] . "', weight_prefix = '" . $this->db->escape($service_optionsev_value['weight_prefix']) . "'");

						}

					}

				} else {

					$this->db->query("INSERT INTO " . DB_PREFIX . "service_optionsev SET service_id = '" . (int)$service_id . "', optionsev_id = '" . (int)$service_optionsev['optionsev_id'] . "', value = '" . $this->db->escape($service_optionsev['value']) . "', required = '" . (int)$service_optionsev['required'] . "'");

				}

			}

		}



		if (isset($data['service_discount'])) {

			foreach ($data['service_discount'] as $service_discount) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_discount SET service_id = '" . (int)$service_id . "', customer_group_id = '" . (int)$service_discount['customer_group_id'] . "', quantity = '" . (int)$service_discount['quantity'] . "', priority = '" . (int)$service_discount['priority'] . "', price = '" . (float)$service_discount['price'] . "', date_start = '" . $this->db->escape($service_discount['date_start']) . "', date_end = '" . $this->db->escape($service_discount['date_end']) . "'");

			}

		}



		if (isset($data['service_special'])) {

			foreach ($data['service_special'] as $service_special) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_special SET service_id = '" . (int)$service_id . "', customer_group_id = '" . (int)$service_special['customer_group_id'] . "', priority = '" . (int)$service_special['priority'] . "', price = '" . (float)$service_special['price'] . "', date_start = '" . $this->db->escape($service_special['date_start']) . "', date_end = '" . $this->db->escape($service_special['date_end']) . "'");

			}

		}



		if (isset($data['service_image'])) {

			foreach ($data['service_image'] as $service_image) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_image SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape($service_image['image']) . "', sort_order = '" . (int)$service_image['sort_order'] . "'");

			}

		}



		if (isset($data['service_download'])) {

			foreach ($data['service_download'] as $download_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_download SET service_id = '" . (int)$service_id . "', download_id = '" . (int)$download_id . "'");

			}

		}



		if (isset($data['service_categorysev'])) {

			foreach ($data['service_categorysev'] as $categorysev_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_categorysev SET service_id = '" . (int)$service_id . "', categorysev_id = '" . (int)$categorysev_id . "'");

			}

		}



		if (isset($data['service_filter'])) {

			foreach ($data['service_filter'] as $filter_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_filter SET service_id = '" . (int)$service_id . "', filter_id = '" . (int)$filter_id . "'");

			}

		}



		if (isset($data['service_related'])) {

			foreach ($data['service_related'] as $related_id) {

				$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$service_id . "' AND related_id = '" . (int)$related_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_related SET service_id = '" . (int)$service_id . "', related_id = '" . (int)$related_id . "'");

				$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$related_id . "' AND related_id = '" . (int)$service_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_related SET service_id = '" . (int)$related_id . "', related_id = '" . (int)$service_id . "'");

			}

		}



		if (isset($data['service_reward'])) {

			foreach ($data['service_reward'] as $customer_group_id => $service_reward) {

				if ((int)$service_reward['points'] > 0) {

					$this->db->query("INSERT INTO " . DB_PREFIX . "service_reward SET service_id = '" . (int)$service_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$service_reward['points'] . "'");

				}

			}

		}



		if (isset($data['service_layout'])) {

			foreach ($data['service_layout'] as $store_id => $layout_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_layout SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");

			}

		}



		if ($data['keyword']) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'service_id=" . (int)$service_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");

		}



		if (isset($data['service_recurring'])) {

			foreach ($data['service_recurring'] as $recurring) {

				$this->db->query("INSERT INTO `" . DB_PREFIX . "service_recurring` SET `service_id` = " . (int)$service_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);

			}

		}



		$this->cache->delete('service');



		return $service_id;

	}



	public function editService($service_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "service SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturersev_id = '" . (int)$data['manufacturersev_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['image'])) {

			$this->db->query("UPDATE " . DB_PREFIX . "service SET image = '" . $this->db->escape($data['image']) . "' WHERE service_id = '" . (int)$service_id . "'");

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_description WHERE service_id = '" . (int)$service_id . "'");



		foreach ($data['service_description'] as $language_id => $value) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "service_description SET service_id = '" . (int)$service_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_store WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_store'])) {

			foreach ($data['service_store'] as $store_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_store SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "'");



		if (!empty($data['service_attributesev'])) {

			foreach ($data['service_attributesev'] as $service_attributesev) {

				if ($service_attributesev['attributesev_id']) {

					// Removes duplicates

					$this->db->query("DELETE FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "' AND attributesev_id = '" . (int)$service_attributesev['attributesev_id'] . "'");



					foreach ($service_attributesev['service_attributesev_description'] as $language_id => $service_attributesev_description) {

						$this->db->query("INSERT INTO " . DB_PREFIX . "service_attributesev SET service_id = '" . (int)$service_id . "', attributesev_id = '" . (int)$service_attributesev['attributesev_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($service_attributesev_description['text']) . "'");

					}

				}

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_optionsev WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_optionsev_value WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_optionsev'])) {

			foreach ($data['service_optionsev'] as $service_optionsev) {

				if ($service_optionsev['type'] == 'select' || $service_optionsev['type'] == 'radio' || $service_optionsev['type'] == 'checkbox' || $service_optionsev['type'] == 'image') {

					if (isset($service_optionsev['service_optionsev_value'])) {

						$this->db->query("INSERT INTO " . DB_PREFIX . "service_optionsev SET service_optionsev_id = '" . (int)$service_optionsev['service_optionsev_id'] . "', service_id = '" . (int)$service_id . "', optionsev_id = '" . (int)$service_optionsev['optionsev_id'] . "', required = '" . (int)$service_optionsev['required'] . "'");



						$service_optionsev_id = $this->db->getLastId();



						foreach ($service_optionsev['service_optionsev_value'] as $service_optionsev_value) {

							$this->db->query("INSERT INTO " . DB_PREFIX . "service_optionsev_value SET service_optionsev_value_id = '" . (int)$service_optionsev_value['service_optionsev_value_id'] . "', service_optionsev_id = '" . (int)$service_optionsev_id . "', service_id = '" . (int)$service_id . "', optionsev_id = '" . (int)$service_optionsev['optionsev_id'] . "', optionsev_value_id = '" . (int)$service_optionsev_value['optionsev_value_id'] . "', quantity = '" . (int)$service_optionsev_value['quantity'] . "', subtract = '" . (int)$service_optionsev_value['subtract'] . "', price = '" . (float)$service_optionsev_value['price'] . "', price_prefix = '" . $this->db->escape($service_optionsev_value['price_prefix']) . "', points = '" . (int)$service_optionsev_value['points'] . "', points_prefix = '" . $this->db->escape($service_optionsev_value['points_prefix']) . "', weight = '" . (float)$service_optionsev_value['weight'] . "', weight_prefix = '" . $this->db->escape($service_optionsev_value['weight_prefix']) . "'");

						}

					}

				} else {

					$this->db->query("INSERT INTO " . DB_PREFIX . "service_optionsev SET service_optionsev_id = '" . (int)$service_optionsev['service_optionsev_id'] . "', service_id = '" . (int)$service_id . "', optionsev_id = '" . (int)$service_optionsev['optionsev_id'] . "', value = '" . $this->db->escape($service_optionsev['value']) . "', required = '" . (int)$service_optionsev['required'] . "'");

				}

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_discount WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_discount'])) {

			foreach ($data['service_discount'] as $service_discount) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_discount SET service_id = '" . (int)$service_id . "', customer_group_id = '" . (int)$service_discount['customer_group_id'] . "', quantity = '" . (int)$service_discount['quantity'] . "', priority = '" . (int)$service_discount['priority'] . "', price = '" . (float)$service_discount['price'] . "', date_start = '" . $this->db->escape($service_discount['date_start']) . "', date_end = '" . $this->db->escape($service_discount['date_end']) . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_special WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_special'])) {

			foreach ($data['service_special'] as $service_special) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_special SET service_id = '" . (int)$service_id . "', customer_group_id = '" . (int)$service_special['customer_group_id'] . "', priority = '" . (int)$service_special['priority'] . "', price = '" . (float)$service_special['price'] . "', date_start = '" . $this->db->escape($service_special['date_start']) . "', date_end = '" . $this->db->escape($service_special['date_end']) . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_image'])) {

			foreach ($data['service_image'] as $service_image) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_image SET service_id = '" . (int)$service_id . "', image = '" . $this->db->escape($service_image['image']) . "', sort_order = '" . (int)$service_image['sort_order'] . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_download WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_download'])) {

			foreach ($data['service_download'] as $download_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_download SET service_id = '" . (int)$service_id . "', download_id = '" . (int)$download_id . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_categorysev WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_categorysev'])) {

			foreach ($data['service_categorysev'] as $categorysev_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_categorysev SET service_id = '" . (int)$service_id . "', categorysev_id = '" . (int)$categorysev_id . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_filter WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_filter'])) {

			foreach ($data['service_filter'] as $filter_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_filter SET service_id = '" . (int)$service_id . "', filter_id = '" . (int)$filter_id . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE related_id = '" . (int)$service_id . "'");



		if (isset($data['service_related'])) {

			foreach ($data['service_related'] as $related_id) {

				$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$service_id . "' AND related_id = '" . (int)$related_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_related SET service_id = '" . (int)$service_id . "', related_id = '" . (int)$related_id . "'");

				$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$related_id . "' AND related_id = '" . (int)$service_id . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_related SET service_id = '" . (int)$related_id . "', related_id = '" . (int)$service_id . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_reward WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_reward'])) {

			foreach ($data['service_reward'] as $customer_group_id => $value) {

				if ((int)$value['points'] > 0) {

					$this->db->query("INSERT INTO " . DB_PREFIX . "service_reward SET service_id = '" . (int)$service_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");

				}

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "'");



		if (isset($data['service_layout'])) {

			foreach ($data['service_layout'] as $store_id => $layout_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "service_to_layout SET service_id = '" . (int)$service_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");

			}

		}



		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "'");



		if ($data['keyword']) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'service_id=" . (int)$service_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");

		}



		$this->db->query("DELETE FROM `" . DB_PREFIX . "service_recurring` WHERE service_id = " . (int)$service_id);



		if (isset($data['service_recurring'])) {

			foreach ($data['service_recurring'] as $service_recurring) {

				$this->db->query("INSERT INTO `" . DB_PREFIX . "service_recurring` SET `service_id` = " . (int)$service_id . ", customer_group_id = " . (int)$service_recurring['customer_group_id'] . ", `recurring_id` = " . (int)$service_recurring['recurring_id']);

			}

		}



		$this->cache->delete('service');

	}



	public function copyService($service_id) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "service p WHERE p.service_id = '" . (int)$service_id . "'");



		if ($query->num_rows) {

			$data = $query->row;



			$data['sku'] = '';

			$data['upc'] = '';

			$data['viewed'] = '0';

			$data['keyword'] = '';

			$data['status'] = '0';



			$data['service_attributesev'] = $this->getServiceAttributesevs($service_id);

			$data['service_description'] = $this->getServiceDescriptions($service_id);

			$data['service_discount'] = $this->getServiceDiscounts($service_id);

			$data['service_filter'] = $this->getServiceFilters($service_id);

			$data['service_image'] = $this->getServiceImages($service_id);

			$data['service_optionsev'] = $this->getServiceOptions($service_id);

			$data['service_related'] = $this->getServiceRelated($service_id);

			$data['service_reward'] = $this->getServiceRewards($service_id);

			$data['service_special'] = $this->getServiceSpecials($service_id);

			$data['service_categorysev'] = $this->getServiceCategories($service_id);

			$data['service_download'] = $this->getServiceDownloads($service_id);

			$data['service_layout'] = $this->getServiceLayouts($service_id);

			$data['service_store'] = $this->getServiceStores($service_id);

			$data['service_recurrings'] = $this->getRecurrings($service_id);



			$this->addService($data);

		}

	}



	public function deleteService($service_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "service WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_description WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_discount WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_filter WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_optionsev WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_optionsev_value WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_related WHERE related_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_reward WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_special WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_categorysev WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_download WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_to_store WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "service_recurring WHERE service_id = " . (int)$service_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE service_id = '" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_service WHERE service_id = '" . (int)$service_id . "'");



		$this->cache->delete('service');

	}



	public function getService($service_id) {

		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'service_id=" . (int)$service_id . "') AS keyword FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE p.service_id = '" . (int)$service_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");



		return $query->row;

	}



	public function getServices($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";



		if (!empty($data['filter_name'])) {

			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";

		}



		if (!empty($data['filter_model'])) {

			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";

		}



		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {

			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";

		}



		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {

			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";

		}



		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {

			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";

		}



		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {

			if ($data['filter_image'] == 1) {

				$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";

			} else {

				$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";

			}

		}



		$sql .= " GROUP BY p.service_id";



		$sort_data = array(

			'pd.name',

			'p.model',

			'p.price',

			'p.quantity',

			'p.status',

			'p.sort_order'

		);



		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {

			$sql .= " ORDER BY " . $data['sort'];

		} else {

			$sql .= " ORDER BY pd.name";

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



	public function getServicesByCategorysevId($categorysev_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id) LEFT JOIN " . DB_PREFIX . "service_to_categorysev p2c ON (p.service_id = p2c.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.categorysev_id = '" . (int)$categorysev_id . "' ORDER BY pd.name ASC");



		return $query->rows;

	}



	public function getServiceDescriptions($service_id) {

		$service_description_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_description WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_description_data[$result['language_id']] = array(

				'name'             => $result['name'],

				'description'      => $result['description'],

				'meta_title'       => $result['meta_title'],

				'meta_description' => $result['meta_description'],

				'meta_keyword'     => $result['meta_keyword'],

				'tag'              => $result['tag']

			);

		}



		return $service_description_data;

	}



	public function getServiceCategories($service_id) {

		$service_categorysev_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_categorysev WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_categorysev_data[] = $result['categorysev_id'];

		}



		return $service_categorysev_data;

	}



	public function getServiceFilters($service_id) {

		$service_filter_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_filter WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_filter_data[] = $result['filter_id'];

		}



		return $service_filter_data;

	}



	public function getServiceAttributesevs($service_id) {

		$service_attributesev_data = array();



		$service_attributesev_query = $this->db->query("SELECT attributesev_id FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "' GROUP BY attributesev_id");



		foreach ($service_attributesev_query->rows as $service_attributesev) {

			$service_attributesev_description_data = array();



			$service_attributesev_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_attributesev WHERE service_id = '" . (int)$service_id . "' AND attributesev_id = '" . (int)$service_attributesev['attributesev_id'] . "'");



			foreach ($service_attributesev_description_query->rows as $service_attributesev_description) {

				$service_attributesev_description_data[$service_attributesev_description['language_id']] = array('text' => $service_attributesev_description['text']);

			}



			$service_attributesev_data[] = array(

				'attributesev_id'                  => $service_attributesev['attributesev_id'],

				'service_attributesev_description' => $service_attributesev_description_data

			);

		}



		return $service_attributesev_data;

	}



	public function getServiceOptions($service_id) {

		$service_optionsev_data = array();



		$service_optionsev_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "service_optionsev` po LEFT JOIN `" . DB_PREFIX . "optionsev` o ON (po.optionsev_id = o.optionsev_id) LEFT JOIN `" . DB_PREFIX . "optionsev_description` od ON (o.optionsev_id = od.optionsev_id) WHERE po.service_id = '" . (int)$service_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");



		foreach ($service_optionsev_query->rows as $service_optionsev) {

			$service_optionsev_value_data = array();



			$service_optionsev_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_optionsev_value pov LEFT JOIN " . DB_PREFIX . "optionsev_value ov ON(pov.optionsev_value_id = ov.optionsev_value_id) WHERE pov.service_optionsev_id = '" . (int)$service_optionsev['service_optionsev_id'] . "' ORDER BY ov.sort_order ASC");



			foreach ($service_optionsev_value_query->rows as $service_optionsev_value) {

				$service_optionsev_value_data[] = array(

					'service_optionsev_value_id' => $service_optionsev_value['service_optionsev_value_id'],

					'optionsev_value_id'         => $service_optionsev_value['optionsev_value_id'],

					'quantity'                => $service_optionsev_value['quantity'],

					'subtract'                => $service_optionsev_value['subtract'],

					'price'                   => $service_optionsev_value['price'],

					'price_prefix'            => $service_optionsev_value['price_prefix'],

					'points'                  => $service_optionsev_value['points'],

					'points_prefix'           => $service_optionsev_value['points_prefix'],

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



	public function getServiceOptionValue($service_id, $service_optionsev_value_id) {

		$query = $this->db->query("SELECT pov.optionsev_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "service_optionsev_value pov LEFT JOIN " . DB_PREFIX . "optionsev_value ov ON (pov.optionsev_value_id = ov.optionsev_value_id) LEFT JOIN " . DB_PREFIX . "optionsev_value_description ovd ON (ov.optionsev_value_id = ovd.optionsev_value_id) WHERE pov.service_id = '" . (int)$service_id . "' AND pov.service_optionsev_value_id = '" . (int)$service_optionsev_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");



		return $query->row;

	}



	public function getServiceImages($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_image WHERE service_id = '" . (int)$service_id . "' ORDER BY sort_order ASC");



		return $query->rows;

	}



	public function getServiceDiscounts($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_discount WHERE service_id = '" . (int)$service_id . "' ORDER BY quantity, priority, price");



		return $query->rows;

	}



	public function getServiceSpecials($service_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_special WHERE service_id = '" . (int)$service_id . "' ORDER BY priority, price");



		return $query->rows;

	}



	public function getServiceRewards($service_id) {

		$service_reward_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_reward WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_reward_data[$result['customer_group_id']] = array('points' => $result['points']);

		}



		return $service_reward_data;

	}



	public function getServiceDownloads($service_id) {

		$service_download_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_download WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_download_data[] = $result['download_id'];

		}



		return $service_download_data;

	}



	public function getServiceStores($service_id) {

		$service_store_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_store WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_store_data[] = $result['store_id'];

		}



		return $service_store_data;

	}



	public function getServiceLayouts($service_id) {

		$service_layout_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_to_layout WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_layout_data[$result['store_id']] = $result['layout_id'];

		}



		return $service_layout_data;

	}



	public function getServiceRelated($service_id) {

		$service_related_data = array();



		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_related WHERE service_id = '" . (int)$service_id . "'");



		foreach ($query->rows as $result) {

			$service_related_data[] = $result['related_id'];

		}



		return $service_related_data;

	}



	public function getRecurrings($service_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "service_recurring` WHERE service_id = '" . (int)$service_id . "'");



		return $query->rows;

	}



	public function getTotalServices($data = array()) {

		$sql = "SELECT COUNT(DISTINCT p.service_id) AS total FROM " . DB_PREFIX . "service p LEFT JOIN " . DB_PREFIX . "service_description pd ON (p.service_id = pd.service_id)";



		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";



		if (!empty($data['filter_name'])) {

			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";

		}



		if (!empty($data['filter_model'])) {

			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";

		}



		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {

			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";

		}



		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {

			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";

		}



		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {

			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";

		}



		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {

			if ($data['filter_image'] == 1) {

				$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";

			} else {

				$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";

			}

		}



		$query = $this->db->query($sql);



		return $query->row['total'];

	}



	public function getTotalServicesByTaxClassId($tax_class_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service WHERE tax_class_id = '" . (int)$tax_class_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByStockStatusId($stock_status_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service WHERE stock_status_id = '" . (int)$stock_status_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByWeightClassId($weight_class_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service WHERE weight_class_id = '" . (int)$weight_class_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByLengthClassId($length_class_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service WHERE length_class_id = '" . (int)$length_class_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByDownloadId($download_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service_to_download WHERE download_id = '" . (int)$download_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByManufacturersevId($manufacturersev_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByAttributesevId($attributesev_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service_attributesev WHERE attributesev_id = '" . (int)$attributesev_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByOptionId($optionsev_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service_optionsev WHERE optionsev_id = '" . (int)$optionsev_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByProfileId($recurring_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");



		return $query->row['total'];

	}



	public function getTotalServicesByLayoutId($layout_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service_to_layout WHERE layout_id = '" . (int)$layout_id . "'");



		return $query->row['total'];

	}

}

