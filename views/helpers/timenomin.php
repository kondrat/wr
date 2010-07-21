<?php
/**
 * Time Helper class file.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Time Helper class for easy use of time data.
 *
 * Manipulation of time data.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view.helpers
 * @link http://book.cakephp.org/view/1470/Time
 */
class TimenominHelper extends TimeHelper {

	

/**
 * Returns either a relative date or a formatted date depending
 * on the difference between the current time and given datetime.
 * $datetime should be in a <i>strtotime</i> - parsable format, like MySQL's datetime datatype.
 *
 * ### Options:
 *
 * - `format` => a fall back format if the relative time is longer than the duration specified by end
 * - `end` => The end of relative time telling
 * - `userOffset` => Users offset from GMT (in hours)
 *
 * Relative dates look something like this:
 *	3 weeks, 4 days ago
 *	15 seconds ago
 *
 * Default date formatting is d/m/yy e.g: on 18/2/09
 *
 * The returned string includes 'ago' or 'on' and assumes you'll properly add a word
 * like 'Posted ' before the function output.
 *
 * @param string $dateString Datetime string or Unix timestamp
 * @param array $options Default format if timestamp is used in $dateString
 * @return string Relative time string.
 * @access public
 * @link http://book.cakephp.org/view/1471/Formatting
 */
	function timeAgoInWords($dateTime, $options = array()) {

		$userOffset = null;
		if (is_array($options) && isset($options['userOffset'])) {
			$userOffset = $options['userOffset'];
		}
		$now = time();
		if (!is_null($userOffset)) {
			$now = $this->convert(time(), $userOffset);
		}
		$inSeconds = $this->fromString($dateTime, $userOffset);
		$backwards = ($inSeconds > $now);

		$format = 'j/n/y';
		$end = '+1 month';

		if (is_array($options)) {
			if (isset($options['format'])) {
				$format = $options['format'];
				unset($options['format']);
			}
			if (isset($options['end'])) {
				$end = $options['end'];
				unset($options['end']);
			}
		} else {
			$format = $options;
		}

		if ($backwards) {
			$futureTime = $inSeconds;
			$pastTime = $now;
		} else {
			$futureTime = $now;
			$pastTime = $inSeconds;
		}
		$diff = $futureTime - $pastTime;

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			$current = array();
			$date = array();

			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
			$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

			if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
				$months = 0;
				$years = 0;
			} else {
				if ($future['Y'] == $past['Y']) {
					$months = $future['m'] - $past['m'];
				} else {
					$years = $future['Y'] - $past['Y'];
					$months = $future['m'] + ((12 * $years) - $past['m']);

					if ($months >= 12) {
						$years = floor($months / 12);
						$months = $months - ($years * 12);
					}

					if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
						$years --;
					}
				}
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $pastTime);
				$daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

				if (!$backwards) {
					$days = ($daysInPastMonth - $past['d']) + $future['d'];
				} else {
					$days = ($daysInFutureMonth - $past['d']) + $future['d'];
				}

				if ($future['m'] != $past['m']) {
					$months --;
				}
			}

			if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years --;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$years = $months = $weeks = 0;
			$days = floor($diff / 86400);

			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);
			$seconds = $diff;
		}
		$relativeDate = '';
		$diff = $futureTime - $pastTime;

		if ($diff > abs($now - $this->fromString($end))) {
			//original
			//$relativeDate = sprintf(__('on %s',true), date($format, $inSeconds));
			$relativeDate = sprintf(__('%s',true), date($format, $inSeconds));
		} else {
			if ($years > 0) {
				// years and months and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $years . ' ' . __n('year', 'years', $years, true);
				$relativeDate .= $months > 0 ? ($relativeDate ? ', ' : '') . $months . ' ' . __n('month', 'months', $months, true) : '';
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . __n('week', 'weeks', $weeks, true) : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true) : '';
			} elseif (abs($months) > 0) {
				// months, weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $months . ' ' . __n('month', 'months', $months, true);
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . __n('week', 'weeks', $weeks, true) : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true) : '';
			} elseif (abs($weeks) > 0) {
				// weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $weeks . ' ' . __n('week', 'weeks', $weeks, true);
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true) : '';
			} elseif (abs($days) > 0) {
				// days and hours
				$relativeDate .= ($relativeDate ? ', ' : '') . $days . ' ' . __n('day', 'days', $days, true);
				$relativeDate .= $hours > 0 ? ($relativeDate ? ', ' : '') . $hours . ' ' . __n('hour', 'hours', $hours, true) : '';
			} elseif (abs($hours) > 0) {
				// hours and minutes
				$relativeDate .= ($relativeDate ? ', ' : '') . $hours . ' ' . __n('hour', 'hours', $hours, true);
				//$relativeDate .= $minutes > 0 ? ($relativeDate ? ', ' : '') . $minutes . ' ' . __n('minute', 'minutes', $minutes, true) : '';
			} elseif (abs($minutes) > 0) {
				// minutes only
				$relativeDate .= ($relativeDate ? ', ' : '') . $minutes . ' ' . __n('minute', 'minutes', $minutes, true);
			} else {
				// seconds only
				$relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . __n('second', 'seconds', $seconds, true);
			}

			if (!$backwards) {
				$relativeDate = sprintf(__('%s ago', true), $relativeDate);
			}
		}
		return $relativeDate;
	}


}
