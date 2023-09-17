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

        if (empty($request->all())) {
            $result[] = $providerXModel->all();
            $result[] = $providerYModel->all();
            dd($result);
        } elseif ($request->provider && $request->statusCode && $request->currency && $request->balanceMin && $request->balanceMax) {
            if ($request->provider == "DataProviderX") {
                $statusCode = $providerXModel->get_status($request->statusCode, 'X');
                $conditionsX['statusCode'] = $statusCode;
                $conditionsX['currency'] = $request->currency;
                $conditionsX['balanceMin'] = $request->balanceMin;
                $conditionsX['balanceMax'] = $request->balanceMax;
                $filteredDataX = $providerXModel->where($conditionsX);
                dd($filteredDataX);
            }
        } elseif ($request->provider && $request->status && $request->currency && $request->balanceMin && $request->balanceMax) {
            if ($request->provider == "DataProviderY") {
                $status = $providerYModel->get_status($request->status, 'Y');
                $conditionsY['status'] = $status;
                $conditionsY['currency'] = $request->currency;
                $conditionsY['balanceMin'] = $request->balanceMin;
                $conditionsY['balanceMax'] = $request->balanceMax;
                $filteredDataY = $providerYModel->where($conditionsY);
                dd($filteredDataY);
            }
        } elseif ($request->provider) {
            if ($request->provider == 'DataProviderX') {
                dd($providerXModel->all());
            } elseif ($request->provider == 'DataProviderY') {
                dd($providerYModel->all());
            }
        } elseif ($request->statusCode) {
            $statusCode = $providerXModel->get_status($request->statusCode, 'X');
            $status = $providerYModel->get_status($request->statusCode, 'Y');
            $conditionsX['statusCode'] = $statusCode;
            $conditionsY['status'] = $status;
        } elseif ($request->currency) {
            $conditionsX['currency'] = $conditionsY['currency'] = $request->currency;
        } elseif (!empty($request->balanceMin) && !empty($request->balanceMax)) {
            $conditionsX['balanceMin'] = $conditionsY['balanceMin'] = $request->balanceMin;
            $conditionsX['balanceMax'] = $conditionsY['balanceMax'] = $request->balanceMax;
        }


        $filteredDataX = $providerXModel->where($conditionsX);
        $filteredDataY = $providerYModel->where($conditionsY);
        print_r($filteredDataX);
        print_r($filteredDataY);
        die;
    }
}
