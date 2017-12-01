<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesTest extends TestCase
{
    /**
     * Test if home page loads
     *
     * @return void
     */
    public function testLoadIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

	/**
	 * Test if exchange page loads
	 *
	 * @return void
	 */
	public function testLoadExchange()
	{
		$response = $this->get('/');

		$response->assertStatus(200);
	}
}
