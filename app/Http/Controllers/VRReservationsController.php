<?php

namespace App\Http\Controllers;

use App\Models\VROrders;
use App\Models\VRPages;
use App\Models\VRPagesTranslations;
use App\Models\VRReservations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class VRReservationsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function displays all Reservations existing in data base
     */
    public function adminIndex()
    {
        $message = Session()->get('message');
        $configuration['message'] = $message;

        $dataFromModel = new VRReservations();
        $configuration['fields'] = $dataFromModel->getFillable();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['list_data'] = VRReservations::get()->where('deleted_at', '=', null)->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }








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
        $endTime = Carbon::today()->addHour(22);

        $startTime2 = Carbon::today()->addHours(11);
        $endTime2 = Carbon::today()->addHour(22);




        $startDate = Carbon::today();
        $endDate = Carbon::today()->addWeek(2);

         $timeNow = Carbon::now(+2)->addHours(1);


        $allTimes = $this->generateDateRange($startTime2, $endTime2, 'addMinutes', 10, 'Y-m-d H:i');


        $disabledTimes = [];
        $enabledTimes = [];

        foreach ($allTimes as $time) {

            if($timeNow <= $time) {
                array_push($enabledTimes, substr($time, 11));
            } else {
                array_push($disabledTimes, substr($time, 11));
            }

        }





        $configuration['message'] = $message;
        $configuration['date_from_url'] = $date;
        $configuration['times'] = $this->generateDateRange($startTime, $endTime, 'addMinutes', 10, 'H:i');
        $configuration['days'] = $this->generateDateRange($startDate, $endDate, 'addDays', 1, 'Y-m-d');
        $configuration['experiences'] = VRPages::with('translations')->get()->toArray();
        $configuration['reservations'] = VRReservations::get()->toArray();
        $configuration['enabledTimes'] = $enabledTimes;
        $configuration['disabledTimes'] = $disabledTimes;
        $configuration['today'] = Carbon::today()->toDateString();



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
