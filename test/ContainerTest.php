<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);


use Cyclick\Demo\Container;
use Cyclick\Demo\NotFoundException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @covers \Cyclick\Demo\Container::add
     */
    public function testAdd() {
        $di = new Container();
        $reflector = new ReflectionClass($di);
        $di->add("test", "hello");
        $dependencies = $reflector->getProperty("dependencies");
        $dependencies->setAccessible(true);
        $this->assertArrayHasKey("test", $dependencies->getValue($di));
        $this->assertEquals("hello", $dependencies->getValue($di)["test"]);
    }

    /**
     * @covers \Cyclick\Demo\Container::get
     */
    public function testGet() {
        $di = new Container();
        $reflector = new ReflectionClass($di);
        $dependencies = $reflector->getProperty("dependencies");
        $dependencies->setAccessible(true);
        $dependencies->setValue($di, ["hello" => "world"]);
        $this->assertEquals("world", $di->get("hello"));
        $this->expectException(NotFoundException::class);
        $di->get("test");
    }

    /**
     * @covers \Cyclick\Demo\Container::has
     */
    public function testHas() {
        $di = new Container();
        $reflector = new ReflectionClass($di);
        $dependencies = $reflector->getProperty("dependencies");
        $dependencies->setAccessible(true);
        $dependencies->setValue($di, ["testing" => "good"]);
        $this->assertTrue($di->has("testing"));
        $this->assertFalse($di->has("hello"));
    }
}
