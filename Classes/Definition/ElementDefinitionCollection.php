<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace MASK\Mask\Definition;

final class ElementDefinitionCollection implements \IteratorAggregate
{
    /**
     * @var array<ElementDefinition>
     */
    private $definitions = [];
    public $table = '';

    public function __construct(string $table = '')
    {
        $this->table = $table;
    }

    public function addElement(ElementDefinition $definition): void
    {
        if (!$this->hasElement($definition->key)) {
            $this->definitions[$definition->key] = $definition;
        }
    }

    public function hasElement(string $key): bool
    {
        return isset($this->definitions[$key]);
    }

    public function getElement(string $key): ElementDefinition
    {
        if ($this->hasElement($key)) {
            return $this->definitions[$key];
        }

        throw new \OutOfBoundsException(sprintf('An element with the key "%s" does not exist in table "%s".', $key, $this->table), 1629292879);
    }

    public static function createFromArray(array $array, string $table): ElementDefinitionCollection
    {
        $elementDefinitionCollection = new self();
        $elementDefinitionCollection->table = $table;
        foreach ($array as $element) {
            $elementDefinitionCollection->addElement(ElementDefinition::createFromArray($element, $table));
        }
        return $elementDefinitionCollection;
    }

    /**
     * @return iterable<ElementDefinition>
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->sort($this->definitions) as $definition) {
            yield $definition;
        }
    }

    public function toArray(): array
    {
        $elements = [];
        foreach ($this->definitions as $element) {
            $elements[$element->key] = $element->toArray();
        }
        return $elements;
    }

    public function count(): int
    {
        return count($this->definitions);
    }

    private function sort($definitions): array
    {
        if (PHP_VERSION_ID < 80000) {
            $this->stable_usort($definitions, static function ($a, $b) {
                return $a->sorting <=> $b->sorting;
            });
        } else {
            usort($definitions, static function ($a, $b) {
                return $a->sorting <=> $b->sorting;
            });
        }

        return $definitions;
    }

    /**
     * Taken from https://wiki.php.net/rfc/stable_sorting
     */
    private function stable_usort(array &$array, callable $compare): void
    {
        $arrayAndPos = [];
        $pos = 0;
        foreach ($array as $value) {
            $arrayAndPos[] = [$value, $pos++];
        }
        usort($arrayAndPos, static function ($a, $b) use ($compare) {
            return $compare($a[0], $b[0]) ?: $a[1] <=> $b[1];
        });
        $array = [];
        foreach ($arrayAndPos as $elem) {
            $array[] = $elem[0];
        }
    }
}
