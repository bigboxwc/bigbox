/* global wp, bigboxCustomizeControls, _, Event */

const { fontList } = bigboxCustomizeControls.typography;

/**
 * Build HTML <option>s for font families.
 *
 * @return {string} String of HTML <option>s.
 */
const getFamilyOptions = () => {
	const options = [];

	_.each( fontList, ( data ) => {
		const familyOption = document.createElement( 'option' );

		familyOption.value = data.family;
		familyOption.text = data.family;
		familyOption.dataset.variants = data.variants.join( ',' );
		familyOption.dataset.category = data.category;

		options.push( familyOption );
	} );

	return options;
};

/**
 * Build HTML <option>s for weight variants.
 *
 * @param  {Array} variants List of variants.
 * @return {string} String of HTML <option>s.
 */
const getWeightOptions = ( variants ) => {
	const options = [];

	_.each( variants, ( variant ) => {
		if ( ! isNaN( variant ) || 'regular' === variant ) {
			const weightOption = document.createElement( 'option' );

			weightOption.value = variant;
			weightOption.text = variant;

			options.push( weightOption );
		}
	} );

	return options;
};

/**
 * Update weight fields with available options.
 *
 * @param {Array} variants List of variants.
 */
const updateWeightFields = ( variants ) => {
	_.each( [ 'base', 'bold' ], ( weight ) => {
		const control = wp.customize.control( `type-font-weight-${ weight }` );
		const value = control.setting();

		// Bring back to standard DOM element.
		const selectEl = control.container.find( 'select' ).get( 0 );

		selectEl.innerHTML = '';

		// Add HTML and select chosen item.
		getWeightOptions( variants ).forEach( ( familyWeight ) => selectEl.options.add( familyWeight ) );

		// Determine if the previous value can be carried over.

		// Value still exists.
		if ( variants[ value ] ) {
			selectEl.value = value;
		} else {
			const first = selectEl.options[ 0 ];
			const last = selectEl.options[ selectEl.options.length - 1 ];

			// Select first if no previous item remains.
			if ( 'base' === weight ) {
				selectEl.value = first;
				selectEl.selectedIndex = 0;
			// Select last if no previous item remains for bold.
			} else {
				selectEl.value = last;
				selectEl.selectedIndex = selectEl.options.length - 1;
			}

			// Manually updated setting value.
			control.setting.bind( selectEl.value );
		}
	} );
};

/**
 * Update category (fallback) fields with available options.
 *
 * @param {string} category Font category.
 */
const updateCategoryField = ( category ) => {
	if ( 'handwriting' === category ) {
		category = 'cursive';
	}

	wp.customize.control( 'type-font-family-fallback', ( control ) => control.setting.set( category ) );
};

// Wait for Customize ready.
wp.customize.bind( 'ready', () => {
	const familyControl = wp.customize.control( 'type-font-family' );
	const familyInput = familyControl.container.find( 'select' ).get( 0 );

	// Update available weights when changing family.
	familyInput.addEventListener( 'change', ( e ) => {
		const selected = e.target.options[ e.target.options.selectedIndex ];
		const variants = selected.dataset.variants ? selected.dataset.variants.split( ',' ) : [ 400, 500 ];
		const category = selected.dataset.category || 'sans-serif';

		updateWeightFields( variants );
		updateCategoryField( category );
	} );

	getFamilyOptions().forEach( ( family ) => familyInput.add( family ) );

	familyInput.value = familyControl.setting();

	// Trigger change on load to populate other fields.
	const event = new Event( 'change' );
	familyInput.dispatchEvent( event );
} );
