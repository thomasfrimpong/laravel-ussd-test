<?php

namespace Vendor\LaravelUssd\Menu;

/**
 * Fluent menu builder for USSD applications.
 *
 * Provides a chainable API for constructing USSD menus with text, options,
 * listings, and pagination support. Menus are rendered as plain text strings
 * suitable for USSD gateways.
 */
class Menu
{
    /**
     * @var array<string> Menu lines to be rendered
     */
    protected array $lines = [];

    /**
     * @var bool Whether the menu expects user input
     */
    protected bool $expectsInput = false;

    /**
     * @var bool Whether expectsInput was explicitly set
     */
    protected bool $expectsInputExplicitlySet = false;

    /**
     * Add a text line to the menu.
     *
     * @param string $text Text content to add
     * @return self For method chaining
     */
    public function text(string $text): self
    {
        $this->lines[] = $text;

        return $this;
    }

    /**
     * Add an empty line or line with text to the menu.
     *
     * Useful for spacing between menu sections.
     *
     * @param string $text Optional text content (empty string for blank line)
     * @return self For method chaining
     */
    public function line(string $text = ''): self
    {
        $this->lines[] = $text;

        return $this;
    }

    /**
     * Add a numbered option to the menu.
     *
     * Formats as "key. label" (e.g., "1. View Balance").
     *
     * @param string $key Option key/number that user will input
     * @param string $label Option label/description
     * @return self For method chaining
     */
    public function option(string $key, string $label): self
    {
        $this->lines[] = sprintf('%s. %s', $key, $label);

        return $this;
    }

    /**
     * Add a numbered listing of items.
     *
     * Automatically numbers items starting from 1.
     *
     * @param array $items Array of items to list
     * @return self For method chaining
     */
    public function listing(array $items): self
    {
        foreach ($items as $index => $item) {
            $this->option((string) ($index + 1), (string) $item);
        }

        return $this;
    }

    /**
     * Add a paginated listing of items.
     *
     * Splits items into pages and adds a "More" option if there are additional pages.
     *
     * @param array $items Array of items to paginate
     * @param int $perPage Number of items per page
     * @param int $page Current page number (1-indexed)
     * @return self For method chaining
     */
    public function paginate(array $items, int $perPage, int $page = 1): self
    {
        // Split items into chunks
        $chunks = array_chunk($items, $perPage);
        // Ensure page is within valid range
        $page = max(1, min($page, count($chunks)));

        // Add items for current page
        $this->listing($chunks[$page - 1] ?? []);

        // Add "More" option if there are additional pages
        if ($page < count($chunks)) {
            $this->option('0', 'More');
        }

        return $this;
    }

    /**
     * Set whether the menu expects user input.
     *
     * This determines if the response should be CON (expects input) or END (no input).
     *
     * @param bool $expectsInput Whether input is expected
     * @return self For method chaining
     */
    public function expectsInput(bool $expectsInput = true): self
    {
        $this->expectsInput = $expectsInput;
        $this->expectsInputExplicitlySet = true;

        return $this;
    }

    /**
     * Render the menu as a formatted string.
     *
     * Joins all lines with newlines and optionally appends a suffix.
     *
     * @param string $suffix Optional suffix to append after all lines
     * @return string Formatted menu text
     */
    public function render(string $suffix = ''): string
    {
        $body = implode("\n", $this->lines);

        if ($suffix !== '') {
            $body .= "\n" . $suffix;
        }

        return $body;
    }

    /**
     * Check if the menu expects user input.
     *
     * @return bool True if input is expected
     */
    public function needsInput(): bool
    {
        return $this->expectsInput;
    }

    /**
     * Check if expectsInput was explicitly set on this menu.
     *
     * @return bool True if expectsInput was explicitly set
     */
    public function hasExplicitInputExpectation(): bool
    {
        return $this->expectsInputExplicitlySet;
    }
}
