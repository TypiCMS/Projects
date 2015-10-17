<?php

namespace TypiCMS\Modules\Projects\Repositories;

use TypiCMS\Modules\Core\Repositories\RepositoryInterface;

interface ProjectInterface extends RepositoryInterface
{
    /**
     * Create a new Article.
     *
     * @param array  Data to create a new object
     *
     * @return bool
     */
    public function create(array $data);

    /**
     * Update an existing Article.
     *
     * @param array  Data to update an Article
     *
     * @return bool
     */
    public function update(array $data);
}
