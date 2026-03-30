<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Package\PackageStoreRequest;
use App\Http\Requests\Package\PackageUpdateRequest;
use App\Models\BasicExtended;
use App\Models\Language;
use App\Models\Package;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    public function settings()
    {
      $data['abe'] = BasicExtended::first();
      return view('admin.packages.settings', $data);
    }

    public function updateSettings(Request $request)
    {
      $be = BasicExtended::first();
      $be->expiration_reminder = $request->expiration_reminder;
      $be->save();

      $request->session()->flash('success', 'Settings updated successfully!');
      return back();
    }
    public function features()
    {
      $be = BasicExtended::first();
      $features = json_decode($be->package_features, true);
      $data['features'] = $features;
      return view('admin.packages.features', $data);
    }

    public function updateFeatures(Request $request)
    {
      $features = $request->features ? json_encode($request->features) : NULL;
      $bes = BasicExtended::all();
      foreach ($bes as $be) {
          $be->package_features = $features;
          $be->save();
      }
      $request->session()->flash('success', 'Features updated successfully!');
      return back();
    }
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $search = $request->search;
        $data['bex'] = $currentLang->basic_extended;
        $data['packages'] = Package::query()->when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('admin.packages.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     */
    public function store(PackageStoreRequest $request)
    {
        if (!isset($request->featured)) $request["featured"] = "0";
        $features = json_encode($request->features);
        Package::create($request->except('features') + [
                'slug' => make_slug($request->title),
                'features' => $features,
        ]);
        Session::flash('success', "Package Created Successfully");
        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::query()->where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::query()->where('is_default', 1)->first();
        }
        $data['bex'] = $currentLang->basic_extended;
        $data['package'] = Package::query()->findOrFail($id);
        return view("admin.packages.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     */
    public function update(PackageUpdateRequest $request)
    {
        if (!array_key_exists('is_trial', $request->all())) {
            $request['is_trial'] = "0";
            $request['trial_days'] = 0;
        }
        if (!in_array('Storage Limit', $request->features)) {
            $request['storage_limit'] = 999999;
        }
        if (!in_array('Table Reservation', $request->features)) {
            $request['table_reservation_limit'] = 999999;
        }
        if (!in_array('Staffs', $request->features)) {
            $request['staff_limit'] = 999999;
        }
        if (!in_array('Online Order', $request->features)) {
            $request['order_limit'] = 999999;
        }
       
        if (!isset($request->featured)) $request["featured"] = "0";
        $features = json_encode($request->features);
        Package::query()->findOrFail($request->package_id)
            ->update($request->except('features') + [
                    'slug' => make_slug($request->title),
                    'features' => $features,
        ]);
        Session::flash('success', "Package Update Successfully");
        return "success";
    }

    public function delete(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $package = Package::query()->findOrFail($request->package_id);
                if ($package->memberships()->count() > 0) {
                    foreach ($package->memberships as $key => $membership) {
                        @unlink(public_path('assets/front/img/membership/receipt/' . $membership->receipt));
                        $membership->delete();
                    }
                }
                $package->delete();
                Session::flash('success', 'Package deleted successfully!');
                return back();
            });
        } catch (\Throwable $e) {
            return $e;
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $ids = $request->ids;
                foreach ($ids as $id) {
                    $package = Package::query()->findOrFail($id);
                    if ($package->memberships()->count() > 0) {
                        foreach ($package->memberships as $key => $membership) {
                            @unlink(public_path('assets/front/img/membership/receipt/' . $membership->receipt));
                            $membership->delete();
                        }
                    }
                    $package->delete();
                }
                Session::flash('success', 'Package bulk deletion is successful!');
                return "success";
            });
        } catch (\Throwable $e) {
            return $e;
        }
    }
}
