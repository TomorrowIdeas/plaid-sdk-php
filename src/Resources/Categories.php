<?php

namespace TomorrowIdeas\Plaid\Resources;

class Categories extends AbstractResource
{
	/**
	 * Get all Plaid categories.
	 *
	 * @return object
	 */
	public function list(): object
	{
		return $this->sendRequest("post", "categories/get");
	}
}