<?php
/**
 * Field schema — every editable piece of content on the page.
 *
 * One definition drives three things: the ACF field registration
 * (inc/fields.php), reading values back (inc/data.php) and the first-run
 * import of the original content (inc/seed.php).
 *
 * Field types used here:
 *   text, textarea, number, bool, select, image, file  – the usual ACF types
 *   svg      – a textarea holding inline SVG icon code
 *   lines    – a textarea, one list item per line
 *   paras    – a textarea, paragraphs separated by an empty line
 *   group    – a set of sub-fields
 *   fixed    – a fixed number of items (the design has exactly N slots)
 *   repeater – a list of items (ACF PRO / Secure Custom Fields repeater;
 *              falls back to N toggleable slots on the free ACF plugin)
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Small field constructor.
 */
function bm_fd( $type, $name, $label, $extra = array() ) {
	return array_merge(
		array(
			'type'  => $type,
			'name'  => $name,
			'label' => $label,
		),
		$extra
	);
}

/**
 * Returns the full schema, keyed by section.
 */
function bm_schema() {
	static $schema = null;
	if ( null !== $schema ) {
		return $schema;
	}

	$svg_help    = 'Inline SVG icon code (24×24 viewBox, stroke/fill set to currentColor). Keep the current code to keep the current icon.';
	$link_help   = 'Full URL, or #section-id for a link to a section on the home page.';
	$popup_help  = 'This button opens the “Get the App” popup (store links are set under Brand & Contact).';
	$inline_help = 'Simple inline tags such as <b>, <strong>, <em> and <br> are allowed.';
	$accent_help = 'Shown in the brand orange after the heading. Leave empty for none.';

	$link_row = array(
		bm_fd( 'text', 'label', 'Label', array( 'w' => 40 ) ),
		bm_fd( 'text', 'url', 'URL', array( 'w' => 60, 'help' => $link_help ) ),
	);

	$schema = array(

		/* ───────────── S1 · hero ───────────── */
		'hero' => array(
			'label'  => 'Hero',
			'fields' => array(
				bm_fd( 'text', 'tagline', 'Tagline (small pill above the headline)' ),
				bm_fd( 'lines', 'title_lines', 'Headline', array( 'help' => 'One line per row — each line slides in on its own.' ) ),
				bm_fd( 'textarea', 'subtitle', 'Intro paragraph' ),
				bm_fd( 'lines', 'bullets', 'Check-list bullets', array( 'help' => 'One bullet per line.' ) ),
				bm_fd( 'text', 'bottom_tag', 'Line under the store buttons' ),
				bm_fd( 'text', 'scroll_text', '“Scroll” cue text' ),
				bm_fd( 'image', 'banner_image', 'Phone banner image', array( 'help' => 'The app screens shown on the right. The image’s Alt Text (Media Library) is used as its description.' ) ),
				bm_fd(
					'fixed',
					'chips',
					'Floating chips around the phones',
					array(
						'count' => 4,
						'item'  => 'Chip',
						'sub'   => array(
							bm_fd( 'text', 'label', 'Label', array( 'w' => 35 ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'w' => 65, 'help' => $svg_help ) ),
						),
					)
				),
				bm_fd( 'text', 'rating_label', 'Rating label (next to the 5 stars)' ),
				bm_fd(
					'repeater',
					'stats',
					'Counters',
					array(
						'max'  => 3,
						'item' => 'Counter',
						'help' => 'Numbers count up when scrolled into view (the 5-star block takes the first of the 4 columns).',
						'sub'  => array(
							bm_fd( 'number', 'number', 'Number', array( 'w' => 30 ) ),
							bm_fd( 'text', 'suffix', 'Suffix', array( 'w' => 20 ) ),
							bm_fd( 'text', 'label', 'Label', array( 'w' => 50 ) ),
						),
					)
				),
			),
		),

		/* ───────────── S2 · the network gap ───────────── */
		'network' => array(
			'label'  => 'Network Gap',
			'fields' => array(
				bm_fd( 'text', 'kicker', 'Kicker (small label)' ),
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd( 'textarea', 'text', 'Paragraph' ),
				bm_fd(
					'repeater',
					'cards',
					'Problem cards (dealt in one by one on scroll)',
					array(
						'max'  => 6,
						'item' => 'Card',
						'sub'  => array(
							bm_fd( 'text', 'title', 'Title', array( 'w' => 50 ) ),
							bm_fd( 'textarea', 'text', 'Text', array( 'w' => 50 ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'help' => $svg_help ) ),
						),
					)
				),
				bm_fd( 'text', 'without_kicker', '“Without” column — small text', array( 'w' => 50 ) ),
				bm_fd( 'text', 'without_title', '“Without” column — big text', array( 'w' => 50 ) ),
				bm_fd( 'lines', 'messages', '“Without” column — chat bubbles', array( 'help' => 'One message per line. Bubbles alternate left / right.' ) ),
				bm_fd( 'text', 'with_kicker', '“With” column — small text', array( 'w' => 50 ) ),
				bm_fd( 'text', 'with_title', '“With” column — big text', array( 'w' => 50 ) ),
				bm_fd(
					'repeater',
					'vs_cards',
					'“With” column — benefit cards',
					array(
						'max'  => 8,
						'item' => 'Benefit',
						'sub'  => array(
							bm_fd( 'text', 'title', 'Text', array( 'w' => 70, 'help' => $inline_help ) ),
							bm_fd( 'bool', 'highlight', 'Highlighted card', array( 'w' => 30 ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'help' => $svg_help ) ),
						),
					)
				),
			),
		),

		/* ───────────── S3 · connect ───────────── */
		'connect' => array(
			'label'  => 'Connect',
			'fields' => array(
				bm_fd( 'image', 'bg_image', 'Background photo' ),
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd( 'paras', 'paragraphs', 'Paragraphs', array( 'help' => 'Separate paragraphs with an empty line. Words light up as the visitor scrolls.' ) ),
				bm_fd( 'text', 'cta_heading', 'Line above the button', array( 'w' => 50 ) ),
				bm_fd( 'text', 'button_text', 'Button text', array( 'w' => 50, 'help' => $popup_help ) ),
				bm_fd( 'text', 'diagram_label', 'Diagram description (for screen readers)' ),
				bm_fd(
					'fixed',
					'nodes',
					'Diagram points',
					array(
						'count' => 6,
						'item'  => 'Point',
						'help'  => 'Points 1–3 sit on the left of the hub, 4–6 on the right.',
						'sub'   => array(
							bm_fd( 'text', 'label', 'Label', array( 'w' => 35 ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'w' => 65, 'help' => $svg_help ) ),
						),
					)
				),
			),
		),

		/* ───────────── S4 · property + requirements ───────────── */
		'inventory' => array(
			'label'  => 'Inventory',
			'fields' => array(
				bm_fd( 'text', 'kicker', 'Kicker (small label)' ),
				bm_fd( 'textarea', 'title', 'Heading' ),
				bm_fd( 'textarea', 'text', 'Paragraph' ),
				bm_fd(
					'repeater',
					'cards',
					'Cards',
					array(
						'max'  => 6,
						'item' => 'Card',
						'sub'  => array(
							bm_fd( 'text', 'title', 'Title', array( 'w' => 40 ) ),
							bm_fd( 'textarea', 'text', 'Text', array( 'w' => 40 ) ),
							bm_fd( 'bool', 'dark', 'Dark card', array( 'w' => 20 ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'help' => $svg_help ) ),
						),
					)
				),
				bm_fd( 'text', 'cta_heading', 'Line above the button' ),
				bm_fd( 'text', 'button_text', 'Button text', array( 'w' => 40 ) ),
				bm_fd( 'text', 'button_url', 'Button link', array( 'w' => 60, 'help' => $link_help ) ),
			),
		),

		/* ───────────── S5 · how it works ───────────── */
		'how' => array(
			'label'  => 'How It Works',
			'fields' => array(
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd( 'textarea', 'text', 'Paragraph' ),
				bm_fd(
					'repeater',
					'steps',
					'Steps (one per scroll step, each with its own phone screen)',
					array(
						'max'  => 8,
						'item' => 'Step',
						'sub'  => array(
							bm_fd( 'text', 'title', 'Title', array( 'w' => 50 ) ),
							bm_fd( 'textarea', 'text', 'Text', array( 'w' => 50 ) ),
							bm_fd( 'image', 'image', 'App screenshot', array( 'help' => 'The image’s Alt Text (Media Library) is used as its description.' ) ),
						),
					)
				),
			),
		),

		/* ───────────── S6 · features ───────────── */
		'features' => array(
			'label'  => 'Features',
			'fields' => array(
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd( 'textarea', 'text', 'Paragraph' ),
				bm_fd(
					'repeater',
					'items',
					'Features (one per scroll step, each with its own phone screen)',
					array(
						'max'  => 10,
						'item' => 'Feature',
						'sub'  => array(
							bm_fd( 'text', 'title', 'Title', array( 'w' => 50 ) ),
							bm_fd( 'textarea', 'text', 'Text', array( 'w' => 50 ) ),
							bm_fd( 'image', 'image', 'App screenshot', array( 'w' => 40, 'help' => 'The image’s Alt Text (Media Library) is used as its description.' ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'w' => 60, 'help' => $svg_help ) ),
						),
					)
				),
			),
		),

		/* ───────────── S7 · statement ───────────── */
		'more' => array(
			'label'  => 'Statement',
			'fields' => array(
				bm_fd( 'textarea', 'title', 'Big statement', array( 'help' => 'Words light up as the visitor scrolls.' ) ),
				bm_fd( 'textarea', 'text', 'Paragraph' ),
				bm_fd( 'text', 'button_text', 'Button text', array( 'w' => 40 ) ),
				bm_fd( 'text', 'button_url', 'Button link', array( 'w' => 60, 'help' => $link_help ) ),
			),
		),

		/* ───────────── S8 · why ───────────── */
		'why' => array(
			'label'  => 'Why BrokerMojo',
			'fields' => array(
				bm_fd( 'image', 'bg_image', 'Background photo' ),
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd( 'textarea', 'text', 'Paragraph' ),
				bm_fd(
					'repeater',
					'cards',
					'Cards',
					array(
						'max'  => 6,
						'item' => 'Card',
						'sub'  => array(
							bm_fd( 'text', 'title', 'Title', array( 'w' => 50 ) ),
							bm_fd( 'text', 'kicker', 'Bold line', array( 'w' => 50 ) ),
							bm_fd( 'textarea', 'text', 'Text', array( 'w' => 50 ) ),
							bm_fd( 'svg', 'icon', 'Icon', array( 'w' => 50, 'help' => $svg_help ) ),
						),
					)
				),
			),
		),

		/* ───────────── S10 · testimonials ───────────── */
		'testimonials' => array(
			'label'  => 'Testimonials',
			'fields' => array(
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd(
					'repeater',
					'items',
					'Testimonial cards',
					array(
						'max'  => 12,
						'item' => 'Testimonial',
						'sub'  => array(
							bm_fd(
								'select',
								'type',
								'Card type',
								array(
									'w'       => 30,
									'choices' => array(
										'video' => 'Video card (photo + play button)',
										'quote' => 'Quote card (text over a photo)',
									),
									'default' => 'video',
								)
							),
							bm_fd( 'text', 'name', 'Name', array( 'w' => 35 ) ),
							bm_fd( 'text', 'role', 'Designation, company / city', array( 'w' => 35 ) ),
							bm_fd( 'image', 'photo', 'Photo', array( 'w' => 30, 'cond' => array( 'type', 'video' ) ) ),
							bm_fd( 'bool', 'cutout', 'Cut-out photo (transparent PNG)', array( 'w' => 20, 'cond' => array( 'type', 'video' ) ) ),
							bm_fd( 'text', 'tag', 'Tag text', array( 'w' => 20, 'cond' => array( 'type', 'video' ) ) ),
							bm_fd( 'file', 'video_file', 'Video file (MP4 / WebM)', array( 'w' => 30, 'cond' => array( 'type', 'video' ), 'help' => 'Upload a video, or use the URL field below.' ) ),
							bm_fd( 'text', 'video_url', 'Video URL', array( 'cond' => array( 'type', 'video' ), 'help' => 'An .mp4/.webm link or an embed URL (e.g. https://www.youtube.com/embed/VIDEO_ID). Used when no file is uploaded. Leave both empty to show the “video slot ready” placeholder.' ) ),
							bm_fd( 'image', 'bg_image', 'Background photo', array( 'w' => 30, 'cond' => array( 'type', 'quote' ) ) ),
							bm_fd( 'textarea', 'quote', 'Quote', array( 'w' => 70, 'cond' => array( 'type', 'quote' ) ) ),
						),
					)
				),
				bm_fd( 'text', 'button_text', 'Button text', array( 'help' => $popup_help ) ),
			),
		),

		/* ───────────── S9 · pricing ───────────── */
		'pricing' => array(
			'label'  => 'Pricing',
			'fields' => array(
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd(
					'repeater',
					'plans',
					'Plans',
					array(
						'max'  => 4,
						'item' => 'Plan',
						'help' => 'The layout is built for four plans in a row.',
						'sub'  => array(
							bm_fd( 'text', 'name', 'Plan name', array( 'w' => 34 ) ),
							bm_fd( 'text', 'price', 'Price (shown struck through)', array( 'w' => 33 ) ),
							bm_fd( 'bool', 'popular', 'Highlighted plan', array( 'w' => 33, 'help' => 'Orange outline and orange button.' ) ),
							bm_fd( 'text', 'tag_text', 'Badge text', array( 'w' => 34, 'help' => 'e.g. Most Popular. Leave empty for no badge.' ) ),
							bm_fd(
								'select',
								'tag_style',
								'Badge style',
								array(
									'w'       => 33,
									'choices' => array(
										'pop'  => 'Orange (Most Popular)',
										'best' => 'Light (Best Value)',
									),
									'default' => 'pop',
								)
							),
							bm_fd( 'text', 'free_title', 'Offer title', array( 'w' => 33 ) ),
							bm_fd( 'text', 'free_note', 'Offer note', array( 'w' => 50 ) ),
							bm_fd( 'text', 'button_text', 'Button text', array( 'w' => 50, 'help' => $popup_help ) ),
							bm_fd( 'lines', 'features', 'Features', array( 'help' => 'One feature per line.' ) ),
						),
					)
				),
				bm_fd( 'textarea', 'cta_title', 'Closing band — heading' ),
				bm_fd( 'textarea', 'cta_text', 'Closing band — paragraph', array( 'help' => 'The store buttons below it use the links under Brand & Contact.' ) ),
			),
		),

		/* ───────────── S11 · FAQ ───────────── */
		'faq' => array(
			'label'  => 'FAQ',
			'fields' => array(
				bm_fd( 'text', 'title', 'Heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'accent', 'Heading — orange part', array( 'w' => 50, 'help' => $accent_help ) ),
				bm_fd( 'text', 'contact_heading', 'Contact card — heading', array( 'help' => 'Address, email and phone come from Brand & Contact.' ) ),
				bm_fd( 'text', 'button_text', 'Contact card — button text', array( 'w' => 40 ) ),
				bm_fd( 'text', 'button_url', 'Contact card — button link', array( 'w' => 60, 'help' => $link_help ) ),
				bm_fd(
					'repeater',
					'items',
					'Questions',
					array(
						'max'  => 20,
						'item' => 'Question',
						'sub'  => array(
							bm_fd( 'text', 'question', 'Question' ),
							bm_fd( 'paras', 'answer', 'Answer', array( 'help' => 'Separate paragraphs with an empty line.' ) ),
						),
					)
				),
			),
		),

		/* ───────────── header ───────────── */
		'header' => array(
			'label'  => 'Header',
			'fields' => array(
				bm_fd(
					'repeater',
					'nav',
					'Menu links (desktop menu and mobile menu)',
					array(
						'max'  => 6,
						'item' => 'Link',
						'sub'  => $link_row,
					)
				),
				bm_fd( 'text', 'cta_text', 'Header button text', array( 'help' => $popup_help ) ),
			),
		),

		/* ───────────── footer ───────────── */
		'footer' => array(
			'label'  => 'Footer',
			'fields' => array(
				bm_fd( 'text', 'legal_name', 'Company name (under the tagline)' ),
				bm_fd( 'text', 'col1_heading', 'Column 1 — heading' ),
				bm_fd(
					'repeater',
					'col1_links',
					'Column 1 — links',
					array(
						'max'  => 8,
						'item' => 'Link',
						'sub'  => $link_row,
					)
				),
				bm_fd( 'text', 'col2_heading', 'Column 2 — heading' ),
				bm_fd(
					'repeater',
					'col2_links',
					'Column 2 — links',
					array(
						'max'  => 8,
						'item' => 'Link',
						'sub'  => $link_row,
					)
				),
				bm_fd( 'text', 'col3_heading', 'Column 3 — heading (above the store buttons)' ),
				bm_fd(
					'repeater',
					'socials',
					'Social links',
					array(
						'max'  => 6,
						'item' => 'Social link',
						'sub'  => array(
							bm_fd(
								'select',
								'network',
								'Network',
								array(
									'w'       => 30,
									'choices' => array(
										'instagram' => 'Instagram',
										'facebook'  => 'Facebook',
										'linkedin'  => 'LinkedIn',
										'youtube'   => 'YouTube',
										'x'         => 'X (Twitter)',
										'whatsapp'  => 'WhatsApp',
									),
									'default' => 'instagram',
								)
							),
							bm_fd( 'text', 'url', 'URL', array( 'w' => 70 ) ),
						),
					)
				),
				bm_fd( 'text', 'copyright_before', 'Copyright — text before the year', array( 'w' => 40 ) ),
				bm_fd( 'text', 'copyright_after', 'Copyright — text after the year', array( 'w' => 60, 'help' => 'The year updates itself.' ) ),
			),
		),

		/* ───────────── download popup ───────────── */
		'popup' => array(
			'label'  => 'App Popup',
			'fields' => array(
				bm_fd( 'text', 'title', 'Popup heading', array( 'w' => 50 ) ),
				bm_fd( 'text', 'subtitle', 'Popup sub-heading', array( 'w' => 50 ) ),
				bm_fd( 'image', 'qr_image', 'QR code image (optional)', array( 'w' => 50, 'help' => 'Leave empty to keep the built-in QR code.' ) ),
				bm_fd( 'text', 'qr_caption', 'QR caption', array( 'w' => 50 ) ),
			),
		),

		/* ───────────── sticky mobile bar ───────────── */
		'mobile_bar' => array(
			'label'  => 'Mobile Bar',
			'fields' => array(
				bm_fd( 'text', 'button_text', 'Button text', array( 'help' => 'The bar shows the brand name and tagline from Brand & Contact. ' . $popup_help ) ),
			),
		),

		/* ───────────── brand & contact (shared everywhere) ───────────── */
		'global' => array(
			'label'  => 'Brand & Contact',
			'fields' => array(
				bm_fd( 'text', 'brand_name', 'Brand name', array( 'w' => 50 ) ),
				bm_fd( 'text', 'tagline', 'Tagline', array( 'w' => 50, 'help' => 'Footer and mobile bar.' ) ),
				bm_fd( 'image', 'logo_image', 'Logo image (optional)', array( 'help' => 'Leave empty to keep the built-in BrokerMojo mark. Use a square image — it is shown at about 36×36px in the header and footer.' ) ),
				bm_fd( 'text', 'play_url', 'Google Play link', array( 'w' => 50 ) ),
				bm_fd( 'text', 'ios_url', 'App Store link', array( 'w' => 50 ) ),
				bm_fd( 'text', 'store_small', 'Store buttons — small text', array( 'w' => 34 ) ),
				bm_fd( 'text', 'android_label', 'Store buttons — Android label', array( 'w' => 33 ) ),
				bm_fd( 'text', 'ios_label', 'Store buttons — iOS label', array( 'w' => 33 ) ),
				bm_fd( 'text', 'email', 'Email', array( 'w' => 34 ) ),
				bm_fd( 'text', 'phone_display', 'Phone (as shown)', array( 'w' => 33 ) ),
				bm_fd( 'text', 'phone_link', 'Phone (for dialling)', array( 'w' => 33, 'help' => 'Digits with country code, e.g. +918619600600' ) ),
				bm_fd( 'textarea', 'address', 'Address', array( 'help' => 'Line breaks are kept.' ) ),
				bm_fd( 'text', 'launch_note', 'Launch note', array( 'help' => 'Shown in the footer and the popup.' ) ),
			),
		),

		/* ───────────── SEO & settings ───────────── */
		'seo' => array(
			'label'  => 'SEO & Settings',
			'fields' => array(
				bm_fd( 'text', 'meta_title', 'Browser / search title' ),
				bm_fd( 'textarea', 'meta_description', 'Meta description' ),
				bm_fd( 'image', 'og_image', 'Social share image' ),
				bm_fd( 'bool', 'show_admin_bar', 'Show the WordPress admin bar on the front end', array( 'help' => 'Off by default: the bar sits over the fixed header.' ) ),
			),
		),
	);

	return $schema;
}
