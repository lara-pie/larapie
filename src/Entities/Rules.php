<?php

namespace Larapie\Larapie\Entities;

final class Rules
{
    private array $rules;

    public const CLOSURE_FUNCTION = 'closure-function';

    /**
     * Rules constructor.
     * @param  array  $rules
     */
    public function __construct(array $rules)
    {
        $this->parseRules($rules);
    }

    /**
     * @param  array  $rules
     */
    private function parseRules(array $rules)
    {
        foreach ($rules as $key => $value) {
            if (is_string($value)) {
                $this->parseRulesString($key, $value);
            } elseif (is_array($value)) {
                $this->parseArray($key, $value);
            } elseif (is_callable($value)) {
                $this->setHasClosure($key);
            } elseif (is_object($value)) {
                $this->parseClass($key, $value);
            }
        }
    }

    /**
     * @param  string  $key
     * @param $object
     */
    private function parseClass(string $key, $object)
    {
        $this->rules[$key][] = mb_strtolower(class_basename($object));
    }

    /**
     * @param  string  $key
     * @param  string  $rules
     */
    private function parseRulesString(string $key, string $rules)
    {
        $this->rules[$key] = explode('|', $rules);
    }

    /**
     * @param  string  $key
     * @param  array  $rules
     */
    private function parseArray(string $key, array $rules)
    {
        foreach ($rules as $rule) {
            if (is_string($rule)) {
                $this->rules[$key][] = $rule;
            } elseif (is_array($rule) && count($rule) === 1 && isset($rule[0]) && is_string($rule[0])) {
                $this->rules[$key][] = $rule[0];
            } elseif (is_callable($rule)) {
                $this->setHasClosure($key);
            } elseif (is_object($rule)) {
                $this->parseClass($key, $rule);
            }
        }
    }

    /**
     * @param  string  $key
     */
    private function setHasClosure(string $key)
    {
        if (array_search(self::CLOSURE_FUNCTION, $this->rules[$key]) === false) {
            $this->rules[$key][] = self::CLOSURE_FUNCTION;
        }
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}