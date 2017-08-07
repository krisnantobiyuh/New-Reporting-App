<?php

namespace App\Controllers\web;

/**
*
*/
abstract class BaseController
{
    protected $container;

    /**
     * Create a new container instance
     *
     * @param $container
     * @return void
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Dynamically access the properties
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }

    // Set Paginate
    public function paginate($total, $perPage, $currentPage, $totalPage)
    {
        return [
            'pagination'    => [
                'total_data'    => $total,
                'per_page'      => $perPage,
                'current_page'  => $currentPage,
                'total_page'    => $totalPage,
            ],
        ];
    }
}
