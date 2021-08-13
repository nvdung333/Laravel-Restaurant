<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;
use App\Http\Controllers\Backend\Session;


class UserController extends Controller
{
    public function index(Request $request) {
        
        $search_keyword = $request->query('keyword', "");
        $is_admin = $request->query('is_admin', "");

        // Lệnh truy vấn gốc
        $queryORM = DB::table('users')
        ->where(function($query) use ($search_keyword) {
            $query->where('username', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_FullName', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Email', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Phone', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Address', 'LIKE', '%'.$search_keyword.'%');
        });

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Lọc theo quyền system admin hay không
        if ($is_admin != "") {
            if ($is_admin == '1')
            { $queryORM->where('is_admin', 1); }
            if ($is_admin == '0') {
                $queryORM->where(function($query) use ($is_admin) {
                    $query->where('is_admin', '!=', 1);
                    $query->orWhereNull('is_admin');
                });
            }
        }
        
        // Hoàn thành lệnh truy vấn
        $users = $queryORM->paginate(300)->withQueryString();

        $data = [];
        $data['users'] = $users;
        $data['search_keyword'] = $search_keyword;
        $data['is_admin'] = $is_admin;

        return view("backend.users.index", $data);
    }


    public function role(Request $request) {

        $search_keyword = $request->query('keyword', "");
        $is_admin = $request->query('is_admin', "");

        $user_roles = Role_User::all();

        // Lệnh truy vấn gốc
        $queryORM = DB::table('users')
        ->where(function($query) use ($search_keyword) {
            $query->where('username', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_FullName', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Email', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Phone', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Address', 'LIKE', '%'.$search_keyword.'%');
        });

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Lọc theo quyền system admin hay không
        if ($is_admin != "") {
            if ($is_admin == '1')
            { $queryORM->where('is_admin', 1); }
            if ($is_admin == '0') {
                $queryORM->where(function($query) use ($is_admin) {
                    $query->where('is_admin', '!=', 1);
                    $query->orWhereNull('is_admin');
                });
            }
        }
        
        // Hoàn thành lệnh truy vấn
        $users = $queryORM->paginate(300)->withQueryString();

        $data = [];
        $data['users'] = $users;
        $data['user_roles'] = $user_roles;
        $data['search_keyword'] = $search_keyword;
        $data['is_admin'] = $is_admin;

        return view("backend.users.role", $data);
    }


