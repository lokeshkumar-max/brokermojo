<?php
/**
 * Default content — an exact copy of the original static site.
 *
 * Used three ways:
 *  1. seeded into the Home page's ACF fields the first time the theme runs,
 *  2. shown on the front end for any section that has never been saved,
 *  3. shown when ACF is not active, so the site never renders blank.
 *
 * Image values are file names inside /assets/images/.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

return array(
	'global' => array(
		'brand_name' => 'BrokerMojo',
		'logo_image' => '',
		'tagline' => 'Smart App For Smart Brokers.',
		'play_url' => 'https://play.google.com/store/apps/details?id=com.brokermojo.app',
		'ios_url' => 'https://apps.apple.com/in/app/brokermojo/id6761607924',
		'store_small' => 'Download For',
		'android_label' => 'Android',
		'ios_label' => 'iOS',
		'email' => 'admin@brokermojo.com',
		'phone_link' => '+918619600600',
		'phone_display' => '+91 8619600600',
		'address' => 'Ekling Residency P.No. 157, GF-3,
Ajmer Road, Jaipur, 302019',
		'launch_note' => 'Launching first in Jaipur',
	),
	'header' => array(
		'nav' => array(
			array(
				'label' => 'Features',
				'url' => '#features',
			),
			array(
				'label' => 'How It Works',
				'url' => '#how',
			),
			array(
				'label' => 'Pricing',
				'url' => '#pricing',
			),
			array(
				'label' => 'Contact',
				'url' => 'https://brokermojo.com/contact',
			),
		),
		'cta_text' => 'Get the App',
	),
	'hero' => array(
		'tagline' => 'Smart App For Smart Brokers.',
		'title_lines' => array(
			'The Right Broker.',
			'The Right Property.',
			'Beyond Your Locality.',
		),
		'subtitle' => 'BrokerMojo helps real estate brokers connect with the right buyers and brokers, discover property requirements, access more inventory, and find sales opportunities beyond their existing network and locality.',
		'bullets' => array(
			'Connect With Real Estate Brokers',
			'Find Buyer & Property Requirements',
			'Explore Opportunities Beyond Your Locality',
			'Access New Property Projects',
		),
		'bottom_tag' => 'Built for Real-Estate Brokers, Property Consultants & Builders.',
		'scroll_text' => 'Scroll',
		'banner_image' => array(
			'file' => 'app-banner.png',
			'alt' => 'The BrokerMojo app: the home screen beside a property listing',
		),
		'chips' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.2 12 3.5l9 6.7V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-9.8Z"/><path d="M9.3 21v-6.4h5.4V21"/></svg>',
				'label' => 'Inventory',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.6 4.6M8 10.5h5M10.5 8v5"/></svg>',
				'label' => 'Buyer Leads',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15.5 3H6a1.5 1.5 0 0 0-1.5 1.5v15A1.5 1.5 0 0 0 6 21h12a1.5 1.5 0 0 0 1.5-1.5V7l-4-4ZM15 3v4.5h4.5M8.5 12.5h7M8.5 16.5h4.5"/></svg>',
				'label' => 'Requirements',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10.2" r="2.8"/><path d="M20 10.5c0 5.5-8 12-8 12s-8-6.5-8-12a8 8 0 0 1 16 0Z"/></svg>',
				'label' => 'Localities',
			),
		),
		'rating_label' => '5-Star Rated',
		'stats' => array(
			array(
				'number' => '500',
				'suffix' => '+',
				'label' => 'Properties',
			),
			array(
				'number' => '250',
				'suffix' => '+',
				'label' => 'Requirements',
			),
			array(
				'number' => '200',
				'suffix' => '+',
				'label' => 'Downloads',
			),
		),
	),
	'network' => array(
		'kicker' => 'The Network Gap',
		'title' => 'Build Your Broker Network.',
		'accent' => 'Get More Business.',
		'text' => 'Your next deal may already be with another broker. BrokerMojo helps you connect with brokers, share requirements, discover matching properties, and find opportunities that may be outside your existing network.',
		'cards' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 6.5h17M3.5 12h17M3.5 17.5h11"/><path d="m18 15.5 4 4M22 15.5l-4 4"/></svg>',
				'title' => 'Scattered Inventory',
				'text' => 'Properties are spread across chats, spreadsheets, and phones.',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.4"/><path d="M2.6 19.4a6.6 6.6 0 0 1 12.8 0"/><path d="M17.5 8.5h5M20 6v5"/></svg>',
				'title' => 'Limited Network',
				'text' => 'The broker who can help may already be in the market, but outside your network.',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17.5 9 11l4 4 8-8.5"/><path d="M15.5 6.5H21V12"/><path d="M3.5 20.5h17"/></svg>',
				'title' => 'Missed Deals',
				'text' => 'When requirements and inventory are difficult to find, opportunities can be missed.',
			),
		),
		'without_kicker' => 'Without',
		'without_title' => 'BrokerMojo',
		'messages' => array(
			'3 BHK available. Who has a buyer?',
			'Client needs something around ₹1 Cr.',
			'Which broker has this requirement?',
			'Can you send the number again?',
			'Any update on that property?',
			'What new projects are available?',
		),
		'with_kicker' => 'With',
		'with_title' => 'BrokerMojo',
		'vs_cards' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="9.5" cy="8" r="3.4"/><path d="M3 19.4a6.6 6.6 0 0 1 12 0"/><path d="m16.4 12.4 1.9 1.9 3.5-3.5"/></svg>',
				'title' => 'Right Buyer. Right Time.',
				'highlight' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="8.5" cy="8" r="3.1"/><circle cx="17.2" cy="9.6" r="2.5"/><path d="M2.8 19.4a5.9 5.9 0 0 1 11.4 0"/><path d="M15.8 19.4a4.8 4.8 0 0 1 5.6-4.4"/></svg>',
				'title' => 'Right Broker. Right Time.',
				'highlight' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="2.4"/><circle cx="5" cy="5.6" r="1.9"/><circle cx="19" cy="5.6" r="1.9"/><circle cx="5" cy="18.4" r="1.9"/><circle cx="19" cy="18.4" r="1.9"/><path d="m6.5 7 3.8 3.5M17.5 7l-3.8 3.5M6.5 17l3.8-3.5M17.5 17l-3.8-3.5"/></svg>',
				'title' => 'Broker Network & Groups',
				'highlight' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3.2 12h17.6"/><path d="M12 3a14.5 14.5 0 0 1 0 18a14.5 14.5 0 0 1 0-18Z"/></svg>',
				'title' => 'Sales Beyond Your Locality',
				'highlight' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5.5 21V8.2L12 4l6.5 4.2V21"/><path d="M10 21v-4.6h4V21"/><path d="M10.4 11.6h3.2"/></svg>',
				'title' => 'Direct New Project Access',
				'highlight' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17.6 9.2 11l3.9 3.9L21 6.9"/><path d="M15.4 6.9H21v5.6"/></svg>',
				'title' => 'Up to <b>40%</b> Increased Sales',
				'highlight' => true,
			),
		),
	),
	'connect' => array(
		'bg_image' => array(
			'file' => 'bg-rooftop.jpg',
			'alt' => '',
		),
		'title' => 'Connect With More Brokers.',
		'accent' => 'Unlock More Opportunities.',
		'paragraphs' => array(
			'Expand your broker network and open access to more property opportunities. Find brokers with relevant requirements, share inventory, discover buyer leads, and connect with professionals working across different localities.',
			'The right connection can bring the right buyer, the right property, or the right opportunity to your next deal.',
		),
		'cta_heading' => 'Build Your Broker Network.',
		'button_text' => 'Download BrokerMojo Now!',
		'diagram_label' => 'BrokerMojo at the centre, with brokers, requirements, inventory, buyer leads, opportunities and localities flowing into it.',
		'nodes' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.4"/><path d="M2.6 19.4a6.6 6.6 0 0 1 12.8 0M17 11.2a3.4 3.4 0 0 0 0-6.4M18.6 19.4a6.6 6.6 0 0 0-2.3-4.4"/></svg>',
				'label' => 'Brokers',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15.5 3H6a1.5 1.5 0 0 0-1.5 1.5v15A1.5 1.5 0 0 0 6 21h12a1.5 1.5 0 0 0 1.5-1.5V7l-4-4ZM15 3v4.5h4.5M8.5 12.5h7M8.5 16.5h4.5"/></svg>',
				'label' => 'Requirements',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.2 12 3.5l9 6.7V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-9.8ZM9.3 21v-6.4h5.4V21"/></svg>',
				'label' => 'Inventory',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.6 4.6M8 10.5h5M10.5 8v5"/></svg>',
				'label' => 'Buyer Leads',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2.5 4.5 13.5H11l-1 8 8.5-11.5H12l1-7.5Z"/></svg>',
				'label' => 'Opportunities',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10.2" r="2.8"/><path d="M20 10.5c0 5.5-8 12-8 12s-8-6.5-8-12a8 8 0 0 1 16 0Z"/></svg>',
				'label' => 'Localities',
			),
		),
	),
	'inventory' => array(
		'kicker' => 'Property + Requirements',
		'title' => 'More Property Inventory. More Buyer Requirements. More Deals.',
		'text' => 'Add your property inventory and client requirements to make it easier to find relevant matches and uncover new deal opportunities.',
		'cards' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.2 12 3.5l9 6.7V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-9.8Z"/><path d="M9.3 21v-6.4h5.4V21"/></svg>',
				'title' => 'Property Listings',
				'text' => 'Add and manage your property inventory in one place.',
				'dark' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M15.5 3H6a1.5 1.5 0 0 0-1.5 1.5v15A1.5 1.5 0 0 0 6 21h12a1.5 1.5 0 0 0 1.5-1.5V7l-4-4Z"/><path d="M15 3v4.5h4.5M8.5 12.5h7M8.5 16.5h4.5"/></svg>',
				'title' => 'Client Requirements',
				'text' => 'Keep active buyer requirements organized.',
				'dark' => false,
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4.5 6v6c0 4.6 3.1 8.2 7.5 9.4 4.4-1.2 7.5-4.8 7.5-9.4V6L12 3Z"/><path d="m9 12 2.2 2.2L15.5 10"/></svg>',
				'title' => 'RERA-Registered Property Information',
				'text' => 'Access relevant RERA registration details and property information to support your due diligence.',
				'dark' => true,
			),
		),
		'cta_heading' => 'Take Your Brokerage Beyond Your Locality',
		'button_text' => 'Join BrokerMojo',
		'button_url' => 'https://apps.apple.com/in/app/brokermojo/id6761607924',
	),
	'how' => array(
		'title' => 'From Property Listing to',
		'accent' => 'Closed Deal.',
		'text' => 'A simple workflow for the real work that happens between brokers.',
		'steps' => array(
			array(
				'title' => 'Create Your Broker Profile',
				'text' => 'Set up your profile and get started.',
				'image' => array(
					'file' => 'app-create-profile.png',
					'alt' => 'Creating your broker profile in the app',
				),
			),
			array(
				'title' => 'Add Properties & Requirements',
				'text' => 'Share your inventory and client requirements.',
				'image' => array(
					'file' => 'app-add-properties.png',
					'alt' => 'Adding properties and requirements in the app',
				),
			),
			array(
				'title' => 'Connect With Brokers',
				'text' => 'Find relevant brokers and opportunities.',
				'image' => array(
					'file' => 'app-connect-brokers.png',
					'alt' => 'Connecting with brokers in the app',
				),
			),
			array(
				'title' => 'Match & Close',
				'text' => 'Connect the right property, requirement, and broker to move the deal forward.',
				'image' => array(
					'file' => 'app-match-close.png',
					'alt' => 'Matching a property, requirement and broker to close the deal',
				),
			),
		),
	),
	'features' => array(
		'title' => 'Everything a Real Estate Broker Needs',
		'accent' => 'in One App.',
		'text' => 'The essential real estate broker tools, brought into one connected experience.',
		'items' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.2 12 3.5l9 6.7V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-9.8Z"/><path d="M9.3 21v-6.4h5.4V21"/></svg>',
				'title' => 'Property Inventory',
				'text' => 'Add and organize properties so you can quickly find and share relevant opportunities.',
				'image' => array(
					'file' => 'app-property-inventory.png',
					'alt' => 'Property inventory listed in the BrokerMojo app',
				),
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="2.4"/><circle cx="5" cy="5.6" r="2.4"/><circle cx="19" cy="5.6" r="2.4"/><circle cx="5" cy="18.4" r="2.4"/><circle cx="19" cy="18.4" r="2.4"/><path d="m6.8 7 3.5 3.4M17.2 7l-3.5 3.4M6.8 17l3.5-3.4M17.2 17l-3.5-3.4"/></svg>',
				'title' => 'Broker Network',
				'text' => 'Connect with brokers who can bring relevant buyers, properties, and requirements.',
				'image' => array(
					'file' => 'app-broker-network.png',
					'alt' => 'The broker network screen',
				),
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4.5h12A1.5 1.5 0 0 1 18.5 6v13.5a1.5 1.5 0 0 1-1.5 1.5H5V4.5Z"/><path d="M2.8 8h2.2M2.8 12h2.2M2.8 16h2.2"/><circle cx="11.6" cy="11" r="2.1"/><path d="M8.5 16.6a3.3 3.3 0 0 1 6.2 0"/></svg>',
				'title' => 'Broker Contacts',
				'text' => 'Access your broker network when you need the right contact for a deal.',
				'image' => array(
					'file' => 'app-broker-contacts.png',
					'alt' => 'Broker contacts in the app',
				),
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V8.5l6-3.5v16M19 21V11l-8-4.6"/><path d="M8 11h0M8 14.5h0M15 14h0M15 17.5h0"/></svg>',
				'title' => 'Real Estate Projects',
				'text' => 'Get direct access to new and ongoing property projects.',
				'image' => array(
					'file' => 'app-real-estate-projects.png',
					'alt' => 'Real estate projects in the app',
				),
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.6 4.6"/><path d="M8 10.5h5M10.5 8v5"/></svg>',
				'title' => 'Requirements & Leads',
				'text' => 'Discover requirements that match the properties you have.',
				'image' => array(
					'file' => 'app-requirements-leads.png',
					'alt' => 'Requirements and buyer leads in the app',
				),
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"/></svg>',
				'title' => 'Multi-Location Access',
				'text' => 'Discover property opportunities and connect with brokers across different markets.',
				'image' => array(
					'file' => 'app-multi-location.png',
					'alt' => 'Multi-location access in the app',
				),
			),
		),
	),
	'more' => array(
		'title' => 'More Connections. More Opportunities. More Deals.',
		'text' => 'Manage properties, discover requirements, connect with property brokers, track activity, and keep your deal workflow moving from one place.',
		'button_text' => 'Try BrokerMojo',
		'button_url' => 'https://play.google.com/store/apps/details?id=com.brokermojo.app',
	),
	'why' => array(
		'bg_image' => array(
			'file' => 'bg-skyline.jpg',
			'alt' => '',
		),
		'title' => 'Built for Real Estate Brokers.',
		'accent' => 'Built for More Business.',
		'text' => 'A real estate broker app built to connect trusted professionals, better inventory, and more deal opportunities.',
		'cards' => array(
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V9.5l8-5.5 8 5.5V20"/><path d="M4 20h16M9.5 20v-5h5v5"/><path d="m16.5 9.5 3-3M19.5 6.5h-3M19.5 6.5v3"/></svg>',
				'title' => 'India\'s Growing B2B Platform',
				'kicker' => 'More brokers. More inventory. More ways to close.',
				'text' => 'Connect, co-share listings, split opportunities, and grow together.',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4.5 6v6c0 4.6 3.1 8.2 7.5 9.4 4.4-1.2 7.5-4.8 7.5-9.4V6L12 3Z"/><path d="m9 12 2.2 2.2L15.5 10"/></svg>',
				'title' => 'Verified Listings',
				'kicker' => 'Know what you\'re dealing with.',
				'text' => 'Explore reviewed listings and relevant RERA registration details where applicable.',
			),
			array(
				'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2.5 4.5 13.5H11l-1 8 8.5-11.5H12l1-7.5Z"/></svg>',
				'title' => 'Simple & Fast',
				'kicker' => 'Less time managing. More time closing.',
				'text' => 'Add properties, share requirements, and get moving in minutes.',
			),
		),
	),
	'testimonials' => array(
		'title' => 'Real Brokers. Real Experiences.',
		'accent' => 'Real Results.',
		'items' => array(
			array(
				'type' => 'video',
				'photo' => array(
					'file' => 'face-a.jpg',
					'alt' => 'Broker and client talking on a rooftop above the city skyline',
				),
				'cutout' => false,
				'video_url' => '',
				'video_file' => '',
				'tag' => 'Video',
				'name' => 'Raju Chopra',
				'role' => 'Director, Govind Kripa Group',
				'bg_image' => '',
				'quote' => '',
			),
			array(
				'type' => 'video',
				'photo' => array(
					'file' => 'face-b.jpg',
					'alt' => 'Broker in conversation on a rooftop terrace at dusk',
				),
				'cutout' => false,
				'video_url' => '',
				'video_file' => '',
				'tag' => 'Video',
				'name' => 'Builder name',
				'role' => 'Designation, Company',
				'bg_image' => '',
				'quote' => '',
			),
			array(
				'type' => 'quote',
				'photo' => '',
				'cutout' => false,
				'video_url' => '',
				'video_file' => '',
				'tag' => '',
				'bg_image' => array(
					'file' => 'qbg-a.jpg',
					'alt' => '',
				),
				'quote' => 'Testimonial quote goes here.',
				'name' => 'Builder name',
				'role' => 'Designation, Company',
			),
			array(
				'type' => 'video',
				'photo' => array(
					'file' => 'face-d.png',
					'alt' => 'Broker in a white shirt and tie',
				),
				'cutout' => true,
				'video_url' => '',
				'video_file' => '',
				'tag' => 'Video',
				'name' => 'Broker name',
				'role' => 'Designation, City',
				'bg_image' => '',
				'quote' => '',
			),
			array(
				'type' => 'quote',
				'photo' => '',
				'cutout' => false,
				'video_url' => '',
				'video_file' => '',
				'tag' => '',
				'bg_image' => array(
					'file' => 'qbg-b.jpg',
					'alt' => '',
				),
				'quote' => 'Testimonial quote goes here.',
				'name' => 'Broker name',
				'role' => 'Designation, City',
			),
			array(
				'type' => 'quote',
				'photo' => '',
				'cutout' => false,
				'video_url' => '',
				'video_file' => '',
				'tag' => '',
				'bg_image' => array(
					'file' => 'qbg-c.jpg',
					'alt' => '',
				),
				'quote' => 'Testimonial quote goes here.',
				'name' => 'Broker name',
				'role' => 'Designation, City',
			),
		),
		'button_text' => 'Get the App',
	),
	'pricing' => array(
		'title' => 'Start Growing Your Real Estate Business',
		'accent' => 'With BrokerMojo.',
		'plans' => array(
			array(
				'name' => 'Monthly',
				'price' => '₹2,950',
				'popular' => false,
				'tag_text' => '',
				'tag_style' => 'pop',
				'free_title' => 'Free',
				'free_note' => 'Free Until 31st Dec',
				'features' => array(
					'Unlimited listings & requirements',
					'View all contact details',
					'Mark interest on listings',
					'Dedicated coordinator support',
					'Priority visibility in marketplace',
				),
				'button_text' => 'Join BrokerMojo Free',
			),
			array(
				'name' => 'Quarterly',
				'price' => '₹6,136',
				'popular' => false,
				'tag_text' => '',
				'tag_style' => 'pop',
				'free_title' => 'Free',
				'free_note' => 'Free Until 31st Dec',
				'features' => array(
					'Unlimited listings & requirements',
					'View all contact details',
					'Mark interest on listings',
					'Dedicated coordinator support',
					'Priority visibility in marketplace',
				),
				'button_text' => 'Join BrokerMojo Free',
			),
			array(
				'name' => 'Half-Yearly',
				'price' => '₹10,384',
				'popular' => true,
				'tag_text' => 'Most Popular',
				'tag_style' => 'pop',
				'free_title' => 'Free',
				'free_note' => 'Free Until 31st Dec',
				'features' => array(
					'Unlimited listings & requirements',
					'View all contact details',
					'Mark interest on listings',
					'Dedicated coordinator support',
					'Priority visibility in marketplace',
				),
				'button_text' => 'Join BrokerMojo Free',
			),
			array(
				'name' => 'Annual',
				'price' => '₹16,756',
				'popular' => false,
				'tag_text' => 'Best Value',
				'tag_style' => 'best',
				'free_title' => 'Free',
				'free_note' => 'Free Until 31st Dec',
				'features' => array(
					'Unlimited listings & requirements',
					'View all contact details',
					'Mark interest on listings',
					'Dedicated coordinator support',
					'Priority visibility in marketplace',
				),
				'button_text' => 'Join BrokerMojo Free',
			),
		),
		'cta_title' => 'Ready to Find More Opportunities and Close More Deals?',
		'cta_text' => 'Join the app built exclusively for real estate and property brokers.',
	),
	'popup' => array(
		'title' => 'Get the App',
		'subtitle' => 'Smart App For Smart Brokers.',
		'qr_image' => '',
		'qr_caption' => 'Scan to download',
	),
	'faq' => array(
		'title' => 'Questions Brokers',
		'accent' => 'Usually Ask',
		'contact_heading' => 'Contact',
		'button_text' => 'Contact',
		'button_url' => 'https://brokermojo.com/contact',
		'items' => array(
			array(
				'question' => 'What is BrokerMojo?',
				'answer' => 'BrokerMojo is a smart app built exclusively for real estate and property brokers to connect with other brokers, discover properties and requirements, access new projects, and find more opportunities to close deals.',
			),
			array(
				'question' => 'Is BrokerMojo only for real estate brokers?',
				'answer' => 'Yes, BrokerMojo is built specifically for brokers working in the real estate and property industry.',
			),
			array(
				'question' => 'How can BrokerMojo help me get more business?',
				'answer' => 'BrokerMojo helps you connect with more brokers, discover property requirements, access new projects, and find opportunities beyond your existing locality and network.',
			),
			array(
				'question' => 'Can BrokerMojo help me sell outside my locality?',
				'answer' => 'Yes, BrokerMojo is designed to help brokers connect with opportunities, properties, requirements, and brokers across different locations.',
			),
			array(
				'question' => 'Is BrokerMojo built for brokers?',
				'answer' => 'Yes, BrokerMojo is built specifically around the way brokers work, from inventory and requirements to broker collaboration and deal follow-ups.',
			),
			array(
				'question' => 'Can I manage my property inventory?',
				'answer' => 'Yes, BrokerMojo is designed to help brokers keep property opportunities more accessible and organized.',
			),
			array(
				'question' => 'Does BrokerMojo include RERA-registered properties?',
				'answer' => 'Where RERA registration applies, brokers should review the relevant registration details and conduct their own due diligence before proceeding.',
			),
			array(
				'question' => 'Can I connect with other brokers?',
				'answer' => 'Yes, the platform is designed around broker networking, collaboration, inventory sharing, and opportunity discovery.',
			),
			array(
				'question' => 'Is BrokerMojo available on Android and iPhone?',
				'answer' => 'Yes, BrokerMojo is available through both the Google Play and Apple App Store download options.',
			),
			array(
				'question' => 'Is BrokerMojo available in Jaipur?',
				'answer' => 'Yes, BrokerMojo is launching first in Jaipur to bring local real estate brokers, property inventories, and requirements onto one unified platform before expanding across India.',
			),
		),
	),
	'footer' => array(
		'col1_heading' => 'Product',
		'col1_links' => array(
			array(
				'label' => 'Features',
				'url' => '#features',
			),
			array(
				'label' => 'How It Works',
				'url' => '#how',
			),
			array(
				'label' => 'Pricing',
				'url' => '#pricing',
			),
			array(
				'label' => 'Broker Network',
				'url' => '#network',
			),
		),
		'col2_heading' => 'Company',
		'col2_links' => array(
			array(
				'label' => 'About Us',
				'url' => 'https://brokermojo.com/about',
			),
			array(
				'label' => 'Contact',
				'url' => 'https://brokermojo.com/contact',
			),
			array(
				'label' => 'Privacy Policy',
				'url' => 'https://brokermojo.com/privacy',
			),
			array(
				'label' => 'Terms of Use',
				'url' => 'https://brokermojo.com/terms',
			),
		),
		'col3_heading' => 'Get the App',
		'legal_name' => 'BrokerMojo Private Limited',
		'socials' => array(
			array(
				'network' => 'instagram',
				'url' => 'https://www.instagram.com/brokermojo/',
			),
			array(
				'network' => 'facebook',
				'url' => 'https://www.facebook.com/brokermojo',
			),
			array(
				'network' => 'linkedin',
				'url' => 'https://www.linkedin.com/company/brokermojo/about/',
			),
			array(
				'network' => 'youtube',
				'url' => 'https://www.youtube.com/@brokermojo',
			),
		),
		'copyright_before' => 'Copyright ©',
		'copyright_after' => 'BROKERMOJO PRIVATE LIMITED. All rights reserved.',
	),
	'mobile_bar' => array(
		'button_text' => 'Get App',
	),
	'seo' => array(
		'meta_title' => 'BrokerMojo — Smart App For Smart Brokers',
		'meta_description' => 'BrokerMojo helps real estate brokers connect with the right buyers and brokers, discover property requirements, access more inventory, and find sales opportunities beyond their existing network and locality.',
		'og_image' => array(
			'file' => 'bg-rooftop.jpg',
			'alt' => '',
		),
		'show_admin_bar' => false,
	),
);
