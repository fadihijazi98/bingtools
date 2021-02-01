<?php

namespace App\Http\Controllers;

use App\Models\SubnetInfo;
use App\Models\SubnetIps;
use App\scripts\ipv4_subnet_calculator_php\SubnetCalculator;
use Illuminate\Http\Request;

class IpsTrackerController extends Controller
{

    public function index()
    {

        $data = [];

        if (\request('ip')) {
            $data['ip'] = \request('ip');
        }

        if (\request('cidr_size')) {
            $data['cidr_size'] = \request('cidr_size');
        }

        return view('subnets.index', $data);

    }

    public function search(Request $request)
    {

        $ipAddress = $request->ip;

        $cidr_size = $request->cidr_size;

        try {

            $subnetApi = new SubnetCalculator($ipAddress, $cidr_size);

        } catch (\Exception $e) {

            dd($e->getMessage());

        }

        $data = ['ip' => $ipAddress, 'cidr_size' => $cidr_size];

        if (!SubnetInfo::where('ip_address', $ipAddress)->where('cidr_size', $cidr_size)->exists()) {

            $subnet = SubnetInfo::create(['ip_address' => $ipAddress, 'cidr_size' => $cidr_size]);

            foreach ($subnetApi->getAllIPAddresses() as $ip) {

                SubnetIps::create(['ip' => $ip, 'subnet_ip_address' => $subnet->id]);

            }

            $data['subnet_ip'] = $subnet->id;

        } else {

            $data['subnet_ip'] = SubnetInfo::where('ip_address', $ipAddress)->where('cidr_size', $cidr_size)->first()->id;

        }

        return view('subnets.index', $data);

    }

    public function fetchIps($ip, $from = 0, $limit = 10)
    {

        return SubnetIps::where('subnet_ip_address', $ip)->skip($from)->limit($limit)->get();

    }

    public function checkIp($ip, $subnet_ip_address)
    {

        exec("ping -c 1 -w 3 " . $ip . " | head -n 2 | tail -n 1 | awk '{print $7}'", $ping_time);

        $subnetIp = SubnetIps::where('ip', $ip)->where('subnet_ip_address', $subnet_ip_address)->first();

        if (empty($ping_time[0])) {

            $subnetIp->status = "unused";
            $subnetIp->response_time = 0.0;

        } else {

            $subnetIp->status = "used";
            $subnetIp->response_time = substr($ping_time[0], 5, strlen($ping_time[0]));// e.g: $ping_time[0] = time=97.0

        }

        $subnetIp->save();

        return [$subnetIp->response_time, $subnetIp->status, $subnetIp->updated_at->diffForHumans()];

    }

    public function updateComment(Request $request) {

        $ip = SubnetIps::find($request->id_ip);

        $ip->timestamps = false;

        $ip->comment = $request->value;

        return $ip->save();

    }

}
