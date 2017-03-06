<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model 
{

		// Default table name,  can be modified using constructor call.
	private 	$dbtable = 'menus';
	private 	$parent_count;
	public function __construct($dbtablename = null)
	{
		parent::__construct();
		//$this->load->library('ion_auth');

		// Set tablename if passed.  Default is 'owners'
		if ($dbtablename) {
			$this->dbtable = $dbtablename;
		}
	}

	public function load_menu($menu_name, $menu_type)
	{
		$query = $this->db->where('menu_name', $menu_name)->get($this->dbtable);
		$result = $query->row();
		$result =$this->process_menu_dom($result->menu_data, $menu_type);
		
		return ($result);
		#return ($result->menu_data);
	}

	public function save_menu($menu_name, $menu_data)
	{
		$data = array 
		(
			'menu_name' => $menu_name,
			'menu_data' => $menu_data,
			);
		
		$this->db->replace($this->dbtable, $data);
	}

	/**
	 * This processes the raw menu data saved by the editor into a multi-dimensional array.
	 * @param type $html 
	 * @return type
	 */
	private function process_menu_dom($html, $menu_type)
	{
		$html = str_replace( 'ui-sortable-handle', "", $html);
		$html = str_replace( 'ui-sortable', "", $html);
		

		$dom = new DOMDocument;
		$dom->loadHTML($html);

		// Remove spans as they are not needed for the display of the menu.
		$spans = $dom->getElementsByTagName("span");
		while ($spans->length > 0) 
		{
			$span = $spans->item(0);
			$span->parentNode->removeChild($span);
		}

		$menuname = $dom->getElementsByTagName('ul')->item(0)->getAttribute('id');
		$xpath = new DOMXpath($dom);
		$elements = $xpath->query("//ul/li");
		
		$menu_data = array();
		$count=0;

		foreach ($elements as $element) 
		{
			$parent_count = 0;
			if ($this->count_parents($element, $parent_count) <5) {
				$menu_data[$count] = $this->convert_node_to_array($element);
				$menu_data[$count]['submenu'] = array();
				// remove child ul's here.
				$menu_data[$count]['ul_class']	= 'disabled';
			}
			
			if ($element->childNodes->length >=4){
				$subcount = 0;
				$sub = $xpath->query('.//li', $element);

				foreach ($sub as $subli)
				{
					$menu_data[$count]['href_class'] = 'class="dropdown-toggle" data-toggle="dropdown"';
					$menu_data[$count]['ul_class']	= 'dropdown-menu settings-messages';
					if ($menu_type == "vertical") {
						$menu_data[$count]['ul_class']	= 'nav nav-second-level';
					}
					
					if (!strpos($menu_data[$count]['icon'],'fa arrow') && $menu_type == "vertical") 
					{
						$menu_data[$count]['icon'] = $menu_data[$count]['icon'] . '<span class="fa arrow"></span>';
					}

					$menu_data[$count]['submenu'][$subcount] = $this->convert_node_to_array($subli);
					if (!strpos($menu_data[$count]['icon'],'caret-down') && $menu_type == "horizontal") 
					{
						$menu_data[$count]['icon'] .= '<i class="fa fa-caret-down"></i>';
					}
					$subcount++;
				}
			}
			$count++;
		}
		return ($menu_data);
	}

	private function convert_node_to_array($node) 
	{
		$result = array();
		if ($node->hasAttribute('class'))
		{
			$class = $node->getAttribute('class');
			if (strpos($class ,'divider') !== FALSE)
			{
				$result['id'] = '';
				$result['href'] = '';
				$result['footer'] = '<li class="divider"></li>';
				$result['icon'] = '';
				$result['title'] = '';

				return $result;
			}
		}
		$result['id'] = $node->attributes->getNamedItem('id')->value;
		$result['href'] = $node->getElementsByTagName('a')->item(0)->attributes->getNamedItem('href')->value;
		$result['title'] = $node->getElementsByTagName('a')->item(0)->nodeValue;
		$result['icon'] = '';
		$result['footer'] = '';
		// Check for icon in <i> tags,  <i> tag should be within the menu items <a> tag.
		if ($node->getElementsByTagName('i')->length >0)
		{
			$icons = $node->getElementsByTagName('i');
			foreach ($icons as $icon) 
			{
				if ($icon->parentNode->parentNode === $node)
				{
					$result['icon'] = '<i class="' . ($node->getElementsByTagName('i')->item(0)->attributes->getNamedItem('class')->value) . '"></i>';
				}
			}
		}
		return $result;
	}

	private function count_parents($element, &$current_count) {
		if ($node = $element->parentNode) {
			$current_count++;
			$this->count_parents($node, $current_count);
		}
		return ($current_count);
	}
}
