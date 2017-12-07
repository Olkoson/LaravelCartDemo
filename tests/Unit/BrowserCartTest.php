<?php

namespace Tests\Unit;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowserCartTest extends BrowserKitTestCase
{
    public function testDisplaysCart()
    {
        $this->visit('/cart')
            ->see('Cart');
    }
}
