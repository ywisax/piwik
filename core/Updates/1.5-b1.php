<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @version $Id$
 *
 * @category Piwik
 * @package Updates
 */

/**
 * @package Updates
 */
class Piwik_Updates_1_5_b1 extends Piwik_Updates
{
	static function getSql($schema = 'Myisam')
	{
		$tables = Piwik::getTablesCreateSql();

		return array(
			$tables['log_conversion_item'] => false,

			'ALTER IGNORE TABLE `'. Piwik_Common::prefixTable('log_visit') .'`
				 ADD  visitor_days_since_order SMALLINT(5) UNSIGNED NOT NULL AFTER visitor_days_since_last,
				 ADD  visit_goal_buyer TINYINT(1) NOT NULL AFTER visit_goal_converted' => false,

			'ALTER IGNORE TABLE `'. Piwik_Common::prefixTable('log_conversion') .'`
				 ADD visitor_days_since_order SMALLINT(5) UNSIGNED NOT NULL AFTER visitor_days_since_first,
				 ADD idorder varchar(100) default NULL AFTER buster,
				 ADD items SMALLINT UNSIGNED DEFAULT NULL,
				 ADD revenue_subtotal float default NULL,
				 ADD revenue_tax float default NULL,
				 ADD  revenue_shipping float default NULL,
				 ADD revenue_discount float default NULL,
				 ADD UNIQUE KEY unique_idsite_idorder (idsite, idorder),
				 MODIFY  idgoal int(10) NOT NULL' => false,
		);
	}

	static function update()
	{
		Piwik_Updater::updateDatabase(__FILE__, self::getSql());
	}
}
