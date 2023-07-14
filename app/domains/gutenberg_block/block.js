const {registerBlockType} = wp.blocks;

registerBlockType( 'newsletter-wp-plugin/newsletter', {
	title: 'Newsletter',
	icon: 'email',
	category: 'common',
	attributes: {
		title: {
			type: 'string',
			selector: '.newsletter__title'
		},
		placeholder: {
			type: 'string',
			selector: '.newsletter__placeholder'
		},
		button_title: {
			type: 'string',
			selector: '.newsletter__button-title'
		},
		agreement_text: {
			type: 'string',
			selector: '.newsletter__agreement-text'
		},
	},
	edit({attributes, setAttributes}) {
		return (
			<div style={{padding: '20px', backgroundColor: '#f5f5f5', borderRadius: '5px', maxWidth: '600px'}}>
				<h2 style={{marginBottom: '20px'}}>Newsletter Block</h2>
				<label style={{display: 'block', marginBottom: '10px'}}>
					<span style={{display: 'block', marginBottom: '5px'}}>Title</span>
					<input
						style={{padding: '10px', fontSize: '16px', borderRadius: '5px', border: '1px solid #ddd'}}
						type="text"
						value={attributes.title}
						onChange={( e ) => setAttributes({title: e.target.value})}
						placeholder="Enter title..."
					/>
				</label>
				<label style={{display: 'block', marginBottom: '10px'}}>
					<span style={{display: 'block', marginBottom: '5px'}}>Placeholder</span>
					<input
						style={{padding: '10px', fontSize: '16px', borderRadius: '5px', border: '1px solid #ddd'}}
						type="text"
						value={attributes.placeholder}
						onChange={( e ) => setAttributes({placeholder: e.target.value})}
						placeholder="Enter placeholder..."
					/>
				</label>
				<label style={{display: 'block', marginBottom: '10px'}}>
					<span style={{display: 'block', marginBottom: '5px'}}>Button Title</span>
					<input
						style={{padding: '10px', fontSize: '16px', borderRadius: '5px', border: '1px solid #ddd'}}
						type="text"
						value={attributes.button_title}
						onChange={( e ) => setAttributes({button_title: e.target.value})}
						placeholder="Enter button title..."
					/>
				</label>
				<label style={{display: 'block', marginBottom: '10px'}}>
					<span style={{display: 'block', marginBottom: '5px'}}>Agreement Text</span>
					<input
						style={{padding: '10px', fontSize: '16px', borderRadius: '5px', border: '1px solid #ddd'}}
						type="text"
						value={attributes.agreement_text}
						onChange={( e ) => setAttributes({agreement_text: e.target.value})}
						placeholder="Enter agreement text..."
					/>
				</label>
			</div>
		);
	},
	save({attributes}) {
		return (
			<div>
				<h2 className="newsletter__title">{attributes.title}</h2>
				<h2 className="newsletter__placeholder">{attributes.placeholder}</h2>
				<h2 className="newsletter__button-title">{attributes.button_title}</h2>
				<h2 className="newsletter__agreement-text">{attributes.agreement_text}</h2>
			</div>
		);
	},
});
