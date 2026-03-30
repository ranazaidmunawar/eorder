<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\Popup\StoreRequest;
use App\Http\Requests\Popup\UpdateRequest;
use App\Models\User\Popup;
use App\Models\User\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        $userId = getRootUser()->id;

        $lang = Language::where('code', $request->language)->where('user_id',$userId)->first();

        $information['user_popups'] = Popup::query()
            ->where('language_id', $lang->id)
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
         
        return view('user.popup.index', $information);
    }

    /**
     * Show the popup type page to select one of them.
     *
     * @return
     */
    public function popupType()
    {
        $userId = getRootUser()->id;
        $defaultLang = Language::query()
            ->where('user_id', $userId)
            ->where('is_default',1)
            ->select('code')
            ->first();
        return view('user.popup.popup-type',['defaultLang' => $defaultLang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create($type)
    {
        $userId = getRootUser()->id;
        $information['popupType'] = $type;
        $information['languages'] = Language::where('user_id', $userId)->get();
        return view('user.popup.create', $information);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(StoreRequest $request)
    {
        $userId = getRootUser()->id;

        $imageName = Uploader::upload_picture(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $request->file('image'));
        Popup::create($request->except('image', 'end_date', 'end_time','user_language_id','user_id') + [
                'image' => $imageName,
                'user_id' => $userId,
                'language_id' => $request->user_language_id,
                'end_date' => $request->has('end_date') ? Carbon::parse($request['end_date']) : null,
                'end_time' => $request->has('end_time') ? date('h:i', strtotime($request['end_time'])) : null
            ]);
        $request->session()->flash('success', 'New popup added successfully!');
        return "success";
    }

    /**
     * Update the status of specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return
     */
    public function updateStatus(Request $request, int $id)
    {
        $userId = getRootUser()->id;
        $popup = Popup::query()->where('user_id', $userId)->find($id);
        if ($request->status == 1) {
            $popup->update(['status' => 1]);
            $request->session()->flash('success', 'Popup activated successfully!');
        } else {
            $popup->update(['status' => 0]);
            $request->session()->flash('success', 'Popup deactivated successfully!');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id)
    {
        $userId = getRootUser()->id;
        $defaultLang = Language::query()
            ->where('user_id', $userId)
            ->where('is_default',1)
            ->select('code')
            ->first();
            $popup = Popup::query()->where('user_id', $userId)->find($id);
        
        return view('user.popup.edit', compact('popup','defaultLang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function update(UpdateRequest $request, $id)
    {
        $userId = getRootUser()->id;
        $popup = Popup::query()->where('user_id', $userId)->find($id);
        if ($request->hasFile('image')) {
            $imageName = Uploader::update_picture(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $request->file('image'), $popup->image);
        }
        $popup->update($request->except('image', 'end_date', 'end_time') + [
                'image' => $request->hasFile('image') ? $imageName : $popup->image,
                'end_date' => $request->has('end_date') ? Carbon::parse($request['end_date']) : null,
                'end_time' => $request->has('end_time') ? date('h:i', strtotime($request['end_time'])) : null
            ]);
        $request->session()->flash('success', 'Popup updated successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return
     */
    public function destroy($id)
    {
        $userId = getRootUser()->id;
        $popup = Popup::query()->where('user_id', $userId)->find($id);
        Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $popup->image);
        $popup->delete();
        return redirect()->back()->with('success', 'Popup deleted successfully!');
    }

    /**
     * Remove the selected or all resources from storage.
     *
     * @param Request $request
     * @return string
     */
    public function bulkDestroy(Request $request)
    {
        $userId = getRootUser()->id;
        $ids = $request->ids;
        foreach ($ids as $id) {
            $popup = Popup::query()->where('user_id', $userId)->find($id);
            Uploader::remove(Constant::WEBSITE_ANNOUNCEMENT_POPUP_IMAGE, $popup->image);
            $popup->delete();
        }
        $request->session()->flash('success', 'Popups deleted successfully!');
        return "success";
    }
}
