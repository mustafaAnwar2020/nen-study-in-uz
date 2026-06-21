<?php

namespace App\Traits;

trait LocalizesValidationRules
{
    /**
     * Append nullable _ar validation rules for string/text fields.
     *
     * @param  array<string, string>  $rules
     * @param  list<string>|null  $only  Limit to these field names; null = all string rules
     * @return array<string, string>
     */
    protected function localizeRules(array $rules, ?array $only = null): array
    {
        $localized = $rules;

        foreach ($rules as $field => $rule) {
            if ($only !== null && ! in_array($field, $only, true)) {
                continue;
            }

            if (! is_string($rule) || ! str_contains($rule, 'string')) {
                continue;
            }

            $arRule = preg_replace('/^required\|/', 'nullable|', $rule) ?? $rule;
            if (! str_starts_with($arRule, 'nullable|')) {
                $arRule = 'nullable|' . ltrim($arRule, '|');
            }

            $localized[$field . '_ar'] = $arRule;
        }

        return $localized;
    }
}
