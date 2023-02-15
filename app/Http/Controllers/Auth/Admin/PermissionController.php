<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $permissions = Permission::with('roles')->latest()->paginate(10);

        return Inertia::render('Auth/Permissions/Index', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'data.name' => 'required|string'
        ]);
        $permission = Permission::create(['name' => $request['data']['name']]);
        activity()->performedOn($permission)
            ->causedBy(Auth::user())
            ->log("مجوز جدید با نام $permission->name افزوده شد. ");
        return redirect()->route(getLocaleName().'.permissions.index')
            ->with('message', 'مجوز با موفقیت افزوده گردید');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //

        return Inertia::render('Auth/Permissions/Add');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Permission $permission)
    {

        return Inertia::render('Auth/Permissions/Edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Permission $permission)
    {
        //

        $request->validate([
            'data.name' => 'required|string'
        ]);
        $permission->name = $request['data']['name'];
        activity()->performedOn($permission)
            ->causedBy(Auth::user())
            ->log("مجوز جدید با نام $permission->name ویرایش شد. ");
        $permission->save();
        return redirect()->route(getLocaleName().'.permissions.index')
            ->with('message', 'مجوز با موفقیت بروزرسانی گردید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Permission $permission)
    {
        //
        activity()->performedOn($permission)
            ->causedBy(Auth::user())
            ->log("مجوز جدید با نام $permission->name حذف شد. ");
        $permission->delete();
        return redirect()->route(getLocaleName().'.permissions.index')
            ->with('message', 'مجوز با موفقیت حذف گردید');
    }

    public function destroyRoleFromPermission(Role $role, Permission $permission)
    {
        activity()->performedOn($permission)
            ->causedBy(Auth::user())
            ->log("مجوز $permissio->name از نقش کاربری $role->name سلب شد.");
        $role->revokePermissionTo($permission);
        return redirect()->route(getLocaleName().'.permissions.index')
            ->with('message', 'نقش کاربری با موفقیت از دسترسی به این مجوز حذف گردید');
    }

    public function addRole(Permission $permission)
    {
        $roles = Role::select(['name', 'id'])->get()->toArray();

        return Inertia::render('Auth/Permissions/AddRole', [
            'permission' => $permission,
            'roles' => $roles
        ]);
    }

    public function setRoleToPermission(Permission $permission, Request $request)
    {


        $request->validate([
            'data' => 'required|array',
            'data.*' => 'integer|exists:roles,id',
        ]);
        foreach ($request['data'] as $role_id) {
            $role = Role::find($role_id);
            $permission->assignRole($role);
            activity()->performedOn($permission)
                ->causedBy(Auth::user())
                ->log("مجوز $permissio->name به نقش کاربری $role->name منضم گردید.");
        }
        return redirect()->route(getLocaleName().'.permissions.index')
            ->with('message', 'مجوز با موفقیت به نقش های کاربری هدف ، انضمام گردید.');
    }
}
