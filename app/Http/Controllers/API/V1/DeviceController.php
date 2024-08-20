<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Devices\StoreDeviceRequest;
use App\Http\Requests\Devices\UpdateDeviceRequest;
use App\Http\Resources\V1\DeviceResource;
use App\Models\Device;
use App\Traits\ApiRessourceTrait;

class DeviceController extends Controller
{
    use ApiRessourceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->returnData(DeviceResource::collection(Device::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceRequest $request)
    {

        $validates = $request->validated();
        $device = Device::create($validates);
        return $this->returnData($device,'Device created successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {

        return $this->returnData($device);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceRequest $request, Device $device)
    {

        $validates = $request->validated();
        $device->update($validates);
        return $this->returnData($device,'Device updated successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return $this->successMessage('Device deleted successfully');
    }

    public function changeDeviceStatus(Device $device){
        $device->is_active = !$device->is_active;
        $device->save();
        return $this->returnData($device,'Device status changed successfully',200);
    }
}
