<?php

namespace App\Http\Controllers;

use App\Models\VROrders;
use App\Models\VRPages;
use App\Models\VRPagesTranslations;
use App\Models\VRReservations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class VRReservationsController extends Controller
{
    private function generateDateRange(Carbon $start_date, Carbon $end_date, $addWhat, $value, $dateFormat)
    {
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->$addWhat($value)) {
            $dates[] = $date->format($dateFormat);
        }

        return $dates;
    }


    public function adminCreate()
    {




        $startTime = Carbon::today()->addHour(11);
        $endTime = Carbon::today()->addHour(22);

        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(3);



        $configuration['times'] = $this->generateDateRange($startTime, $endTime, 'addMinutes', 10, 'H:i');
        $configuration['days'] = $this->generateDateRange($startDate, $endDate, 'addDays', 1, 'Y-m-d');
        $configuration['today'] = Carbon::createFromFormat('Y-m-d', Carbon::today()->toDateString())->toDateString();











//        $masyvas = [4, 7, 5, 8];
//        $currentPage = LengthAwarePaginator::resolveCurrentPage();
//        $col = new Collection($masyvas);
//        $perPage = 1;
//        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
//        $configuration['entries'] = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);








        $configuration['experiences'] = VRPages::with('translations')->get()->toArray();



        return view('admin.reservation', $configuration);


    }

    public function adminStore()
    {

        $data = request()->all();

        $order = VROrders::create([
            'status' => 'reserved'
        ]);


        foreach ($data as $key => $value) {
            if($key == '_token') {

            } else {

                VRReservations::create([

                    'time' => json_encode($value),
                    'pages_id' => $key,
                    'orders_id' => $order['id']

                ]);
            }



        }









//        VRReservations::create([
//
//
//
//        ]);




    }
    
}
