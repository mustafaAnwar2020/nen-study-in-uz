<?php

namespace App\Traits;

trait LocalizesValidationRules
{
    /**
     * Append nullable localized validation rules for string/text fields.
     *
     * @param  array<string, string>  $rules
     * @param  list<string>|null  $only  Limit to these field names; null = all string rules
     * @return array<string, string>
     */
    protected function localizeRules(array $rules, ?array $only = null): array
    {
        $localized = $rules;
        $suffixes = array_values(config('locales.db_suffix', ['ar' => '_ar']));

        foreach ($rules as $field => $rule) {
            if ($only !== null && ! in_array($field, $only, true)) {
                continue;
            }

            if (! is_string($rule) || ! str_contains($rule, 'string')) {
                continue;
            }

            $localizedRule = preg_replace('/^required\|/', 'nullable|', $rule) ?? $rule;
            if (! str_starts_with($localizedRule, 'nullable|')) {
                $localizedRule = 'nullable|' . ltrim($localizedRule, '|');
            }

            foreach ($suffixes as $suffix) {
                $localized[$field . $suffix] = $localizedRule;
            }
        }

        return $localized;
    }
}
