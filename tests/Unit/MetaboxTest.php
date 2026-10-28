<?php

declare(strict_types=1);

namespace WonderWp\Component\Panel\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WonderWp\Component\Panel\Metabox\Metabox;

final class MetaboxTest extends TestCase
{
    public function testConstructorStoresIdAndTitle(): void
    {
        $box = new Metabox('my-id', 'My title');
        $this->assertSame('my-id', $box->getId());
        $this->assertSame('My title', $box->getTitle());
    }
}
