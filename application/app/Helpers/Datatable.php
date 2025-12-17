<?php

namespace App\Helpers;

use DB;
use Illuminate\Routing\Controller;
use App\Helpers\ButtonSet;
use Illuminate\Http\Request;
use App\Http\Traits\GlobalTrait;

class Datatable
{

    use GlobalTrait;

    protected $this;

    /**
     * Datatable Get Data
     * use Api
     * @param $request = Get All Form Input Request
     *
     * @param $query = Set Query Base on Database What you want data
     * During Pass Query As Parameter skip this method ( get(), offset(), limit())
     * Use query() instead of get() in $query
     *
     * @param $field = Which fields you want to show  from Query (Serialize Recommended)
     * Pass fields as Array
     */
    public function ni()
    {
        return $this;
    }


    public static function generate($request, $query, $field, $options = [])
    {
        //dd($query->get()->toArray());
        //unset($this);
        /**Permission to use $this */
        $ins = new self;
        $thiss = $ins->ni();
        //dd($thiss->Query);
        $field = str_ireplace('$this', '$thiss', $field);
        $fields = [];
        //End

        $customColumnFilter = [
            'daterange' => 'created_at',
            'phpcode' => null,
            'collectionquery' => null,
            'phpcodeoutside' => null,
            'searchquery' => null,
            'orderby' => 'id',
            'orderas' => 'asc',
        ];

        $merge_arr = array_replace($customColumnFilter, $options);
        //get array keys from $field array;
        //dd(array_keys($field) );
        foreach (array_keys($field) as $key) {
            $q = $query->get()->toArray();
            if ($q) {
                $check = array_key_exists($key, $q[0]);
                if ($check == true && is_array($q[0][$key])) {

                    $fields [] = 'id';

                } elseif ($check == true) {

                    $fields [] = $key;

                } else {
                    $fields [] = 'id';
                }
            }

        }
//        dd($fields);
        $start = $request->start ?? 0; //Start show data from request count
        $length = $request->length ?? 50; //How much show data
        $search = $request->search['value'] ?? Null; //Search field
        $column = $request->order ? $fields[$request->order[0]['column']] : $merge_arr['orderby']; // column Filter
        $dir = $request->order ? $request->order[0]['dir'] : $merge_arr['orderas']; //Order Descending/Ascending

        //Daterange
        $from_date = date($request->from_date);
        $to_date = date($request->to_date);

        //Total Row Number of Query
        $countTotal = count($query->get());

       //DateRanger and Search Both
       if($search && $request->from_date && $request->to_date){
           if (!empty($merge_arr["searchquery"])) {
               $collection = $query;
               eval('  ' . $merge_arr["searchquery"] . ';');
               //$collection = $collection->orderBy($column, $dir)->get();
               $collection = $collection->orderBy($column, $dir);

           } else {

               $collection = $query->where(function ($q) use ($merge_arr, $request) {
                   $q->whereBetween($merge_arr['daterange'], [$request->from_date, $request->to_date])
                       ->orWhereDate($merge_arr['daterange'], [$request->from_date, $request->to_date]);
               })->where(function($q) use($merge_arr, $request, $fields, $search, $column,$dir) {
               foreach ($fields as $i => $d) {
                   //$collection = $query->orWhere($d, 'LIKE', '%' . $search . '%')->orderBy($column, $dir);
                   $q->orWhere($d, 'LIKE', '%' . $search . '%')->orderBy($column, $dir);
                       /**
                        * if we would to use Any Extra Query here
                        * We can easily that Through collectionQuery
                        * Reminder: Query Code Must be passed here String Type and EleQuent Method
                        */
                       eval(' ' . $merge_arr["collectionquery"] . ';');
                   }
               });
           }

           $collection = $collection;

       }

       //Serach
        elseif ($search) { //For Search
            if (!empty($merge_arr["searchquery"])) {
                $collection = $query;
                eval('  ' . $merge_arr["searchquery"] . ';');
                $collection = $collection->orderBy($column, $dir)->get();
                //$countTotal = count($collection);
                //dd($collection);
            } else {
                foreach ($fields as $i => $d) {
                    $collection = $query->orWhere($d, 'LIKE', '%' . $search . '%')->orderBy($column, $dir);
                    /**
                     * if we would to use Any Extra Query here
                     * We can easily that Through collectionQuery
                     * Reminder: Query Code Must be passed here String Type and EleQuent Method
                     */
                    eval(' ' . $merge_arr["collectionquery"] . ';');

                    //$collection = $collection;

                    //$countTotal = count($collection->get());
                }
            }
            $collection = $collection;
            //$collection = $collection->offset($start)->limit($length)->get();
            //$countTotal = count($collection);
        }
        /**Daterange Search */
        elseif ($request->from_date && $request->to_date) { //For Daterange
            //dd($request->from_date);
            if (!empty($merge_arr["searchquery"])) {
                $collection = $query;
                eval('  ' . $merge_arr["searchquery"] . ';');
                $collection = $collection->where(function ($q) use ($merge_arr, $request) {
                    $q->WhereBetween($merge_arr['daterange'], [$request->from_date, $request->to_date])
                        ->orWhereDate($merge_arr['daterange'], [$request->from_date, $request->to_date]);
                });
                    //->get();
                //$countTotal = count($collection);
                //dd($collection);
            } else {
                $collection = $query
                    ->where(function ($q) use ($merge_arr, $request) {
                        $q->WhereBetween($merge_arr['daterange'], [$request->from_date, $request->to_date])
                            ->orWhereDate($merge_arr['daterange'], [$request->from_date, $request->to_date]);
                    });
                eval(' ' . $merge_arr["collectionquery"] . ';');
                //$collection = $collection->get();

                //$countTotal = count($collection);
            }
            $collection = $collection;
            //$collection = $collection->offset($start)->limit($length)->get();
            //$countTotal = count($collection);
            //End dateRange Search
        }  else { //Default

            $collection = $query->orderBy($column, $dir);
            eval(' ' . $merge_arr["collectionquery"] . ';');
            //$collection = $collection->offset($start)->limit($length)->get();
            //$countTotal = count($collection);

        }


        //If length show  All
        if ($request->length == '-1') { //Show all page
            $collection = $collection->get();
            $countTotal = count($collection);
        }else {
            $countTotal = count($collection->get());
            $collection = $collection->offset($start)->limit($length)->get();
        }


        /**
         * if we would to use Any PhPcode here
         * We can easily that Through phocodeOutSide
         * Reminder: PHP Code Must be passed here String Type
         */
        eval(' ' . $merge_arr["phpcodeoutside"] . ';');


        /**Loop */
        $arr = [];
        foreach ($collection as $key => $data) {

            eval(' ' . $merge_arr["phpcode"] . ';');

            //Evaluted Field
            $val = [];
            foreach ($field as $k => $f) {
                $val[$k] = eval('return ' . $f . ';');
            }
            $arr [] = $val;
        }


        $draw_val = $request->draw;

        $results = array(
            "draw" => intval($draw_val),
            "recordsTotal" => intval($countTotal),
            "recordsFiltered" => intval($countTotal),
            "dir" => $dir,
            "data" => $arr,
        );
        return $results;

    }//End

}