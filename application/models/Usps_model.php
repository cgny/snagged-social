<?php
/**
 * Created by PhpStorm.
 * User: cgibbs
 * Date: 4/23/18
 * Time: 8:49 PM
 */

class Usps_model extends CI_Model{

	public $base_url = "http://production.shippingapis.com/ShippingApi.dll?API=RateV4";
	public $base_intl_url = "http://production.shippingapis.com/ShippingApi.dll?API=IntlRateV2";
	public $rate = 0.00;
	public $highest_rate = 0.00;
	public $service = null;
	public $duration = null;

	function __construct()
	{
		parent::__construct();
		$this->rate = 0.00;
	}
	
	function getShipCountries()
	{
		return $this->db->get('ss_countries')->result();
	}

	function calculateRate($to_country = 'US', $to_zip = 14882)
	{
		$cart_items = $this->cart->getCart()->result();
		$largest = 0;
		foreach($cart_items as $cart_item)
		{
			$this->getShippingCost($cart_item->p_price,$cart_item->ps_size,$cart_item->c_qty,$to_zip,$to_country);
		}
		$this->cart->updateShipping($this->rate,$this->service,$this->duration);
	}

	function getShippingCost($price, $size, $qty, $to_zip, $to_country)
	{
		$package_size = "REGULAR";
		$package_size_us = "VARIABLE";
		switch($size)
		{
			case "4x4":
			case "6x6":
			case "8x8":
			case "10x10":
				$weight = 0.065;
				break;
			case "12x12":
			case "16x16":
				$package_size = "LARGE";
				$package_size_us = "VARIABLE";
				$weight = 0.125;
				break;
			case "20x20":
			case "24x24":
				$package_size = "LARGE";
				$package_size_us = "VARIABLE";
				$weight = 0.20;
				break;
			case "28x28":
				$package_size = "LARGE";
				$package_size_us = "VARIABLE";
				$weight = 0.25;
				break;
			default:
				$weight = 0.25;
		}

		$ounces = ($weight*16) * $qty;
		$sizes = explode("x",$size);

		$type = "domestic";
		if($to_country == "United States")
		{
			$xml = '<RateV4Request USERID="'. USPS_USER .'">
								<Package ID="1ST"> 
									<Service>PRIORITY</Service> 
									<ZipOrigination>08861</ZipOrigination> 
									<ZipDestination>'. $to_zip .'</ZipDestination> 
									<Pounds>0</Pounds> 
									<Ounces>'. $ounces .'</Ounces> 
									<Container>'. $package_size_us .'</Container> 
									<Size>'. $package_size .'</Size> 
									<Width>4</Width> 
									<Length>'.$sizes[0] .'</Length> 
									<Height>'.$sizes[0] .'</Height> 
									<Girth>8</Girth> 
								</Package>
							</RateV4Request>';
			$url = $this->base_url;
		}
		else
		{
			$type = "international";
			$xml = '<IntlRateV2Request USERID="'. USPS_USER .'">
								<Revision>2</Revision> 
								<Package ID="0"> 
								<Pounds>0</Pounds> 
								<Ounces>'. $weight .'</Ounces> 
								<Machinable>True</Machinable> 
								<MailType>package</MailType> 
								<ValueOfContents>'. $price .'</ValueOfContents> 
								<Country>'. $to_country .'</Country> 
								<Container>NONRECTANGULAR</Container> 
								<Size>'. $package_size .'</Size> 
								<Width>4</Width> 
								<Length>'. $sizes[0] .'</Length> 
								<Height>'. $sizes[0] .'</Height> 
								<Girth>8</Girth> 
								<OriginZip>08861</OriginZip> 
								<CommercialFlag>Y</CommercialFlag> 
								<ExtraServices> 
									<ExtraService>1</ExtraService> 
									<ExtraService>9</ExtraService> 
								</ExtraServices> 
								</Package>
							</IntlRateV2Request>';
			$url = $this->base_intl_url;
		}

		$info = $this->sendRequest($url, $xml);
		//print_r($info);
		$this->findHighestRate($info,$type);
	}

	function findHighestRate($info, $type = 'domestic')
	{
		if($type == "domestic")
		{
			$rate = $info->Package->Postage->Rate;
			if($rate > $this->rate)
			{
				$this->rate = $rate;
				$this->service =  html_entity_decode( $info->Package->Postage->MailService );
			}
		}
		else
		{
			foreach($info->Package->Service as $service)
			{
				$last_rate = 10000000;
				$rate = $service->Postage;
				if($rate < $last_rate)
				{
					//get lowest
					$this->highest_rate = $last_rate = $rate;
					$this->duration = $service->SvcCommitments;
					$this->service = html_entity_decode( $service->SvcDescription );
				}
			}
			//get highest of the low
			if($this->highest_rate > $this->rate)
			{
				$this->rate = $this->highest_rate;
			}
		}
	}

	function sendRequest($url, $xml)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "&XML=" . $xml);
		$response = curl_exec($ch);
		//print_r($response);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return simplexml_load_string($response);
	}

}
