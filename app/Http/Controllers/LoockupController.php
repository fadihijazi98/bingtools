<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoockupController extends Controller
{

    public function index()
    {

        $results = [];

        if (\request()->has('domainName') && \request('domainName') != '') {

            $regularExpression = "((https:\/\/)|(http:\/\/)|\/.*)";

            $domainName = preg_replace('/' . $regularExpression . '/', '', \request('domainName'));

            $results = dns_get_record($domainName, DNS_ALL);

            $results = $this->dnsLookupResultsFormat($results);

        }

        return view('dns.loockup', ['results' => $results]);

    }

    public function dnsLookupResultsFormat($results)
    {

        $newFormat = [];

        $types = collect($results)->pluck('type')->unique()->toArray();

        foreach ($types as $type) {

            $newFormat[] = collect($results)->where('type', $type)->values()->toArray();

        }

        return $newFormat;

    }

}
