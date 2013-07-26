<?php
class MingleClient
{
	protected $curlHandle;
	protected $uriApi;
	protected $urlMingle;

	public function __construct($urlMingle, $username, $password, $uriApi = '/api/v2')
	{
		// Store Mingle base URL and API URI
		$this->urlMingle = $urlMingle;
		$this->uriApi = $uriApi;

		// Instanciate and configure curl handle
		$this->curlHandle = curl_init();
		curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($this->curlHandle, CURLOPT_USERPWD, sprintf('%s:%s', $username, $password)); 
	}

	public function executeMql($project, $mql)
	{
		// Fetch data
		$resultsRaw = $this->request(
			sprintf(
				'/projects/%s/cards/execute_mql.xml?mql=%s', 
				$project, 
				urlencode($mql)
			)
		);

		// Cleanup data		
		$results = array();
		foreach ($resultsRaw as $result) {
			foreach ($result as $attribute => $value) {
				if (is_array($value)) {
					$value = null;
				}
				$result[$attribute] = $value;
			}

			// Sort attributes
			ksort($result);
			
			$results[] = $result;
		}

		return $results;
	}

	public function getProjects()
	{
		return $this->request('/projects.xml');
	}

	protected function request($uri, $method = 'GET')
	{
		// Complete curl handle configuration
		$url = sprintf('%s%s%s', $this->urlMingle, $this->uriApi, $uri);
		curl_setopt($this->curlHandle, CURLOPT_URL, $url);
		curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, $method);

		// Perform request
		$results = trim(curl_exec($this->curlHandle));
		$infos = curl_getinfo($this->curlHandle);

		// Handle connectivity errors
		if ($results === false) {
			throw new RuntimeException(
				sprintf(
					'An error occured while calling URL "%s" : %s (%s)', 
					$url, 
					curl_error($this->curlHandle), 
					curl_errno($this->curlHandle)
				)
			);
		}

		// Handle malformed XML response body
		$xml = simplexml_load_string($results);
		if ($xml === false) {
			throw new RuntimeException(
				sprintf(
					'An error occured while calling URL "%s" : Malformed XML response : %s (%s)', 
					$url, 
					$results, 
					$infos['http_code']
				)
			);
		}

		// Convert XML to array
		$json = json_encode($xml);
		$results = json_decode($json, true);

		// Handle bad response code
		if (substr($infos['http_code'], 0, 2) != '20') {
			throw new RuntimeException(
				sprintf(
					'An error occured while calling URL "%s" : %s (%s)', 
					$url, 
					$results['error'], 
					$infos['http_code']
				)
			);
		}

		// Handle no results
		if (!isset($results['result'])) {
			$results = array();
		} else {
			$results = array($results['result']);
		}

		return $results;
	}
}