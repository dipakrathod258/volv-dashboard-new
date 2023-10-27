<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 17 Dec 2017 14:31:34 +0530.
 */

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

include("simple_dom_html_parser.php");

class ExtractiveService {
//$process = new Process('python /path/to/your_script.py'); //This won't be handy when going to pass argument

	public static function  extractive() {

		$websiteUrl = 'https://www.entrepreneur.com/us';
		$html = file_get_html($websiteUrl);
		// dd($html);
		$urls = array();
		$div = $html->find('.pl-popular');
		$p = $html->find('.pl');
		dd($p);
		// foreach ( as $postDiv) {
		// 	foreach ($postDiv->find('a') as $a) {
		// 		$urls[] = $a->attr['href'];
		// 	}
		// }
		foreach ($urls as $url) {
			$data[] = file_get_html($url);
		}
		dd($data);
	}

}