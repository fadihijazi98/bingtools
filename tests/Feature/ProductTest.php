<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    protected $product;

    function setUp(): void
    {
        $this->product = new Product('i11 airpods', 150);
    }

    /** @test */
    public function a_product_has_name()
    {
        $this->assertEquals('i11 airpods', $this->product->getName());
    }

    /** @test */
    public function a_product_has_cost()
    {
        $this->assertEquals(150, $this->product->getCost());
    }

}
