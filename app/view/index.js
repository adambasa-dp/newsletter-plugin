/**
 * Import styles
 */
import './styles.scss';

/**
 * Subscribe to newsletter form
 */
class NewsletterForm {
	constructor( widget ) {
		this.form = widget.querySelector( 'form' );
		this.emailInput = this.form.querySelector( 'input[name="email"]' );
		this.agreementCheckbox = this.form.querySelector( 'input[name="agreement"]' );
		this.submitButton = this.form.querySelector( '.newsletter-wp-plugin__button' );
		this.successMessage = widget.querySelector( '.newsletter-wp-plugin__success' );
		this.emailErrorMessage = widget.querySelector( '.newsletter-wp-plugin__error--email' );
		this.agreementErrorMessage = widget.querySelector( '.newsletter-wp-plugin__error--agreement' );
		this.serverErrorMessage = widget.querySelector( '.newsletter-wp-plugin__error--server' );

		this.submitButton.addEventListener( 'click', e => {
			e.preventDefault();
			this.validate();
		});
	}

	/**
	 * Validate form
	 */
	validate() {
		let isValid = true;

		this.serverErrorMessage.style.display = 'none';

		if ( ! this.emailInput.value || ! this.isEmailValid( this.emailInput.value ) ) {
			isValid = false;
			this.emailErrorMessage.style.display = 'block';
		} else {
			this.emailErrorMessage.style.display = 'none';
		}

		if ( null != this.agreementCheckbox && ! this.agreementCheckbox.checked ) {
			isValid = false;
			this.agreementErrorMessage.style.display = 'block';
		} else {
			this.agreementErrorMessage.style.display = 'none';
		}

		if ( isValid ) {
			this.sendRequest();
		}
	}

	/**
	 * Check if email is valid with regex
	 *
	 * @param email
	 * @returns {boolean}
	 */
	isEmailValid( email ) {
		const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test( email );
	}

	/**
	 * Send request to the server
	 */
	sendRequest() {
		const data = new FormData( this.form );

		fetch( '/wp-admin/admin-ajax.php', {
			method: 'POST',
			body: data,
		})
			.then( response => response.json() )
			.then( data => {
				if ( data.success ) {
					this.form.style.display = 'none';
					this.successMessage.style.display = 'block';
				} else {
					this.serverErrorMessage.style.display = 'block';
				}
			});
	}
}

/**
 * Initialize all newsletter forms on the website
 */
window.addEventListener( 'DOMContentLoaded', () => {
	const widgets = document.querySelectorAll( '.newsletter-wp-plugin' );

	widgets.forEach( widget => {
		new NewsletterForm( widget );
	});
});
