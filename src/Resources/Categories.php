<?php

namespace TomorrowIdeas\Plaid\Resources;

class Categories extends AbstractResource
{
	/**
	 * Get all Plaid categories.
	 *
	 * @deprecated 1.1 Use list() method.
	 * @return object
	 */
	public function getCategories(): object
	{
		return $this->list();
	}

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