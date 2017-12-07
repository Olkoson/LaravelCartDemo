<?php

namespace Tests\Unit;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowserProductsTest extends BrowserKitTestCase
{
    public function testDisplaysCart()
    {
        $this->visit('/products')
            ->see('Products');
    }
}
