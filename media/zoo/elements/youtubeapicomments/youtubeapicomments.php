<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// register ElementRepeatable class
App::getInstance('zoo')->loader->register('ElementRepeatable', 'elements:repeatable/repeatable.php');


class ElementYoutubeApiComments extends ElementRepeatable implements iRepeatSubmittable {

	protected function _hasValue($params = array()) {
		$videoIDcomment = $this->get('value');
		$videoIDcomment = rtrim($videoIDcomment);
		if (!empty($videoIDcomment)) {

		$itemurl = JRoute::_($this->app->route->item($this->_item, false), false, 2);
		$apikey = "PLEASE-POST-YOU-API-KEY";
		// get api key -  https://console.developers.google.com/project?pli=1

		echo "<p class='bg-danger'><b>Комментарии с YouTube.com</b></p>";
		   $get_comments = file_get_contents("https://www.googleapis.com/youtube/v3/commentThreads?key=$apikey&part=snippet&videoId=$videoIDcomment&maxResults=50");
		        $comments = json_decode($get_comments, true);
		// echo "<pre>";
		// print_r($comments);
		// echo "</pre>";
		foreach ($comments['items'] as $details) {
		    $authorDisplayName = $details['snippet']["topLevelComment"]['snippet']['authorDisplayName'];
		    $textDisplay = $details['snippet']["topLevelComment"]['snippet']['textDisplay'];
		echo "<blockquote>";
		echo "<p>". $textDisplay . "</p>";
		echo "<footer><cite>". $authorDisplayName . "</cite></footer>";
		echo "</blockquote>";
		}

		}

	}


	protected function _getSearchData() {
		return $this->get('value', $this->config->get('default'));
	}

	protected function _edit() {
		return $this->app->html->_('control.text', $this->getControlName('value'), $this->get('value', $this->config->get('default')), 'size="60" maxlength="255"');
	}


	public function _renderSubmission($params = array()) {
        return $this->_edit();
	}

}