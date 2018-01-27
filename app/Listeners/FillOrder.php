<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Repositories\OrderRepository;

class FillOrder
{

	/**
	 * @var OrderRepository
	 */
	private $repository;

	/**
	 * Create the event listener.
	 *
	 * @param OrderRepository $repository
	 */
	public function __construct(OrderRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Handle the event.
	 *
	 * @param  OrderCreated $event
	 * @return void
	 * @throws \Exception
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 * @throws \Prettus\Repository\Exceptions\RepositoryException
	 * @throws \Throwable
	 */
	public function handle(OrderCreated $event)
	{
		$this->repository->fillOrder($event->order);
	}
}
