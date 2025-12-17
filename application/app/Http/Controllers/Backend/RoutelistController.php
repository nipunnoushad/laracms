<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Models\Routelist;

class RoutelistController extends Controller
{

    private $routelist;

    public function __construct(RouteList $routelist)
    {
        $this->routelist = $routelist;
    }

    public function index()
    {
        $routelists = $this->routelist::orderBy('route_group', 'ASC')->get();
        return view('backend.routelists.index', ['routelists' => $routelists]);
    }

    public function create()
    {
        return view('backend.routelists.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'route_name' => 'required',
                'route_title' => 'required',
                'route_description' => 'required'
            ]
        );

        // process the login
        if ($validator->fails()) {
            return redirect('backend.routelists.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $getLastOrder = $this->routelist::latest()->first()->route_order+1 ?? 1;
            $attributes = [
                'route_name' => $request->route_name,
                'route_title' => $request->route_title,
                'route_hash' => bcrypt($request->route_name),
                'route_group' => $request->route_group,
                'parent_menu_id' => $request->parent_route_id,
                'show_menu' => $request->show_menu,
                'dashboard_position' => implode(',',$request->dashboard_position ?? [Null]),
                'route_icon' => $request->route_icon,
                'route_order' => $getLastOrder,
                'route_description' => $request->route_description,
            ];
            $routelist = $this->routelist::create($attributes);
            try {
                return redirect()->route('backend_routelist_index')->with(['status' => 1, 'message' => 'Successfully created']);
            } catch (\Exception $e) {
                return redirect()->route('backend_routelist_create')->with(['status' => 0, 'message' => 'Error']);
            }
        }
    }


    public function edit($id)
    {
        $routelist = $this->routelist::find($id);
        return view('backend.routelists.form', ['routelist' => $routelist]);
    }


    public function update(Request $request)
    {
        // store
        $attributes = [
            'route_name' => $request->route_name,
            'route_title' => $request->route_title,
            'route_hash' => bcrypt($request->route_name),
            'route_group' => $request->route_group,
            'parent_menu_id' => $request->parent_route_id,
            'show_menu' => $request->show_menu,
            'dashboard_position' => implode(',',$request->dashboard_position ?? [Null]),
            'route_icon' => $request->route_icon,
            // 'route_order' => $request->route_order,
            'route_description' => $request->route_description,
        ];

        try {
            $routelist = $this->routelist::where('id', $request->id)->update($attributes);
            return redirect()->route('backend_routelist_index')->with(['status' => 1, 'message' => 'Successfully updated']);
        } catch (\Exception $e) {
            return redirect()->route('backend_routelist_edit', $request->id)->with(['status' => 0, 'message' => 'Error']);
        }
    }



    public function destroy($id)
    {
        $routelist = $this->routelist::find($id);
        $routelist->delete();
        return redirect()->route('backend_routelist_index', ['status' => 1, 'message' => 'Successfully deleted']);
    }


        //Update Order /Position
        public function updateOrder(Request $request)
        {
            $routes = $this->routelist::get();
            foreach ($routes as $route) {
                $route->timestamps = false; // To disable update_at field updation
                $id = $route->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $tr = $this->routelist::where('id', $id)->update(['route_order' => $order['position']]);
                        // dump($order);
                    }
                }

            }

            return response('Update Successfully.', 200);
        }


    public function apiGet(Request $request){

        $model = $this->routelist;
        $query = $this->routelist::query();

        $fields  = [
            'button' =>  '
                $this->ButtonSet::edit("backend_routelist_edit", $data->id).
                $this->ButtonSet::delete("backend_routelist_destroy", $data->id)
            ',
            'id'   => '$data->id',
            'route_title' => '$data->route_title',
            'route_name' =>  '$data->route_name',
            'route_group' =>  '$this->Model("Routegroup")::name($data->route_group)',
            'route_description' =>  '$data->route_description',
            'route_order' =>  '$data->route_order',
            'show_menu' =>  '$data->show_menu',
            'dashboard_position' =>  '$data->dashboard_position',
            'created_at' => '$data->created_at->format("d M Y")',
        ];

        return $this->Datatable::generate($request, $query, $fields,   ['daterange' => 'created_at', 'orderby' => 'route_order']);
    }
}