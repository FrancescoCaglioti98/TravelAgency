<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    public function store(Travel $travel, TourRequest $tourRequest)
    {
        $tour = $travel->tours()->create($tourRequest->validated());

        return new TourResource($tour);
    }
}
