// Use jQuery as $ within this file scope.
const $ = jQuery; // eslint-disable-line no-unused-vars

/**
 * Class TimelineScroll
 */
export default class TimelineScroll {

    /**
     * Scroll to element with anchor
     *
     * @param {Object} event The click event object.
     *
     * @return {void}
     */
    scrollToYear( event ) {
        event.preventDefault();
        const targetId = event.currentTarget.getAttribute( 'href' );

        if ( targetId ) {
            const targetElement = document.querySelector( targetId );

            if ( targetElement ) {
                targetElement.scrollIntoView( {
                    behavior: 'smooth',
                } );
            }
        }
    }

    /**
     * Run when the document is ready.
     *
     * @return {void}
     */
    docReady() {
        $( '.timeline-anchor' ).on( 'click', this.scrollToYear.bind( this ) );
    }
}
