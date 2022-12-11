<?php 
class WCMCA_Customer
{
	public function __construct()
	{
	} 
	private function array_sort($array, $on, $order=SORT_ASC)
	{

		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}
	public function get_last_used_vat($user_id)
	{
		if(!isset($user_id) || !is_numeric($user_id))
			return "";
		
		$customer = new WC_Customer($user_id);
		return $customer->get_meta('billing_vat_number');
	}
	public function get_last_used_address_detail($user_id, $type = "billing", $detail = "name")
	{
		if(!isset($user_id) || !is_numeric($user_id))
			return "";
		
		$customer = new WC_Customer($user_id);
		$method = "get_".$type."_".$detail;
		$result = is_callable(array($customer, $method)) ? $customer->$method() : "";
		return $result;
	}
	
	private function unset_old_addresses_default($type, $old_addresses)
	{
		foreach($old_addresses as $key => $old_address)
			if(isset($old_address[$type."_is_default_address"]))
			{
				//wcmca_var_dump($key);
				unset($old_addresses[$key][$type."_is_default_address"]);
			}
			
		//wcmca_var_dump($old_addresses);
		return $old_addresses;
	}
	public function update_addresses($user_id, $address_id, $new_address)
	{
		$new_address = apply_filters('wcmca_before_updating_user_address', $new_address, $user_id, $address_id);
		$old_addresses = $this->get_addresses($user_id);
		$this->check_address_identifier_field($new_address);
		if($old_addresses)
		{
			//old default reset
			if(isset($new_address[$new_address['type']."_is_default_address"]))
			{
				//wcsts_var_dump($new_address[$new_address['type']."_is_default_address"]);
				$old_addresses = $this->unset_old_addresses_default($new_address['type'],$old_addresses);	
			}
			foreach($old_addresses as $key => $current_address)
					if($current_address['address_id'] == $address_id)
						$old_addresses[$key] = $new_address;	
		}
		else
			$old_addresses = array($address_id => $new_address);
		update_user_meta( $user_id, '_wcmca_additional_addresses', $old_addresses );
		
		do_action('wcmca_after_updating_user_address', $user_id, $address_id, $new_address);
	}
	public function delete_addresses($user_id, $address_ids)
	{
		if(!isset($user_id))
			return;
		
		$ids_to_delete = is_array($address_ids) ? $address_ids : array($address_ids);
		
		foreach($ids_to_delete as $address_id)
		{
			do_action('wcmca_before_deleting_user_address', $user_id, $address_id);
			$old_addresses = $this->get_addresses($user_id);
			if($old_addresses)
				foreach($old_addresses as $key => $current_address)
					if($current_address['address_id'] == $address_id)
						unset($old_addresses[$key]);
			
			update_user_meta($user_id, '_wcmca_additional_addresses', $old_addresses );
			
			do_action('wcmca_after_deleting_user_address', $user_id, $address_id);
		}
	}
	public function duplicate_addresses($user_id, $address_id)
	{
		if(!isset($user_id))
			return;
		$addresses = $this->get_addresses($user_id);
		if(!$addresses)
			return;
		
		$address = array();
		$new_id = -1;
		foreach($addresses as $key => $current_address)
		{
			$new_id = $current_address['address_id'] > $new_id ? $current_address['address_id'] : $new_id;
			if($current_address['address_id'] == $address_id)
			{
				$address = $current_address;
			}
		}
		$new_id += 1;
		$address['address_id'] = $new_id;
		
		if(empty($address))
			return;
		
		if(isset($address[$address["type"]."_is_default_address"]))
			unset($address[$address["type"]."_is_default_address"]);
		
		do_action('wcmca_before_duplicating_user_address', $user_id, $address_id, $address);
		
		$addresses[] = $address;
		//$new_address_id = key( array_slice( $addresses, -1, 1, TRUE ) );
		
		update_user_meta($user_id, '_wcmca_additional_addresses', $addresses );
		
		do_action('wcmca_after_duplicating_user_address', $user_id, $address_id, $new_address_id, $address);
	}
	public function add_addresses($user_id, $new_address)
	{
		$new_address = apply_filters('wcmca_before_adding_new_user_address', $new_address, $user_id);
		$old_addresses = $this->get_addresses($user_id);
		$this->check_address_identifier_field($new_address);
		
		if($old_addresses)
		{
			//old default reset
			if(isset($new_address[$new_address["type"]."_is_default_address"]))
				$old_addresses = $this->unset_old_addresses_default($new_address['type'],$old_addresses);
			//$new_address['address_id'] = count($old_addresses); //useless, the address_id will be the index inside the address array
			$old_addresses[] = $new_address;
		}
		else
		{
			//$new_address['address_id'] = 0; //useless, the address_id will be the index inside the address array
			$old_addresses = array($new_address);
		}
		
		end($old_addresses);
		$address_id = key($old_addresses);
		
		//updates the internal id reference
		$old_addresses[$address_id]['address_id'] = $address_id;
		
		if(!add_user_meta( $user_id, '_wcmca_additional_addresses', $old_addresses, true ))
			update_user_meta( $user_id, '_wcmca_additional_addresses', $old_addresses );
		
		do_action('wcmca_after_adding_new_user_address', $user_id, $new_address);
		
		return $address_id;
	}
	
	
	public function delete_guest_product_addresses()
	{
		global $wcmca_session_model;
		$wcmca_session_model->set_checkout_item_addresses(null);
	}
	//end
	private function check_address_identifier_field(&$new_address)
	{
		$type = $new_address['type'];
		$bad_chars = array("/", "\\", "'", '"');
		if(isset($new_address[$type.'_address_internal_name']))
		{
			$new_address['address_internal_name'] = $new_address[$type.'_address_internal_name'];
			unset($new_address[$type.'_address_internal_name']);
		}
		
		if(!isset($new_address['address_internal_name']))
			$new_address['address_internal_name'] = $new_address[$type.'_first_name']." ".
													$new_address[$type.'_last_name']." - ".
													(isset($new_address[$type.'_company']) && $new_address[$type.'_company'] != "" ? $new_address[$type.'_company']." - " : "").
													$new_address[$type.'_address_1']." ".
													//$new_address[$type.'_postcode']." ".
													(isset($new_address[$type.'_address_2']) && $new_address[$type.'_address_2'] != "" ? $new_address[$type.'_address_2']." - " : " - ").
													$new_address[$type.'_city'].
													(isset($new_address[$type.'_state']) && $new_address[$type.'_state'] != "" ? ", ".$new_address[$type.'_state'] : "");
		
		$new_address['address_internal_name'] = str_replace($bad_chars, "", $new_address['address_internal_name']);
	}
	public function get_addresses($user_id)
	{
		if(!isset($user_id) || !is_numeric($user_id))
			return "";
		
		//$customer = new WC_Customer($user_id);
		//$result =  $customer->get_meta('_wcmca_additional_addresses');
		$result = get_user_meta($user_id, '_wcmca_additional_addresses', true);
		$result = !is_array($result) ? array() : $this->array_sort($result, 'address_internal_name');
		
		//wcmca_var_dump($result);
		//wcmca_var_dump($this->get_last_saved_vat($user_id));
		//wcmca_var_dump($this->get_last_used_address_detail($user_id, 'billing', 'country'));
		return $result;
	}
	public function get_addresses_by_type($user_id)
	{
		$result = array('billing'=>array(), 'shipping'=>array());
		
		$default_address_indexes = array('billing'=> -1, 'shipping'=> -1);
		foreach((array)$this->get_addresses($user_id) as $address_id => $address)
		{
			if(!isset($address['type']))
			{
				$this->delete_addresses($user_id, $address_id);
				continue;
			}
			
			$result[$address['type']][$address_id] = $address;
			
			if(isset($address[$address['type']."_is_default_address"]))
				$default_address_indexes[$address['type']] = $address_id;
		}
		
		//sorting
		ksort($result['billing']);
		ksort($result['shipping']);
		
		foreach($default_address_indexes as $default_address_type => $default_index)
		{
			if($default_index < 0)
				continue;
			
			$elem_to_move = $result[$default_address_type][$default_index];
			unset($result[$default_address_type][$default_index]);
			array_unshift($result[$default_address_type], $elem_to_move);
		}
		
		return $result;
	}
	public function get_address_by_id($user_id, $address_id)
	{	
		$result = array();
		
		if(!isset($user_id))
			return $result;
		
		if($address_id === "last_used_billing" || $address_id === "last_used_shipping" || $address_id === "checkout_data")
		{
			$prefix = $address_id === 'last_used_shipping' ? 'shipping' : 'billing';
			$customer = get_user_meta( $user_id);
			
			if($address_id === "checkout_data")
			{
				$prefix =  isset($_POST['ship_to_different_address']) ? 'shipping' : 'billing';
				$customer = $_POST;
			}
			
			
			//new method
			$result = array('type' => $prefix);
			foreach((array)$customer as $meta_field_name => $meta_field_value)
			{
				if(isset($meta_field_value[0]) && strpos($meta_field_name, $prefix."_") !== false)
				{
					$result[$meta_field_name] = stripslashes(is_array($meta_field_value) ? $meta_field_value[0] : $meta_field_value);
				}
			}
		}
		else
		{
			$result = get_user_meta($user_id, '_wcmca_additional_addresses', true);
			$result = is_array($result) && isset($result[$address_id]) ? $result[$address_id] : array();
		}
		
		return $result;
	}
}
?>