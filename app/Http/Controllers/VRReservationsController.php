<?php

namespace App\Http\Controllers;

use App\Models\VROrders;
use App\Models\VRPages;
use App\Models\VRPagesTranslations;
use App\Models\VRReservations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;



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


    public function adminCreate($date = null)
    {
        if ($date == null)
            $date = Carbon::today()->toDateString();



        $startTime = Carbon::today()->addHours(11);

        $workStart = Carbon::today()->addHours(11);







        $endTime = Carbon::today()->addHour(22);

        $startDate = Carbon::today();
        $endDate = Carbon::today()->addWeek(2);





        $configuration['date_from_url'] = $date;
        $configuration['times'] = $this->generateDateRange($startTime, $endTime, 'addMinutes', 10, 'H:i');
        $configuration['days'] = $this->generateDateRange($startDate, $endDate, 'addDays', 1, 'Y-m-d');
        $configuration['experiences'] = VRPages::with('translations')->get()->toArray();
        //$configuration['reservations'] = VRReservations::pluck('time', 'pages_id')->toArray();
        $configuration['reservations'] = VRReservations::get()->toArray();



        return view('admin.reservation', $configuration);


    }

    public function adminStore()
    {

        $timesReserved = VRReservations::pluck('time');
        $timesReservedArray = [];

        foreach ($timesReserved as $value) {
            foreach ($value as $gg) {

                array_push($timesReservedArray, $gg);

            }
        }


        $data = request()->all();
        unset($data['_token']);








        $order = VROrders::create([
            'status' => 'reserved'
        ]);



        foreach ($data as $key => $value) {


                    VRReservations::create([

                        'time' => $value,
                        'pages_id' => $key,
                        'orders_id' => $order['id']

                    ]);

                }


                }
    








    
}
