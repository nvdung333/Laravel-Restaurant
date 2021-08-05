<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
Use Illuminate\Support\Carbon;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $routeroles)
    {
        $username = auth()->user()->username;
        $fullname = auth()->user()->User_FullName;
        $dt=time();
        echo "<pre>";
        echo (date("l, Y-m-d H:i:s",$dt))."<br>".($username)." - ".($fullname);
        echo "</pre>";

        $id = auth()->user()->id;
        $users = User::find($id);
        $roles = $users->rolesmodelfunc;
        // dump($roles->toarray());
    
        $alluserroles = [];
        foreach($roles as $role)
        {
            $alluserroles[] = $role->name;
            // echo $role->name.", ";
        }
        echo "<pre>alluserroles: ";
        print_r($alluserroles);
        echo "</pre>";
        
        $total=count($alluserroles);
        // echo "Total: ".$total;
    
        echo "<pre>routeroles: ";
        print_r($routeroles);
        echo "</pre>";

        $requiereroles = explode("|",$routeroles);
        echo "<pre>requiereroles: ";
        print_r($requiereroles);
        echo "</pre>";

        if ($total > 0)
        {
            foreach ($requiereroles as $requiererole)
            {
                if (in_array($requiererole, $alluserroles))
                { return $next($request); }
            }
            abort(403, "YOU DON'T HAVE PERMISSION TO ACCESS.");
        }
        else
        { abort(403, "YOU DO NOT HAVE ANY PERMISSION TO ACCESS."); }
        abort(403);
    }
}
