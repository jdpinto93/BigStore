<?php 
class WCMCA_Session
{
	public function __construct()
	{
	}
	//Temp cart item address associated to user 
	public function update_guest_cart_product_address($cart_item_id, $address)
	{
		global $wcmca_session_model;
		$current_item_addresses = $this->get_guest_cart_addresses();
		if(isset($current_item_addresses[$cart_item_id]))
			unset($current_item_addresses[$cart_item_id]);
		$current_item_addresses[$cart_item_id] =  $address;
		
		$this->set_guest_cart_addresses($current_item_addresses);
		$wcmca_session_model->get_guest_cart_addresses(); //without this it seems session is not properly updated
	}
	public function get_guest_cart_product_address($item_id)
	{
		global $wcmca_session_model;
		$addresses = $this->get_guest_cart_addresses();
		
		$address = isset($addresses[$item_id]) ? $addresses[$item_id] : array();
		/* $result = array();
		foreach($address as $address_field_name => $address_field_value)
		{
			if(strpos($address_field_name, "billing_") !== false )
				$result[$address_field_name] = $address_field_value;
		}
		 */
		if(isset($address['cart_item_id']))
			 unset($address['cart_item_id']);
		 
		return $address;
	}
	public function get_guest_cart_addresses()
	{
		//not reliable: $result = WC()->session->get('wcmca_guest_cart_addresses'); //woocommerce session sometime returns incosistent data for guests
		
		if (!session_id()) 
			session_start();

		$result = isset($_SESSION['wcmca_guest_cart_addresses']) ? $_SESSION['wcmca_guest_cart_addresses'] : array();
		$result = !isset($result) || !is_array($result) ? array() : $result;
	
		return $result;
	}
	public function set_guest_cart_addresses($addresses = null)
	{
		//not reliable: WC()->session->set('wcmca_guest_cart_addresses', $addresses); //woocommerce session sometime returns incosistent data for guests
		 
		if (!session_id()) 
			session_start();
		
		$_SESSION['wcmca_guest_cart_addresses'] = $addresses;
		
	}
	public function update_cart_item_address($cart_item_id, $address_id, $type)
	{
		if(!WC()->session)
			return array();
		
		$existing_data = WC()->session->get( 'wcmca_cart_item_addresses' );
	
		
		/* old method, use in case you experience any issue with the WC session handler
			if (!session_id()) 
			session_start();
		
		 $existing_data = wcmca_get_value_if_set($_SESSION, 'wcmca_cart_item_addresses', array());*/
		 
		$existing_data = is_array($existing_data) ? $existing_data : array();
		$existing_data[$cart_item_id] = array('id' => $address_id, 'type' => $type);
		
		 WC()->session->set( 'wcmca_cart_item_addresses',  $existing_data );
		
		//old method: $_SESSION['wcmca_cart_item_addresses'] = $existing_data;
	}
	public function get_cart_item_address()
	{
		if(!WC()->session)
			return array();
		
		$data = WC()->session->get( 'wcmca_cart_item_addresses' ); 
		
		/* old method: 
		if (!session_id()) 
			session_start();
		
		$data = wcmca_get_value_if_set($_SESSION, 'wcmca_cart_item_addresses', array());
		*/
		$data = !isset($data) || !is_array($data) ? array() : $data;
		
		return $data ? $data : array();
	}
	public function reset_all_cart_session_data()
	{
	   if(!WC()->session)
			return;
	   WC()->session->set( 'wcmca_cart_item_addresses',  "" );
	   
	   if (!session_id()) 
			session_start();

		$_SESSION['wcmca_guest_cart_addresses'] = "";
	}
}
?>