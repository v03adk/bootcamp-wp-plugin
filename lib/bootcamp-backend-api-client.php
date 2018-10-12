<?php

class BootcampBackendApiClient
{
	const baseUrl = 'http://bootcamp-backend.unnam.de/api/';

	private $apiKey;

	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function callApi($action, $method, $params = array())
	{
		if (!$this->apiKey) {
			return false;
		}

		$url = self::baseUrl . $action;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json','apikey:'.$this->apiKey, 'Accept:application/json']);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if ($method === 'POST' || $method === 'PUT') {
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		$return = curl_exec($ch);
		$info = curl_getinfo($ch);

		try {
			if ($return || !curl_errno($ch))
			{
				return $this->processReturn($return, $info);
			}
		} catch (\Exception $e) {
		}

		return false;
	}

	private function processReturn($return, $info)
	{
		$result = array('status' => 'error', 'data' => json_decode($return, true));
		switch ($info['http_code'])
		{
			case 200:
			case 201:
			case 204:
				$result['status'] = 'ok';
				return $result;

			case 400:
			case 401:
			case 405:
			case 404:
			default:
				return $result;
		}
	}
}
