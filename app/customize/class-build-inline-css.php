<?php
/**
 * Build inline CSS.
 *
 * @see https://github.com/thethemefoundry/make/blob/master/src/inc/style/css.php
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

namespace BigBox\Customize;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * This class provides a mechanism to gather all of the CSS needed to implement theme settings. It allows for handling
 * of conflicting rules and sorts out what the final CSS should be. The primary function is `add()`. It allows the
 * caller to add a new rule to be generated in the CSS.
 *
 * @since 1.0.0
 */
class Build_Inline_CSS {

	/**
	 * The array for storing added CSS rule data.
	 *
	 * @since 1.0.0
	 *
	 * @var array Holds the data to be printed out.
	 */
	private $data = [];

	/**
	 * Optional line ending character for debug mode.
	 *
	 * @since 1.0.0
	 *
	 * @var string Line ending character used to better style the CSS.
	 */
	private $line_ending = '';

	/**
	 * Optional tab character for debug mode.
	 *
	 * @since 1.0.0
	 *
	 * @var string Tab character used to better style the CSS.
	 */
	private $tab = '';

	/**
	 * Optional space character for debug mode.
	 *
	 * @since 1.7.0.
	 *
	 * @var string    Space character used to better style the CSS.
	 */
	private $space = '';

	/**
	 * Add a new CSS rule to the array.
	 *
	 * Accepts data to eventually be turned into CSS. Usage:
	 *
	 * $this->add( [
	 *     'selectors'    => [ '.site-header-main' ],
	 *     'declarations' => [
	 *         'background-color' => '#00ff00',
	 *     ],
	 *     'media' => 'screen and (min-width: 800px)',
	 * ] );
	 *
	 * Selectors represent the CSS selectors; declarations are the CSS properties and values with keys being properties
	 * and values being values. 'media' can also be declared to specify the media query.
	 *
	 * Note that data *must* be sanitized when adding to the data array. Because every piece of CSS data has special
	 * sanitization concerns, it must be handled at the time of addition, not at the time of output. The theme handles
	 * this in the the other helper files, i.e., the data is already sanitized when `add()` is called.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data The selectors and properties to add to the CSS.
	 */
	public function add( array $data ) {
		$entry = [];

		/**
		 * Filter: Modify CSS rules as they are registered.
		 *
		 * @since 1.0.0
		 *
		 * @param array $data The selectors and properties to add to the CSS.
		 */
		$data = apply_filters( 'bigbox_css_add', $data );

		// Bail if the required properties aren't present.
		if ( ! isset( $data['selectors'] ) || ! isset( $data['declarations'] ) ) {
			return;
		}

		// Sanitize selectors.
		$entry['selectors'] = array_map( 'trim', (array) $data['selectors'] );
		$entry['selectors'] = array_unique( $entry['selectors'] );

		// Sanitize declarations.
		$entry['declarations'] = array_map( 'trim', (array) $data['declarations'] );

		// Check for media query.
		if ( isset( $data['media'] ) ) {
			$media = $data['media'];
		} else {
			$media = 'all';
		}

		// Create new media query if it doesn't exist yet.
		if ( ! isset( $this->data[ $media ] ) || ! is_array( $this->data[ $media ] ) ) {
			$this->data[ $media ] = [];
		}

		// Look for matching selector sets.
		$match = false;
		foreach ( $this->data[ $media ] as $key => $rule ) {
			$diff1 = array_diff( $rule['selectors'], $entry['selectors'] );
			$diff2 = array_diff( $entry['selectors'], $rule['selectors'] );
			if ( empty( $diff1 ) && empty( $diff2 ) ) {
				$match = $key;
				break;
			}
		}

		// No matching selector set, add a new entry.
		if ( false === $match ) {
			$this->data[ $media ][] = $entry;
		} else {
			$this->data[ $media ][ $match ]['declarations'] = array_merge( $this->data[ $media ][ $match ]['declarations'], $entry['declarations'] );
		}
	}

	/**
	 * Check if there are any items in the private data property array.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function has_rules() {
		return ! empty( $this->data );
	}

	/**
	 * Compile the data array into standard CSS syntax
	 *
	 * @since 1.0.0.
	 *
	 * @return string The CSS that is built from the data.
	 */
	public function build() {
		if ( ! $this->has_rules() ) {
			return '';
		}

		$n = $this->line_ending;
		$s = $this->space;

		// Make sure the 'all' array is first.
		if ( isset( $this->data['all'] ) && count( $this->data ) > 1 ) {
			$all = [ 'all' => $this->data['all'] ];
			unset( $this->data['all'] );
			$this->data = array_merge( $all, $this->data );
		}

		$output = '';

		foreach ( $this->data as $query => $ruleset ) {
			$t = '';

			if ( 'all' !== $query ) {
				$output .= "\n@media " . $query . $s . '{' . $n;
				$t       = $this->tab;
			}

			// Build each rule.
			foreach ( $ruleset as $rule ) {
				$output .= $this->parse_selectors( $rule['selectors'], $t ) . $s . '{' . $n;
				$output .= $this->parse_declarations( $rule['declarations'], $t );
				$output .= $t . '}' . $n;
			}

			if ( 'all' !== $query ) {
				$output .= '}' . $n;
			}
		}

		return $output;
	}

	/**
	 * Compile the selectors in a rule into a string.
	 *
	 * @since  1.0.0
	 *
	 * @param array  $selectors Selectors to combine into single selector.
	 * @param string $tab Tab character.
	 *
	 * @return string
	 */
	private function parse_selectors( $selectors, $tab = '' ) {
		/**
		 * Note that these selectors are hardcoded in the code base. They are never the result of user input and can
		 * thus be trusted to be sane.
		 */
		$n      = $this->line_ending;
		$output = $tab . implode( ",{$n}{$tab}", $selectors );

		return $output;
	}

	/**
	 * Compile the declarations in a rule into a string.
	 *
	 * @since  1.0.0
	 *
	 * @param array  $declarations Declarations for a selector.
	 * @param string $tab Tab character.
	 *
	 * @return string
	 */
	private function parse_declarations( $declarations, $tab = '' ) {
		$n = $this->line_ending;
		$t = $this->tab . $tab;
		$s = $this->space;

		$output = '';

		/**
		 * Note that when this output is prepared, it is not escaped, sanitized or otherwise altered.
		 */
		foreach ( $declarations as $property => $value ) {
			$parsed_value = "{$t}{$property}:{$s}{$value};$n";

			/**
			 * Filter: Modify the final CSS declaration after being parsed.
			 *
			 * @since 1.0.0
			 *
			 * @param string $parsed_value The full CSS declaration.
			 * @param string $property     The property being parsed.
			 * @param string $value        The value for the property.
			 * @param string $t            The tab character.
			 * @param string $n            The newline character.
			 */
			$output .= apply_filters( 'bigbox_parse_declaration', $parsed_value, $property, $value, $t, $n );
		}

		/**
		 * Filter: Modify the full list of parsed declarations.
		 *
		 * @since 1.0.0
		 *
		 * @param string $output       The full CSS output.
		 * @param array  $declarations The list of CSS declarations.
		 * @param string $tab          The tab character.
		 */
		return apply_filters( 'bigbox_css_parse_declarations', $output, $declarations, $tab );
	}
}
