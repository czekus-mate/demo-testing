<?php
declare(strict_types=1);

namespace Cyclick\Demo;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private array $dependencies = array();

    /**
     * @inheritDoc
     */
    public function get($id) {
        if ($this->dependencies[$id] === null) {
            throw new NotFoundException("Can't find " . $id . "in container.", 1);
        }
        return $this->dependencies[$id];
    }

    /**
     * @inheritDoc
     */
    public function has($id): bool {
        return array_key_exists($id, $this->dependencies);
    }

    /**
     * @param string $id Name of the dependency
     * @param $dependency mixed The dependency implementation
     */
    public function add(string $id, $dependency): void {
        $this->dependencies[$id] = $dependency;
    }
}