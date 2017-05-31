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


    public function adminCreate($date = null, $message = null)
    {
        if ($date == null)
            $date = Carbon::today()->toDateString();



        $startTime = Carbon::today()->addHours(11);

        $workStart = Carbon::today()->addHours(11);







        $endTime = Carbon::today()->addHour(22);

        $startDate = Carbon::today();
        $endDate = Carbon::today()->addWeek(2);




        $configuration['message'] = $message;
        $configuration['date_from_url'] = $date;
        $configuration['times'] = $this->generateDateRange($startTime, $endTime, 'addMinutes', 10, 'H:i');
        $configuration['days'] = $this->generateDateRange($startDate, $endDate, 'addDays', 1, 'Y-m-d');
        $configuration['experiences'] = VRPages::with('translations')->get()->toArray();
        $configuration['reservations'] = VRReservations::get()->toArray();



        return view('admin.reservation', $configuration);


    }

    public function adminStore()
    {

        $timesReserved = VRReservations::pluck('time', 'pages_id');


        $data = request()->all();
        unset($data['_token']);


        $message = '';


        foreach ($data as $key => $value) {

            foreach ($timesReserved as $timesKey => $timesValue) {

                if($key == $timesKey && $value == $timesValue) {
                    $message =  'Time already taken';
                    break;

                }

            }

        }

            if(!strlen($message) > 0){

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



            } else {


                return $this->adminCreate(null, $message);
            }



        $message = 'Time reserved successfully!';
        return $this->adminCreate(null, $message);

    }



    
}
