<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourListRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    public function index(Travel $travel, TourListRequest $tourListRequest)
    {

        $tours = $travel->tours()
            ->when($tourListRequest->priceFrom, function ($query) use ($tourListRequest) {
                $query->where('price', '>=', $tourListRequest->priceFrom * 100);
            })
            ->when($tourListRequest->priceTo, function ($query) use ($tourListRequest) {
                $query->where('price', '<=', $tourListRequest->priceTo * 100);
            })
            ->when($tourListRequest->dateFrom, function ($query) use ($tourListRequest) {
                $query->where('starting_date', '>=', $tourListRequest->dateFrom);
            })
            ->when($tourListRequest->dateTo, function ($query) use ($tourListRequest) {
                $query->where('starting_date', '<=', $tourListRequest->dateTo);
            })
            ->when($tourListRequest->sortBy && $tourListRequest->sortOrder, function ($query) use ($tourListRequest) {
                $query->orderBy($tourListRequest->sortBy, $tourListRequest->sortOrder);
            })
            ->orderBy('starting_date')
            ->paginate();

        return TourResource::collection($tours);

    }
}
