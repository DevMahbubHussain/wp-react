<?php

namespace App\JobFind\Traits;

trait DataSanitizer
{
    /**
     * Sanitizes the given input based on the provided type.
     *
     * @param mixed $value The input value to be sanitized.
     * @param string $type The type of the input (e.g., 'text', 'email', 'number').
     * @return mixed The sanitized value.
     */
    public function sanitize($value, string $type)
    {
        // Initialize a variable to store the sanitized result
        $sanitized = '';

        switch ($type) {
            case 'text':
            case 'textarea':
                // For text and textarea inputs, use sanitize_text_field to remove unwanted HTML and special characters.
                $sanitized = sanitize_text_field(wp_unslash($value));
                break;

            case 'number':
                // For number inputs, use absint to ensure the value is an absolute integer.
                $sanitized = absint(wp_unslash($value));
                break;

            case 'email':
                // For email inputs, use sanitize_email to validate and clean up email addresses.
                $sanitized = sanitize_email(wp_unslash($value));
                break;

            case 'switch':
                // For boolean inputs (like toggle switches), cast the value to a boolean.
                $sanitized = (bool) wp_unslash($value);
                break;

            case 'url':
                // For URLs, use esc_url_raw to remove unsafe characters from URLs.
                $sanitized = esc_url_raw(wp_unslash($value));
                break;

            case 'block':
                // For block-type inputs (like Gutenberg blocks), assume the content is already sanitized elsewhere.
                $sanitized = wp_kses_post($value); // Allows safe HTML
                break;

            default:
                // For any other input types, return the original value without sanitization.
                $sanitized = wp_unslash($value);
                break;
        }

        return $sanitized;
    }
}
