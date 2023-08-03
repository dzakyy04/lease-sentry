<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $this->authorize('super-admin');
        $title = 'Device';
        $device_id = env('DEVICE_ID');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.whacenter.com/api/statusDevice?device_id=$device_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $detail = json_decode($response);
        return view('device.index', compact('title', 'device_id', 'detail'));
    }

    public function update(Request $request)
    {
        $this->authorize('super-admin');

        $request->validate([
            'device_id' => 'required'
        ]);

        $newDeviceID = $request->device_id;

        $envFilePath = base_path('.env');
        $envFileContent = file_get_contents($envFilePath);

        if (strpos($envFileContent, 'DEVICE_ID') !== false) {
            $envFileContent = preg_replace(
                '/DEVICE_ID=[^\r\n]*/',
                'DEVICE_ID=' . $newDeviceID,
                $envFileContent
            );
        } else {
            $envFileContent .= "\nDEVICE_ID=" . $newDeviceID;
        }

        file_put_contents($envFilePath, $envFileContent);

        return back()->with('success', 'Device id berhasil diganti');
    }
}
