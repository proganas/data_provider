<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataProvider;

use function PHPUnit\Framework\isEmpty;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $providerXModel = new DataProvider('DataProviderX');
        $providerYModel = new DataProvider('DataProviderY');
        $conditionsX = [];
        $conditionsY = [];
        if (!empty($request->statusCode)) {
            $statusCode = $providerXModel->get_status($request->statusCode, 'X');
            $status = $providerYModel->get_status($request->statusCode, 'Y');
            $conditionsX['statusCode'] = $statusCode;
            $conditionsY['status'] = $status;
        }
        if (!empty($request->currency)) {
            $conditionsX['currency'] = $conditionsY['currency'] = $request->currency;
        }
        if (!empty($request->balanceMin) && !empty($request->balanceMax)) {
            $conditionsX['balanceMin'] = $conditionsY['balanceMin'] = $request->balanceMin;
            $conditionsX['balanceMax'] = $conditionsY['balanceMax'] = $request->balanceMax;
        }
        if (!empty($request->provider)) {
            if ($request->provider == "DataProviderX") {
                $filteredDataX = $providerXModel->where($conditionsX);
            } elseif ($request->provider == "DataProviderY") {
                $filteredDataY = $providerYModel->where($conditionsY);
            }
        } else {
            $filteredDataX = $providerXModel->where($conditionsX);
            $filteredDataY = $providerYModel->where($conditionsY);
        }
        if (!empty($filteredDataX)) {
            print_r($filteredDataX);
        }
        if (!empty($filteredDataY)) {
            print_r($filteredDataY);
        }
        die;
    }
}