    public function roleUpdate(Request $request) {

        $role_1_checks=$request->input('role_1_checks', "");
        $role_2_checks=$request->input('role_2_checks', "");
        $role_3_checks=$request->input('role_3_checks', "");
        $id_1_of_users=$request->input('id_1_of_users', "");
        $id_2_of_users=$request->input('id_2_of_users', "");
        $id_3_of_users=$request->input('id_3_of_users', "");


        // start store/destroy role 1
            $notchecks_1=[];
            if($role_1_checks != null) {
                foreach($id_1_of_users as $id_1_of_user) {
                    if(!in_array($id_1_of_user, $role_1_checks))
                    { $notchecks_1[]=$id_1_of_user; }
                }
            }
            else {
                foreach($id_1_of_users as $id_1_of_user) {
                    $notchecks_1[]=$id_1_of_user;
                }
            }
            
            $role_1_notchecks = [];
            if($notchecks_1 != null)
            {
                foreach ($notchecks_1 as $notcheck_1)
                { $role_1_notchecks[] = $notcheck_1; }
            }

            if($role_1_checks != null)
            {
                foreach ($role_1_checks as $role_1_check)
                {
                    $action = "store";
                    $user_id = $role_1_check;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 1)
                        {
                            $action="donothing";
                        }
                    }
                    if($action!="donothing")
                    {
                        $new_user_role = new Role_User();
                        $new_user_role->user_id = $user_id;
                        $new_user_role->role_id = 1;
                        $new_user_role->save();
                    }
                }
            }
            
            if($role_1_notchecks != null)
            {
                foreach ($role_1_notchecks as $role_1_notcheck)
                {
                    $action = "donothing";
                    $user_id = $role_1_notcheck;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 1)
                        {
                            $action="destroy";
                        }
                    }
                    if($action=="destroy")
                    {
                        $delete_user_role = Role_User::where('user_id',$user_id)->where('role_id',1)->delete();
                    }
                }
            }
        // end store/destroy role_1


        // start store/destroy role 2
            $notchecks_2=[];
            if($role_2_checks != null) {
                foreach($id_2_of_users as $id_2_of_user) {
                    if(!in_array($id_2_of_user, $role_2_checks))
                    { $notchecks_2[]=$id_2_of_user; }
                }
            }
            else {
                foreach($id_2_of_users as $id_2_of_user) {
                    $notchecks_2[]=$id_2_of_user;
                }
            }
            
            $role_2_notchecks = [];
            if($notchecks_2 != null)
            {
                foreach ($notchecks_2 as $notcheck_2)
                { $role_2_notchecks[] = $notcheck_2; }
            }

            if($role_2_checks != null)
            {
                foreach ($role_2_checks as $role_2_check)
                {
                    $action = "store";
                    $user_id = $role_2_check;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 2)
                        {
                            $action="donothing";
                        }
                    }
                    if($action!="donothing")
                    {
                        $new_user_role = new Role_User();
                        $new_user_role->user_id = $user_id;
                        $new_user_role->role_id = 2;
                        $new_user_role->save();
                    }
                }
            }
            
            if($role_2_notchecks != null)
            {
                foreach ($role_2_notchecks as $role_2_notcheck)
                {
                    $action = "donothing";
                    $user_id = $role_2_notcheck;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 2)
                        {
                            $action="destroy";
                        }
                    }
                    if($action=="destroy")
                    {
                        $delete_user_role = Role_User::where('user_id',$user_id)->where('role_id',2)->delete();
                    }
                }
            }
        // end store/destroy role_2
        

        // start store/destroy role 3
            $notchecks_3=[];
            if($role_3_checks != null) {
                foreach($id_3_of_users as $id_3_of_user) {
                    if(!in_array($id_3_of_user, $role_3_checks))
                    { $notchecks_3[]=$id_3_of_user; }
                }
            }
            else {
                foreach($id_3_of_users as $id_3_of_user) {
                    $notchecks_3[]=$id_3_of_user;
                }
            }
            
            $role_3_notchecks = [];
            if($notchecks_3 != null)
            {
                foreach ($notchecks_3 as $notcheck_3)
                { $role_3_notchecks[] = $notcheck_3; }
            }

            if($role_3_checks != null)
            {
                foreach ($role_3_checks as $role_3_check)
                {
                    $action = "store";
                    $user_id = $role_3_check;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 3)
                        {
                            $action="donothing";
                        }
                    }
                    if($action!="donothing")
                    {
                        $new_user_role = new Role_User();
                        $new_user_role->user_id = $user_id;
                        $new_user_role->role_id = 3;
                        $new_user_role->save();
                    }
                }
            }
            
            if($role_3_notchecks != null)
            {
                foreach ($role_3_notchecks as $role_3_notcheck)
                {
                    $action = "donothing";
                    $user_id = $role_3_notcheck;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 3)
                        {
                            $action="destroy";
                        }
                    }
                    if($action=="destroy")
                    {
                        $delete_user_role = Role_User::where('user_id',$user_id)->where('role_id',3)->delete();
                    }
                }
            }
        // end store/destroy role_3
        

        // Chuyển hướng
        return redirect("/backend/user/role")->with('status', 'Cập nhật thành công!');
    }


    public function srole(Request $request) {

        $search_keyword = $request->query('keyword', "");
        $is_admin = $request->query('is_admin', "");

        $user_roles = Role_User::all();

        // Lệnh truy vấn gốc
        $queryORM = DB::table('users')
        ->where(function($query) use ($search_keyword) {
            $query->where('username', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_FullName', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Email', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Phone', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Address', 'LIKE', '%'.$search_keyword.'%');
        });

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Lọc theo quyền system admin hay không
        if ($is_admin != "") {
            if ($is_admin == '1')
            { $queryORM->where('is_admin', 1); }
            if ($is_admin == '0') {
                $queryORM->where(function($query) use ($is_admin) {
                    $query->where('is_admin', '!=', 1);
                    $query->orWhereNull('is_admin');
                });
            }
        }
        
        // Hoàn thành lệnh truy vấn
        $users = $queryORM->paginate(300)->withQueryString();

        $data = [];
        $data['users'] = $users;
        $data['user_roles'] = $user_roles;
        $data['search_keyword'] = $search_keyword;
        $data['is_admin'] = $is_admin;

        return view("backend.users.srole", $data);
    }


    public function sroleUpdate(Request $request) {

        $role_1_checks=$request->input('role_1_checks', "");
        $role_2_checks=$request->input('role_2_checks', "");
        $role_3_checks=$request->input('role_3_checks', "");
        $id_1_of_users=$request->input('id_1_of_users', "");
        $id_2_of_users=$request->input('id_2_of_users', "");
        $id_3_of_users=$request->input('id_3_of_users', "");


        // start store/destroy role 1
            $notchecks_1=[];
            if($role_1_checks != null) {
                foreach($id_1_of_users as $id_1_of_user) {
                    if(!in_array($id_1_of_user, $role_1_checks))
                    { $notchecks_1[]=$id_1_of_user; }
                }
            }
            else {
                foreach($id_1_of_users as $id_1_of_user) {
                    $notchecks_1[]=$id_1_of_user;
                }
            }
            
            $role_1_notchecks = [];
            if($notchecks_1 != null)
            {
                foreach ($notchecks_1 as $notcheck_1)
                { $role_1_notchecks[] = $notcheck_1; }
            }

            if($role_1_checks != null)
            {
                foreach ($role_1_checks as $role_1_check)
                {
                    $action = "store";
                    $user_id = $role_1_check;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 1)
                        {
                            $action="donothing";
                        }
                    }
                    if($action!="donothing")
                    {
                        $new_user_role = new Role_User();
                        $new_user_role->user_id = $user_id;
                        $new_user_role->role_id = 1;
                        $new_user_role->save();
                    }
                }
            }
            
            if($role_1_notchecks != null)
            {
                foreach ($role_1_notchecks as $role_1_notcheck)
                {
                    $action = "donothing";
                    $user_id = $role_1_notcheck;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 1)
                        {
                            $action="destroy";
                        }
                    }
                    if($action=="destroy")
                    {
                        $delete_user_role = Role_User::where('user_id',$user_id)->where('role_id',1)->delete();
                    }
                }
            }
        // end store/destroy role_1


        // start store/destroy role 2
            $notchecks_2=[];
            if($role_2_checks != null) {
                foreach($id_2_of_users as $id_2_of_user) {
                    if(!in_array($id_2_of_user, $role_2_checks))
                    { $notchecks_2[]=$id_2_of_user; }
                }
            }
            else {
                foreach($id_2_of_users as $id_2_of_user) {
                    $notchecks_2[]=$id_2_of_user;
                }
            }
            
            $role_2_notchecks = [];
            if($notchecks_2 != null)
            {
                foreach ($notchecks_2 as $notcheck_2)
                { $role_2_notchecks[] = $notcheck_2; }
            }

            if($role_2_checks != null)
            {
                foreach ($role_2_checks as $role_2_check)
                {
                    $action = "store";
                    $user_id = $role_2_check;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 2)
                        {
                            $action="donothing";
                        }
                    }
                    if($action!="donothing")
                    {
                        $new_user_role = new Role_User();
                        $new_user_role->user_id = $user_id;
                        $new_user_role->role_id = 2;
                        $new_user_role->save();
                    }
                }
            }
            
            if($role_2_notchecks != null)
            {
                foreach ($role_2_notchecks as $role_2_notcheck)
                {
                    $action = "donothing";
                    $user_id = $role_2_notcheck;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 2)
                        {
                            $action="destroy";
                        }
                    }
                    if($action=="destroy")
                    {
                        $delete_user_role = Role_User::where('user_id',$user_id)->where('role_id',2)->delete();
                    }
                }
            }
        // end store/destroy role_2
        

        // start store/destroy role 3
            $notchecks_3=[];
            if($role_3_checks != null) {
                foreach($id_3_of_users as $id_3_of_user) {
                    if(!in_array($id_3_of_user, $role_3_checks))
                    { $notchecks_3[]=$id_3_of_user; }
                }
            }
            else {
                foreach($id_3_of_users as $id_3_of_user) {
                    $notchecks_3[]=$id_3_of_user;
                }
            }
            
            $role_3_notchecks = [];
            if($notchecks_3 != null)
            {
                foreach ($notchecks_3 as $notcheck_3)
                { $role_3_notchecks[] = $notcheck_3; }
            }

            if($role_3_checks != null)
            {
                foreach ($role_3_checks as $role_3_check)
                {
                    $action = "store";
                    $user_id = $role_3_check;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 3)
                        {
                            $action="donothing";
                        }
                    }
                    if($action!="donothing")
                    {
                        $new_user_role = new Role_User();
                        $new_user_role->user_id = $user_id;
                        $new_user_role->role_id = 3;
                        $new_user_role->save();
                    }
                }
            }
            
            if($role_3_notchecks != null)
            {
                foreach ($role_3_notchecks as $role_3_notcheck)
                {
                    $action = "donothing";
                    $user_id = $role_3_notcheck;
                    $user_roles = Role_User::where('user_id',$user_id)->get();
                    foreach ($user_roles as $user_role)
                    {
                        if($user_role->role_id == 3)
                        {
                            $action="destroy";
                        }
                    }
                    if($action=="destroy")
                    {
                        $delete_user_role = Role_User::where('user_id',$user_id)->where('role_id',3)->delete();
                    }
                }
            }
        // end store/destroy role_3
        

        // Chuyển hướng
        return redirect("/backend/user/srole")->with('status', 'Cập nhật thành công!');
    }


    public function admin(Request $request) {
        
        $search_keyword = $request->query('keyword', "");
        $is_admin = $request->query('is_admin', "");

        // Lệnh truy vấn gốc
        $queryORM = DB::table('users')
        ->where(function($query) use ($search_keyword) {
            $query->where('username', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_FullName', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Email', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Phone', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('User_Address', 'LIKE', '%'.$search_keyword.'%');
        });

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Lọc theo quyền system admin hay không
        if ($is_admin != "") {
            if ($is_admin == '1')
            { $queryORM->where('is_admin', 1); }
            if ($is_admin == '0') {
                $queryORM->where(function($query) use ($is_admin) {
                    $query->where('is_admin', '!=', 1);
                    $query->orWhereNull('is_admin');
                });
            }
        }
        
        // Hoàn thành lệnh truy vấn
        $users = $queryORM->paginate(300)->withQueryString();

        $data = [];
        $data['users'] = $users;
        $data['search_keyword'] = $search_keyword;
        $data['is_admin'] = $is_admin;

        return view("backend.users.admin", $data);
    }


    public function adminUpdate(Request $request) {
        $admin_checks=$request->input('admin_checks', "");
        $id_of_users=$request->input('id_of_users', "");

        // start store/destroy system admin
            $notchecks=[];
            if($admin_checks != null) {
                foreach($id_of_users as $id_of_user) {
                    if(!in_array($id_of_user, $admin_checks))
                    { $notchecks[]=$id_of_user; }
                }
            }
            else {
                foreach($id_of_users as $id_of_user) {
                    $notchecks[]=$id_of_user;
                }
            }
            
            $admin_notchecks = [];
            if($notchecks != null)
            {
                foreach ($notchecks as $notcheck)
                {
                    if(in_array($notcheck, ["1", "2", "3"]))
                    { return redirect("/backend/user/admin")->with('errors', 'Not allowed!'); }
                    $admin_notchecks[] = $notcheck;
                }
            }

            if($admin_checks != null)
            {
                foreach ($admin_checks as $admin_check)
                {
                    $id = $admin_check;
                    $user = User::findorFail($id);
                    $user->is_admin=1;
                    $user->save();
                }
            }
            
            if($admin_notchecks != null)
            {
                foreach ($admin_notchecks as $admin_notcheck)
                {
                    $id = $admin_notcheck;
                    $user = User::findorFail($id);
                    $user->is_admin=0;
                    $user->save();
                }
            }
        // end store/destroy system admin

        // Chuyển hướng
        return redirect("/backend/user/admin")->with('status', 'Cập nhật thành công!');
    }
}
