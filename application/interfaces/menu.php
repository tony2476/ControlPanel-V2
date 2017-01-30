<?php defined('BASEPATH') OR exit('No direct script access allowed');

interface menu_loader {
	public function load_menu($menu_name);
	public function save_menu($menu_name);
	public function create_menu($menu_name);
	public function delete_menu($menu_name);
}