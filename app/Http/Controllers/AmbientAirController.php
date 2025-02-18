<?php

namespace App\Http\Controllers;

use App\Models\AmbientAir;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AmbientAirController extends Controller
{
    //ADD COA
    public function index(Request $request)
    {
        $data = AmbientAir::all();
        // $auditee = User::with(['roles' => function ($query) {
        //     $query->select('id', 'name');
        // }])
        //     ->whereHas('roles', function ($q) use ($request) {
        //         $q->where('name', 'auditee');
        //     })
        //     ->orderBy('name')->get();
        return view('ambient_air.index', compact('data'));
    }

    public function add(Request $request)
    {
    if ($request->isMethod('POST')) {
        $this->validate($request, [
            'auditee_id'      => ['required'],
            'date_start'      => ['required'],
            'date_end'        => ['required'],
            'location_id'     => ['required'],
            'department_id'   => ['required'],
            'type_audit'      => ['required'],
            'periode'         => ['required'],
            'head_major'      => ['required'],
            'upm_major'       => ['required'],
        ]);

        $auditee = User::find($request->auditee_id);

        $data = AuditPlan::create([
            'auditee_id'      => $request->auditee_id,
            'date_start'      => $request->date_start,
            'date_end'        => $request->date_end,
            'audit_status_id' => '1',
            'location_id'     => $request->location_id,
            'department_id'   => $request->department_id,
            'type_audit'      => $request->type_audit,
            'periode'         => $request->periode,
            'head_major'      => $request->head_major,
            'upm_major'       => $request->upm_major,
        ]);

        if ($request->auditor_id) {
            foreach ($request->auditor_id as $auditorId) {
                AuditPlanAuditor::create([
                    'audit_plan_id' => $data->id,
                    'auditor_id'    => $auditorId,
                ]);
            }
        }
        $audit_plan = AuditPlan::with('auditstatus')->get();
        $locations = Location::orderBy('title')->get();
        $departments = Department::orderBy('name')->get();
        $auditStatus = AuditStatus::orderBy('title')->get();
        $category = StandardCategory::where('status', true)->get();
        $criterias = StandardCriteria::where('status', true)->get();
        $auditee = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditee');
            })
            ->orderBy('name')->get();

        $auditor = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditor');
            })
            ->orderBy('name')->get();

        $data = AuditPlan::all();
        $prd = Carbon::now()->subYears(5)->year;
        return view("audit_plan.add", compact("data", "category", "criterias", "auditee",
        "auditor", "locations", "auditStatus", "departments", "audit_plan", 'prd'));
    }
}

    //Data AmbientAir
    public function data(Request $request)
    {
        $data = AmbientAir::with([
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
        ])->orderBy("ambient_airs.id", "desc");
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

    public function datatables()
    {
        $data = AmbientAir::select('*');
        return DataTables::of($data)->make(true);
    }
}
