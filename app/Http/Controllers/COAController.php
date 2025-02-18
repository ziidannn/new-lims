<?php

namespace App\Http\Controllers;

use App\Models\COA;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class COAController extends Controller
{
    //ADD COA
    public function index(Request $request)
    {
        $data = COA::all();
        // $auditee = User::with(['roles' => function ($query) {
        //     $query->select('id', 'name');
        // }])
        //     ->whereHas('roles', function ($q) use ($request) {
        //         $q->where('name', 'auditee');
        //     })
        //     ->orderBy('name')->get();
        return view('COA.index', compact('data'));
    }

    //Data COA
    public function data(Request $request)
    {
        $data = COA::with([
            // 'auditee' => function ($query) {
            //     $query->select('id', 'name', 'no_phone');
            // },
            // 'auditstatus' => function ($query) {
            //     $query->select('id', 'title', 'color');
            // },
            // 'auditorId' => function ($query) {
            //     $query->select('id', 'name', 'no_phone');
            // },
            // 'category' => function ($query) {
            //     $query->select('id', 'description', 'status');
            // },
            // 'criteria' => function ($query) {
            //     $query->select('id', 'title', 'status');
            // },
            // 'departments' => function ($query) {
            //     $query->select('id', 'name');
            // },
        ])->orderBy("audit_plans.id", "desc");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_auditee'))) {
                    $instance->whereHas('auditee', function ($q) use ($request) {
                        $q->where('auditee_id', $request->get('select_auditee'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('date_start', 'LIKE', "%$search%")
                        ->orWhere('date_end', 'LIKE', "%$search%")
                        ->orWhere('locations.title', 'LIKE', "%$search%")
                        ->orWhereHas('auditee', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%");
                        });
                    });
                }
            })->make(true);
    }
}
