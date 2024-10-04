<?php
/**
 * Template contains iCalndar for event detail page.
 *
 * Override this template by copying it to yourtheme/simple_event_planner/single-event/ical.php
 * 
 * @version     1.0.1
 * @since       1.3.0
 * @since       1.4.0 Updated iCal template with more attributes
 * @author      PressTigers
 * @package     Simple_Event_Planner
 * @subpackage  Simple_Event_Planner/public/partials/single-event
 */
require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );

//set correct content-type-header
header( 'Content-type: text/calendar; charset=utf-8' );
header( 'Content-Disposition: inline; filename=calendar.ics' );

//Get Perameters to Create iCal File.
$uid = sanitize_text_field( $_GET['uid'] );
$link = sanitize_text_field( $_GET['url'] );
$startDate = sanitize_text_field( $_GET['startDate'] );
$endDate = sanitize_text_field( $_GET['endDate'] );
$subject = sanitize_text_field( $_GET['subject'] );
$location = sanitize_text_field( $_GET['location'] );
$sepVersion = sanitize_text_field( $_GET['sep_version'] );
$organiser = sanitize_text_field( $_GET['organiser'] );
$pluginName = 'Simple Event Planner';
$full_format = 'Ymd\THis';
$dateStamp = date( $full_format, time() );
$siteName = sanitize_text_field( $_GET['site_name'] );
$siteURL = sanitize_text_field( $_GET['site_url'] );
$eventDescription = sanitize_text_field( $_GET['description'] );

$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//" . esc_attr( $siteName ) . " - ECPv" . esc_attr( $sepVersion ). "//NONSGML v1.0//EN
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:" . esc_attr( $siteName ) . "
X-ORIGINAL-URL:" . esc_url( $siteURL ) . "
X-WR-CALDESC:" . esc_attr( $pluginName ) . "
BEGIN:VEVENT
SUMMARY:" . esc_attr( $subject ) . "
Description:" . esc_attr( $eventDescription ) . "
URL:" . esc_url( $link ) . "
DTSTART:".esc_attr( $startDate ) ."
DTEND:". esc_attr( $endDate ) ."
DTSTAMP:" . esc_attr( $dateStamp ) . "
UID:" .  esc_attr( $uid ) . "
LOCATION:". esc_attr( $location ) ."
ORGANIZER:". esc_attr( $organiser ) ."
END:VEVENT
END:VCALENDAR";
echo $ical;
exit;