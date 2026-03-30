<?php
/**
 * FAQ copy and context filtering for reusable FAQ sections.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Supplies structured FAQ items by page context.
 */
final class Hotelier_Faq_Content {

	public const CONTEXT_FRONT_PAGE = 'front_page';
	public const CONTEXT_CONTACT    = 'contact';
	public const CONTEXT_SERVICES   = 'services';

	/**
	 * @param string $context One of CONTEXT_* constants.
	 * @return array<int, array{id: string, question: string, blocks: array<int, array<string, mixed>>}>
	 */
	public static function get_items_for_context( $context ) {
		$all = self::get_all_items();
		switch ( $context ) {
			case self::CONTEXT_FRONT_PAGE:
				return array_slice( $all, 0, 6 );
			case self::CONTEXT_CONTACT:
			case self::CONTEXT_SERVICES:
				return $all;
			default:
				return $all;
		}
	}

	/**
	 * @return array<int, array{id: string, question: string, blocks: array<int, array<string, mixed>>}>
	 */
	private static function get_all_items() {
		return array(
			array(
				'id'       => 'increase-occupancy',
				'question' => __( 'How can I increase my hotel occupancy?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Increasing hotel occupancy starts with understanding your market, your competitors, and your demand patterns. Most hotels struggle because pricing, distribution, and online visibility are not properly aligned.', '360-hotelier' ),
					),
					array(
						'p' => __( 'At 360 Hotelier Consulting, we help hotels improve occupancy through smart pricing, OTA optimization, targeted promotions, and a clear commercial strategy that attracts the right guests at the right time of the year.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'revenue-management-simple',
				'question' => __( 'What is hotel revenue management in simple terms?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Hotel revenue management means selling your rooms at the best possible price depending on demand, season, and market conditions.', '360-hotelier' ),
					),
					array(
						'p' => __( 'In simple terms, it helps you:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'sell more rooms', '360-hotelier' ),
							__( 'earn more money per booking', '360-hotelier' ),
							__( 'stay competitive in Cyprus and Greece', '360-hotelier' ),
							__( 'avoid unnecessary discounts', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'It’s one of the most important strategies for increasing hotel profitability.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'not-full-first-step',
				'question' => __( 'My hotel is not full. What should I do first?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'The first step is a hotel performance and pricing analysis.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Most of the time, low occupancy is caused by:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'incorrect pricing', '360-hotelier' ),
							__( 'weak OTA positioning', '360-hotelier' ),
							__( 'limited promotions', '360-hotelier' ),
							__( 'poor distribution strategy', '360-hotelier' ),
							__( 'lack of market targeting', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'A structured revenue and e-commerce strategy can quickly identify the problem and create a clear action plan to improve bookings.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'revenue-without-lowering-prices',
				'question' => __( 'Can I increase hotel revenue without lowering my prices?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Yes, and this is actually the goal of professional hotel consulting.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Instead of lowering prices, we focus on:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'better market positioning', '360-hotelier' ),
							__( 'optimized OTA ranking', '360-hotelier' ),
							__( 'value-added offers', '360-hotelier' ),
							__( 'demand-based pricing', '360-hotelier' ),
							__( 'stronger direct booking strategy', '360-hotelier' ),
							__( 'targeted promotions', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'This allows hotels to increase revenue while maintaining healthy average room rates.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'small-hotels-rm',
				'question' => __( 'Do small hotels really need revenue management?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Absolutely.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Small and boutique hotels in Cyprus and Greece often benefit the most because every room counts.', '360-hotelier' ),
					),
					array(
						'p' => __( 'With proper revenue management, small hotels can:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'compete with larger properties', '360-hotelier' ),
							__( 'improve Booking.com ranking', '360-hotelier' ),
							__( 'increase occupancy', '360-hotelier' ),
							__( 'grow direct bookings', '360-hotelier' ),
							__( 'stabilize low season performance', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'Even a 30–50 room hotel can significantly increase revenue with the right strategy.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'ota-performance',
				'question' => __( 'How can I improve my hotel’s performance on Booking.com and OTAs?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'OTA performance improves when your hotel is properly optimized and actively managed.', '360-hotelier' ),
					),
					array(
						'p' => __( 'This includes:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'strong content and descriptions', '360-hotelier' ),
							__( 'competitive pricing', '360-hotelier' ),
							__( 'correct rate plans', '360-hotelier' ),
							__( 'promotions and visibility tools', '360-hotelier' ),
							__( 'availability and restrictions', '360-hotelier' ),
							__( 'high-quality photos', '360-hotelier' ),
							__( 'ranking strategy', '360-hotelier' ),
						),
					),
					array(
						'p' => __( '360 Hotelier Consulting helps hotels improve their OTA presence and increase booking conversion.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'what-we-do',
				'question' => __( 'What exactly does 360 Hotelier Consulting do for hotels?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( '360 Hotelier Consulting helps hotels grow their occupancy and revenue through a complete commercial strategy.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Services include:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'revenue management', '360-hotelier' ),
							__( 'OTA and e-commerce management', '360-hotelier' ),
							__( 'pricing strategy', '360-hotelier' ),
							__( 'market and competitor analysis', '360-hotelier' ),
							__( 'hotel opening support', '360-hotelier' ),
							__( 'sales and distribution strategy', '360-hotelier' ),
							__( 'direct booking growth', '360-hotelier' ),
							__( 'performance audits', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'The main objective is simple: increase occupancy, increase revenue, and improve profitability.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'new-hotel-opening',
				'question' => __( 'Can you help with a new hotel opening?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Yes, new hotel openings need a strong commercial strategy from the beginning.', '360-hotelier' ),
					),
					array(
						'p' => __( 'We support new hotels with:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'pricing structure', '360-hotelier' ),
							__( 'OTA setup', '360-hotelier' ),
							__( 'market positioning', '360-hotelier' ),
							__( 'revenue planning', '360-hotelier' ),
							__( 'distribution strategy', '360-hotelier' ),
							__( 'online presence', '360-hotelier' ),
							__( 'pre-opening strategy', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'This ensures the hotel enters the market with strong visibility and competitive pricing.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'direct-bookings',
				'question' => __( 'How can I increase direct bookings and reduce OTA commissions?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Direct bookings grow when your website and strategy are properly structured.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Key actions include:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'website optimization', '360-hotelier' ),
							__( 'booking engine improvement', '360-hotelier' ),
							__( 'exclusive direct offers', '360-hotelier' ),
							__( 'SEO and Google visibility', '360-hotelier' ),
							__( 'rate parity strategy', '360-hotelier' ),
							__( 'digital marketing support', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'The goal is to reduce OTA dependency and increase profitability.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'consulting-vs-rm',
				'question' => __( 'What is the difference between hotel consulting and revenue management?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Revenue management focuses mainly on pricing and demand strategy.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Hotel consulting goes further and includes:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'sales strategy', '360-hotelier' ),
							__( 'OTA management', '360-hotelier' ),
							__( 'market positioning', '360-hotelier' ),
							__( 'distribution planning', '360-hotelier' ),
							__( 'commercial strategy', '360-hotelier' ),
							__( 'performance improvement', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'In short, revenue management is one part of hotel consulting, while consulting covers the full growth strategy.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'price-update-frequency',
				'question' => __( 'How often should hotel prices be updated?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Hotel prices should be reviewed at least once per week and more frequently during high season.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Pricing usually changes based on:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'demand', '360-hotelier' ),
							__( 'competitor pricing', '360-hotelier' ),
							__( 'booking pace', '360-hotelier' ),
							__( 'events', '360-hotelier' ),
							__( 'seasonality', '360-hotelier' ),
							__( 'market trends', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'Active pricing management helps hotels maximize both occupancy and revenue.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'low-season',
				'question' => __( 'Can hotel consulting improve low season performance?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Yes, low season strategy is one of the most important areas of hotel consulting.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Solutions include:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'long stay offers', '360-hotelier' ),
							__( 'winter promotions', '360-hotelier' ),
							__( 'niche markets', '360-hotelier' ),
							__( 'corporate and special segments', '360-hotelier' ),
							__( 'targeted campaigns', '360-hotelier' ),
							__( 'dynamic pricing', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'This helps hotels generate demand even during slower periods.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'external-consultant',
				'question' => __( 'Why should I work with an external hotel consultant?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'An external consultant brings experience, market knowledge, and a fresh perspective without the cost of a full-time employee.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Benefits include:', '360-hotelier' ),
					),
					array(
						'ul' => array(
							__( 'professional revenue strategy', '360-hotelier' ),
							__( 'OTA expertise', '360-hotelier' ),
							__( 'objective analysis', '360-hotelier' ),
							__( 'faster decision making', '360-hotelier' ),
							__( 'cost-effective support', '360-hotelier' ),
							__( 'improved performance', '360-hotelier' ),
						),
					),
					array(
						'p' => __( 'Many hotels prefer external consulting because it is flexible and efficient.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'time-to-results',
				'question' => __( 'How long does it take to see results?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Most hotels start seeing improvements within 2 to 4 months after implementing a structured revenue and OTA strategy.', '360-hotelier' ),
					),
					array(
						'p' => __( 'Stronger long-term results usually appear within 6 to 12 months, depending on market conditions and implementation speed.', '360-hotelier' ),
					),
				),
			),
			array(
				'id'       => 'cyprus-greece',
				'question' => __( 'Do you work with hotels in Cyprus and Greece?', '360-hotelier' ),
				'blocks'   => array(
					array(
						'p' => __( 'Yes, 360 Hotelier Consulting works with hotels across Cyprus and Greece, supporting independent hotels, boutique hotels, and new hotel openings with revenue management, OTA optimization, and commercial strategy development.', '360-hotelier' ),
					),
				),
			),
		);
	}
}
