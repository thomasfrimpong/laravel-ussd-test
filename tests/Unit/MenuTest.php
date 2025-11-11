<?php

namespace Vendor\LaravelUssd\Tests\Unit;

use Vendor\LaravelUssd\Menu\Menu;
use Vendor\LaravelUssd\Tests\TestCase;

class MenuTest extends TestCase
{
    public function test_menu_builder_creates_text(): void
    {
        $menu = (new Menu())->text('Hello World');

        $this->assertStringContainsString('Hello World', $menu->render());
    }

    public function test_menu_builder_creates_options(): void
    {
        $menu = (new Menu())
            ->text('Choose an option:')
            ->option('1', 'First Option')
            ->option('2', 'Second Option');

        $rendered = $menu->render();

        $this->assertStringContainsString('1. First Option', $rendered);
        $this->assertStringContainsString('2. Second Option', $rendered);
    }

    public function test_menu_builder_creates_listing(): void
    {
        $menu = (new Menu())
            ->listing(['Apple', 'Banana', 'Cherry']);

        $rendered = $menu->render();

        $this->assertStringContainsString('1. Apple', $rendered);
        $this->assertStringContainsString('2. Banana', $rendered);
        $this->assertStringContainsString('3. Cherry', $rendered);
    }

    public function test_menu_builder_paginates_items(): void
    {
        $items = ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5'];
        $menu = (new Menu())->paginate($items, 2, 1);

        $rendered = $menu->render();

        $this->assertStringContainsString('1. Item 1', $rendered);
        $this->assertStringContainsString('2. Item 2', $rendered);
        $this->assertStringContainsString('0. More', $rendered);
        $this->assertStringNotContainsString('Item 3', $rendered);
    }

    public function test_menu_expects_input(): void
    {
        $menu = (new Menu())->expectsInput(true);

        $this->assertTrue($menu->needsInput());
    }
}

