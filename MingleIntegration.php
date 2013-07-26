<?php
require(__DIR__.'/lib/MingleClient.php');

/**
 * A plugin for creating Mingle cards out of Mantis bugs.
 * 
 * @see http://www.thoughtworks-studios.com/mingle-agile-project-management
 */
class MingleIntegrationPlugin extends MantisPlugin
{
	public function register()
	{
		$this->name = 'Mingle Integration';
		$this->description = plugin_lang_get('description');
		$this->page = 'config';
		$this->version = '0.3.3';
		$this->requires = array('MantisCore' => '>= 1.2.0');
		$this->author = 'AramisAuto.com';
		$this->contact = 'tristan.rivoallan@aramisauto.com';
		$this->url = '';
	}

	function install() {
		if (!extension_loaded('curl')) {
			error_parameters(plugin_lang_get('error_no_curl'));
			trigger_error(ERROR_PLUGIN_INSTALL_FAILED, ERROR);
			return false;
		} else {
			return true;
		}
	}

	public function hooks()
	{
		return array(
			'EVENT_VIEW_BUG_EXTRA' => 'onViewBugExtra',
		);
	}

	/**
	 * Default plugin configuration.
	 */
	public function config() {
		return array(
			'mingle_url_instance'        => '',
			'project'                    => '',
			'default_card_type'          => '',
			'mingle_username'            => '',
			'mingle_password'            => '',
			'additional_card_attributes' => array()
		);
	}

	protected function render($viewName, array $parameters = array())
	{
		// Sanity check
		$pathView = sprintf('%s/views/%s.php', __DIR__, $viewName);
		if (!is_readable($pathView)) {
			throw new InvalidArgumentException(
				sprintf(
					'Could not find view "%s" at "%s"', 
					$viewName, 
					$pathView
				)
			);
		}

		// Render view
		ob_start();
		extract($parameters);
		include($pathView);
		$view = ob_get_contents();
		ob_end_clean();

		return $view;
	}

	public function errors() {
		return array('a');
	}

	/**
	* @see http://docs.mantisbt.org/master/en/developers.html#DEV.EVENTS
	* @see http://www.thoughtworks-studios.com/mingle/3.2/help/mingle_api_card.html
	*/
	public function onViewBugExtra($event_name, $bug_id)
	{
		$htmlOut = '';

		// Retrieve current bug data
		$bug = bug_get($bug_id, true);

		if (count(plugin_config_get('additional_card_attributes'))) {
			$mql_additional = ', ' . implode(', ', plugin_config_get('additional_card_attributes'));
		} else {
			$mql_additional = '';
		}

		$mql = sprintf(
			'SELECT Number, Type, Name %s WHERE "Mantis Issue ID" = %s',
			$mql_additional, 
			$bug_id
		);

		// Mingle API client
		$mingle = new MingleClient(
			plugin_config_get('mingle_url_instance'), 
			plugin_config_get('mingle_username'), 
			plugin_config_get('mingle_password')
		);

		try {
			// Search for already existing Mingle card
			$results = $mingle->executeMql(plugin_config_get('project'), $mql);

			// Mingle card does not already exist : display card creation button
			if (count($results) === 0) {
				$htmlOut = $this->render(
					'mingle_card_absent', 
					array(
						'mantisBug'      => $bug,
						'mantisUrl'      => sprintf('http://%s%s', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']),
						'mingleCardType' => plugin_config_get('default_card_type'),
						'mingleProject'  => plugin_config_get('project'),
						'mingleUrl'      => plugin_config_get('mingle_url_instance'),
					)
				);
			} else {
				$htmlOut = $this->render(
					'mingle_card_present',
					array(
						'card'    => $results[0],
						'urlCard' => sprintf(
							'%s/projects/%s/cards/%d', 
							plugin_config_get('mingle_url_instance'), 
							plugin_config_get('project'), 
							$results[0]['number']
						)
					)
				);
			}
		} catch (RuntimeException $e) {
			$htmlOut = $this->render('error', array('message' => $e->getMessage()));
		}

		echo $htmlOut;
		return;
	}
}