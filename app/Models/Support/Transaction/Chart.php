<?php

namespace App\Models\Support\Transaction;

use ArrayAccess;
use InvalidArgumentException;

class Chart implements ArrayAccess
{
    /** @var ChartNode[] $nodes */
    public array $nodes = [];
    
    
    public static function extractScales(float $maxValue, int $scaleCount = 3): array
    {
        // Ensures the max value is divisible by $scaleCount
        $part = $maxValue / $scaleCount;
        
        $scales = [];
        for ($i = 0; $i < $scaleCount; $i++) {
            $scales[] = static::formatScale($i * $part);
        }
        $scales[] = static::formatScale($maxValue);
        
        return array_reverse($scales);
    }
    
    
    private static function formatScale(float $scale): string {
        return (int)(round($scale, -3) / 1000) . ' K';
    }
    
    
    public function calculatePercents(float $max): void
    {
        $length = count($this->nodes);
        
        for ($i = 0; $i < $length; $i++) {
            $this->nodes[$i]->percent = $this->nodes[$i]->value / $max * 100;
        }
    }
    
    
    public function max(): float
    {
        return $this->nodes[array_key_last($this->nodes)]->value ?? 0;
    }
    
    
    public function offsetSet($offset, $value): void
    {
        if (get_class($value) != ChartNode::class) {
            throw new InvalidArgumentException('Expected ChartNode, got ' . get_class($value));
        }
        
        if (is_null($offset)) {
            $this->nodes[] = $value;
        } else {
            $this->nodes[$offset] = $value;
        }
    }
    
    public function offsetExists($offset): bool
    {
        return isset($this->nodes[$offset]);
    }
    
    public function offsetUnset($offset): void
    {
        unset($this->nodes[$offset]);
    }
    
    /**
     * @param $offset
     * @return ChartNode
     */
    public function offsetGet($offset): mixed
    {
        return $this->nodes[$offset] ?? null;
    }
}