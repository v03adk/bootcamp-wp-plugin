<?php

class BootcampWpPluginQuotes
{
	private $client;

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function index()
	{
		$quotes = [];
		$data = $this->client->callApi('quotes?pagination=false', 'GET');
		if ($data['status'] === 'ok') {
			$quotes = $data['data'];
		}

		require_once('templates/quotes/index.html.php');
	}

	public function update()
	{
		$quoteId = $_GET['id'];
		$quote = null;
		$error = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$quoteData = $_POST['quote'];
			if ($quoteId) {
				$data = $this->client->callApi('quotes/'.$quoteId, 'PUT', $quoteData);
			} else {
				$data = $this->client->callApi('quotes', 'POST', $quoteData);
			}

			if ($data['status'] === 'ok') {
				wp_redirect(admin_url('admin.php?page=BootcampWpPlugin_PluginQuotes'));
			}

			$error = implode('; ', $data['data']);
		}

		$authors = [];
		$authorsData = $this->client->callApi('authors', 'GET');
		if ($authorsData['status'] === 'ok') {
			$authors = $authorsData['data'];
		}

		if ($quoteId && $_SERVER['REQUEST_METHOD'] === 'GET') {
			$data = $this->client->callApi('quotes/'.$quoteId, 'GET');
			if ($data['status'] === 'ok') {
				$quote = $data['data'];
			}
		}

		require_once('templates/quotes/update.html.php');
	}

	public function delete()
	{
		$quoteId = $_GET['id'];
		if ($quoteId) {
			$this->client->callApi('quotes/'.$quoteId, 'DELETE');
		}

		require_once('templates/quotes/delete.html.php');
	}

	public function getRandomQuote()
	{
		$data = $this->client->callApi('quotes/random', 'GET');
		if ($data['status'] === 'ok') {
			return [
				'quote' => $data['data']['quote'],
				'author' => sprintf('%s %s %s', $data['data']['author']['firstname'], $data['data']['author']['middlename'], $data['data']['author']['lastname']),
				'authorId' => $data['data']['author']['id']
			];
		}

		return false;
	}

	public function getAuthorsQuotes()
	{
		$authorId = $_GET['authorId'];

		if ($authorId) {
			$data = $this->client->callApi('quotes?author='.$authorId, 'GET');
			if ($data['status'] === 'ok') {
				$quotes = $data['data'];
				ob_start();
				require_once('templates/quotes/author_quotes.html.php');

				echo ob_get_clean();
			}
		}

		echo '';
	}
}
