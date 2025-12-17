<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use App\Models\Roleuser;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'avatar',
        'address',
        'postcode',
        'thana',
        'district',
        'gender',
        'birthdate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   public function roles(){
        return $this->hasMany('\App\Models\Roleuser', 'user_id', 'id');
    }

    public static function getColumn($id, $columnName){
        $value = User::where('id', $id)->first();
        return $value->$columnName ?? NUll;
    }

    public function userInfo(){
        return User::with('roles')->where('id', auth()->user()->id)->first();
    }

    /**
     * Get Current logged in user All Role ID
     */
    public function getUserRole(){
        //return User::with('roles')->where('id', auth()->user()->id)->first();
        $user = User::with('roles')->where('id', auth()->user()->id)->first();
        return array_column($user->roles->toArray(), 'role_id');
    }


    /**
     * Get Current logged in user Role Details
     */

    public function getUserRoleDetails(){
        return Roleuser::leftjoin('roles', 'roles.id', 'role_users.role_id')
                        ->select('roles.*' , 'role_users.user_id', 'role_users.warehouse_id')
                        ->where('role_users.user_id', auth()->user()->id)
                        //->where('roles.type', 'General')
                        //->first()->role_id ?? NULL;
                        ->get();
    }

    /**
     * Check this logged in user role
     * If his role type is Global
     */

     public function checkUserRoleTypeGlobal(){
        $check = Roleuser::leftjoin('roles', 'roles.id', 'role_users.role_id')
                        ->select('roles.*' , 'role_users.user_id')
                        ->where('role_users.user_id', auth()->user()->id)
                        ->where('roles.type', 'Global')
                        //->first()->role_id ?? NULL;
                        ->get();
        if(count($check) > 0){
            return true;
        } else {
            return false;
        }
     }

     /**
      * Check this logged in user role
      * If his role type is General
      */
      public function checkUserRoleTypeGeneral(){
        $check = Roleuser::leftjoin('roles', 'roles.id', 'role_users.role_id')
                        ->select('roles.*' , 'role_users.user_id')
                        ->where('role_users.user_id', auth()->user()->id)
                        ->where('roles.type', 'General')
                        //->first()->role_id ?? NULL;
                        ->get();
        if(count($check) > 0){
            return true;
        } else {
            return false;
        }
     }


     /**
      * Get Current user
      * Role of General
      */

     public function checkUserGeneralRole($user_id = null){
        if($this->checkUserRoleTypeGlobal() == true){
            return true;
        } else {
            /**
             * its registered from SingleWarehouseController
             *  request()->get('warehouse_id')
             */
            $role = Roleuser::where('user_id', $user_id ?? auth()->user()->id)
                        ->first();
            return $role ?? null;
        }

    }


    public function userGeneralRole($user_id = null){
        if($this->checkUserRoleTypeGlobal() == true){
            return true;
        } else {
            /**
             *
             */
            $role = Roleuser::leftjoin('roles', 'roles.id', 'role_users.role_id')
                        ->select('roles.code as code', 'roles.name as name')
                        ->where('user_id', $user_id ?? auth()->user()->id)
                        ->first();
            return $role ?? null;
        }

    }


     public function userRole($user_id = null){
            /**
             */
            $role = Roleuser::leftjoin('roles', 'roles.id', 'role_users.role_id')
                        ->select('roles.code as code', 'roles.name as name')
                        ->where('user_id', $user_id ?? auth()->user()->id)
                        ->first();
            return $role ?? null;

    }



      /**
     * Check Single Route Name
     * If have access of role of user
     * $role_id Pass Must be Array
     */
    public function checkRoute($role_id, $route_name){
        $route = DB::table('route_lists')->where('route_name', $route_name)->first() ?? null;

        $check = DB::table('route_list_roles')
                    ->leftjoin('route_lists', 'route_lists.id', 'route_list_roles.route_id')
                    ->select('route_lists.*', 'route_list_roles.route_id as route_id', 'route_list_roles.show_as as show_as', 'route_list_roles.role_id as role_id')
                    ->where('route_list_roles.route_id', $route->id ?? null)
                    ->whereIn('route_list_roles.role_id', $role_id)
                    ->first();
        //dd($check);
        return $check ?? null;
    }

    /**
     * hasRoutePermission
     * check if route has permiison of current user
     * @param  mixed $route_name
     * @return void
     */
    public function hasRoutePermission($route_name){
        $currentRoleId = request()->get('hasPermission')->role_id ?? NULL;
        if(auth()->user()->checkUserRoleTypeGlobal() == true){
            $check = true;
        } else {
            $check = $this->checkRoute([$currentRoleId], $route_name);
        }
        return $check;
    }
    /**
     * hasValuePermission
     * HasPermission Routes Column
     * @param  mixed $value
     * @return void
     */

    public function hasRouteValuePermission($value){
        $currentRoleId = request()->get('hasPermission')->$value ?? NULL;
        if(auth()->user()->checkUserRoleTypeGlobal() == true){
            $check = true;
        } else {
            $check = $currentRoleId;
        }
        return $check;
    }

     /**
     * Get Current logged in user Route list
     * ** All Role
     * Where has permission
     */
    public function getUserRouteList(){
        //return array_column($this->getUserRole()->roles->toArray(), 'role_id');
        return $this->routeList($this->getUserRole());
    }

     /**
      * Show Routelist Based on Role id
      * Possibility of one or multiple role
      *
      */

    public function routeList($role_id){
        if($this->checkUserRoleTypeGlobal() == true){
            $route = DB::table('route_lists')
                    ->select('route_lists.*')
                    ->orderBy('route_lists.route_order', 'ASC')
                    ->get();
        }else{
            $route = DB::table('route_list_roles')->leftjoin('route_lists', 'route_lists.id', 'route_list_roles.route_id')
                    ->select('route_lists.*')
                    ->whereIn('route_list_roles.role_id', $role_id)
                    ->orderBy('route_lists.route_order', 'ASC')
                    ->get();
        }
        return $route->groupBy('route_group');
    }
}
