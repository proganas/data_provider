<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function get_all_users(Request $request)
    {
        $result = array();

        $x_data = Storage::get('public/DataProviderX.json');
        $x_array = json_decode($x_data, true);

        $y_data = Storage::get('public/DataProviderY.json');
        $y_array = json_decode($y_data, true);

        if (
            $request->provider
            && $request->statusCode
            && $request->balanceMin
            && $request->balanceMax
            && $request->currency
        ) {
            $statusCode = $request->statusCode;
            if ($request->provider == 'DataProviderX') {
                if ($statusCode == 'authorised') {
                    $statusCode = 1;
                } elseif ($statusCode == 'decline') {
                    $statusCode = 2;
                } elseif ($statusCode == 'refunded') {
                    $statusCode = 3;
                }
                foreach ($x_array as $x) {
                    if (
                        $x['statusCode'] == $statusCode
                        && $x['currency'] == $request->currency
                        && $x['parentAmount'] >= $request->balanceMin
                        && $x['parentAmount'] <= $request->balanceMax
                    ) {
                        $result[] = $x;
                    }
                }
            }

            if ($request->provider == 'DataProviderY') {
                if ($statusCode == 'authorised') {
                    $statusCode = 100;
                } elseif ($statusCode == 'decline') {
                    $statusCode = 200;
                } elseif ($statusCode == 'refunded') {
                    $statusCode = 300;
                }
                foreach ($y_array as $y) {
                    if (
                        $y['status'] == $request->status
                        && $y['currency'] == $request->currency
                        && $y['balance'] >= $request->balanceMin
                        && $y['balance'] <= $request->balanceMax
                    ) {
                        $result[] = $y;
                    }
                }
            }
            dd($result);
        } elseif ($request->provider) {
            if ($request->provider == 'DataProviderX') {
                dd($x_array);
            } elseif ($request->provider == 'DataProviderY') {
                dd($y_array);
            }
        } elseif ($request->statusCode) {
            if ($request->statusCode == 'authorised') {
                foreach ($x_array as $x) {
                    if ($x['statusCode'] == 1) {
                        $result[] = $x;
                    }
                }
                foreach ($y_array as $y) {
                    if ($y['status'] == 100) {
                        $result[] = $y;
                    }
                }
                dd($result);
            } elseif ($request->statusCode == 'decline') {
                foreach ($x_array as $x) {
                    if ($x['statusCode'] == 2) {
                        $result[] = $x;
                    }
                }
                foreach ($y_array as $y) {
                    if ($y['status'] == 200) {
                        $result[] = $y;
                    }
                }
                dd($result);
            } elseif ($request->statusCode == 'refunded') {
                foreach ($x_array as $x) {
                    if ($x['statusCode'] == 3) {
                        $result[] = $x;
                    }
                }
                foreach ($y_array as $y) {
                    if ($y['status'] == 300) {
                        $result[] = $y;
                    }
                }
                dd($result);
            }
        } elseif ($request->balanceMin) {
            $min = $request->balanceMin;
            $max = $request->balanceMax;

            foreach ($x_array as $x) {
                if ($x['parentAmount'] <= $max && $x['parentAmount'] >= $min) {
                    $result[] = $x;
                }
            }

            foreach ($y_array as $y) {
                if ($y['balance'] <= $max && $y['balance'] >= $min) {
                    $result[] = $y;
                }
            }
            dd($result);
        } elseif ($request->currency) {
            foreach ($x_array as $x) {
                if ($x['currency'] == $request->currency) {
                    $result[] = $x;
                }
            }
            foreach ($y_array as $y) {
                if ($y['currency'] == $request->currency) {
                    $result[] = $y;
                }
            }
            dd($result);
        } else {
            $result[] = $x_array;
            $result[] = $y_array;
            dd($result);
        }
    }
}
