<?php

class BootcampWpPluginAuthors
{
	private $client;

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function index()
	{
		$authors = [];
		$data = $this->client->callApi('authors?pagination=false', 'GET');
		if ($data['status'] === 'ok') {
			$authors = $data['data'];
		}

		require_once('templates/authors/index.html.php');
	}

	public function update()
	{
		$authorId = $_GET['id'];
		$author = null;
		$error = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$authorData = $_POST['author'];
			if ($authorId) {
				$data = $this->client->callApi('authors/'.$authorId, 'PUT', $authorData);
			} else {
				$data = $this->client->callApi('authors', 'POST', $authorData);
			}

			if ($data['status'] === 'ok') {
				wp_redirect(admin_url('admin.php?page=BootcampWpPlugin_PluginAuthors'));
			}

			$error = implode('; ', $data['data']);
		}

		if ($authorId && $_SERVER['REQUEST_METHOD'] === 'GET') {
			$data = $this->client->callApi('authors/'.$authorId, 'GET');
			if ($data['status'] === 'ok') {
				$author = $data['data'];
			}
		}

		require_once('templates/authors/update.html.php');
	}

	public function delete()
	{
		$authorId = $_GET['id'];
		if ($authorId) {
			$this->client->callApi('authors/'.$authorId, 'DELETE');
		}

		require_once('templates/authors/delete.html.php');
	}
}
