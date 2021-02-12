<?php

namespace Larapie\Larapie\Parser;

use Larapie\Larapie\Entities\Rules;
use Illuminate\Http\Request;

final class RulesParser
{
    /**
     * @param  string  $requestClassName
     * @return Rules|null
     */
    public function parse(string $requestClassName): ?Rules
    {
        try {
            $request = $this->makeRequest($requestClassName);
        } catch (\Exception $exception) {
            return null;
        }
        $rules = $this->tryGettingRules($request);

        return $rules ? new Rules($rules) : null;
    }

    /**
     * @param  string  $requestClassName
     * @return Request
     */
    private function makeRequest(string $requestClassName): Request
    {
        return new $requestClassName;
    }

    /**
     * @param  Request  $request
     * @return array
     */
    private function tryGettingRules(Request $request): array
    {
        try {
            $result = $request->rules();
        } catch (\Exception $exception) {
            return [];
        }

        return is_array($result) ? $result : [];
    }
}