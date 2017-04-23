<?php

namespace Sitruc\KeenIO\Concerns;

use Sitruc\KeenIO\AddOns\KeenURL;
use Sitruc\KeenIO\AddOns\URLParser;
use Sitruc\KeenIO\AddOns\ReferrerParser;
use Sitruc\KeenIO\AddOns\DateTimeParser;
use Sitruc\KeenIO\AddOns\IpAddressParser;
use Sitruc\KeenIO\AddOns\UserAgentParser;
use Sitruc\KeenIO\AddOns\AddOn as KeenAddOn;

trait AddOns
{
    protected $addOns = [];

    /**
     * Enrich DateTime.
     * By default this will enrich keen's timestamp and place it as a top level key named enriched_timestamp
     *
     * @param  string $source      The location of the datetime to enrich.
     * @param  string $destination The destination of the enriched datetime.
     * @return $this
     */
    public function enrichDatetime($source = 'keen.timestamp', $destination = 'enriched_timestamp')
    {
        return $this->addOn(new DateTimeParser($source, $destination));
    }

    /**
     * Enrich IP Address
     * This add-on uses a client’s IP address to add data about the geographical location of the client when the event was recorded.
     *
     * @param  string $source      The location of the ip address to enrich.
     * @param  string $destination The location of the enriched ip address.
     * @return $this
     */
    public function enrichIpAddress($source, $destination = 'ip_geo_info')
    {
        return $this->addOn(new IpAddressParser($source, $destination));
    }

    /**
     * Enrich User Agent
     * This add-on will take a user agent string and parse it into the
     * device, browser, browser version, operating system, and operating system version.
     *
     * @param  string $source      The location of the user agent string.
     * @param  string $destination The location of the enriched user agent information.
     * @return $this
     */
    public function enrichUserAgent($source, $destination = 'parsed_user_agent')
    {
        return $this->addOn(new UserAgentParser($source, $destination));
    }

    /**
     * Enrich URL
     * This add-on will take a well-formed URL and parse it into its component pieces for rich multi-dimensional analysis.
     *
     * @param  string $source      The location of the url string.
     * @param  string $destination The location of the enriched URL.
     * @return $this
     */
    public function enrichURL($source, $destination)
    {
        return $this->addOn(new URLParser($source, $destination));
    }

    /**
     * Enrich Referrer
     * This add-on will take a well-formed referrer URL and parse it into its source
     *
     * @param  string $referrer_url_input The location of the referrer url. (The url that got the user to the 'page_url_input')
     * @param  string $page_url_input     The location of the url that the referrer url linked to.
     * @param  string $destination        The location of the enriched referrer info.
     * @return $this
     */
    public function enrichReferrer($referrer_url_input, $page_url_input, $destination)
    {
        return $this->addOn(new ReferrerParser($referrer_url_input, $page_url_input, $destination));
    }

    /**
     * Add a Keen Add On.
     *
     * @param KeenAddOn $addOn A subclass of KeenAddOn
     */
    public function addOn(KeenAddOn $addOn)
    {
        $this->addOns[] = $addOn;

        return $this;
    }

    /**
     * Insert the add ons into the keen->addons namespace.
     *
     * @param  array $data The original data of the event.
     * @return array The newly merged data including custom values and add on values.
     */
    protected function mergeAddOns($data)
    {
        foreach ($this->addOns as $addOn) {
            $data['keen']['addons'][] = $addOn->toArray();
        }

        return $data;
    }
}
