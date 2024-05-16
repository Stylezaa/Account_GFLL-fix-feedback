<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonorsController extends Controller
{
    public function index(Request $request)
    {
        $donors = Donor::all();
        // $ditDonors;
        if ($request->query() && $request->query()['action'] === "edit") {
            $ditDonors = Donor::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->first();
            return view('donors.index', compact('ditDonors', 'donors'));
        } else {
            return view('donors.index', compact('donors'));
        }
    }


    public function store(Request $request)
    {

        $rules = [
            'donorId' => 'required|min:1|max:10',
            'donorSym' => 'required:min:1|max:10',
            'currency' => 'required',
            'donorNameL' => 'required|min:1|max:80',
            'donorNameE' => 'required|min:1|max:80',
        ];
        $custom = [
            'donorId.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ໃຫທຶນ',
            'donorSym.required' => 'ກາລຸນາປ້ອນຊື່ຫຍໍ້ຜູ້ໃຫ້ທຶນ',
            'currency.required' => 'ກາລຸນາເລືອສະກຸນເງິນ',
            'donorNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ໃຫ້ທຶນ(ພາສາລາວ)',
            'donorNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ໃຫ້ທອນ(ພາສາອັງກິດ)',
        ];

        $validate = Validator::make($request->all(), $rules, $custom);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        try {
            $donor = new Donor();
            $donor->DonorId = $request->donorId;
            $donor->DonorSym = $request->donorSym;
            $donor->CurrencyCD = $request->currency;
            $donor->DonorNameL = $request->donorNameL;
            $donor->DonorNameE = $request->donorNameE;
            $donor->Stoped = false;
            $donor->Lastuser = Auth::user()->name;
            $donor->PcName = $request->getClientIp();
            $donor->save();

            return redirect()->route('donors.index');
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while saving the donor.'])->withInput();
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'donorId' => 'required|min:1|max:10',
            'donorSym' => 'required:min:1|max:10',
            'currency' => 'required',
            'donorNameL' => 'required|min:1|max:80',
            'donorNameE' => 'required|min:1|max:80',
        ];
        $custom = [
            'donorId.required' => 'ກາລຸນາປ້ອນລະຫັດຜູ້ໃຫທຶນ',
            'donorSym.required' => 'ກາລຸນາປ້ອນຊື່ຫຍໍ້ຜູ້ໃຫ້ທຶນ',
            'currency.required' => 'ກາລຸນາເລືອສະກຸນເງິນ',
            'donorNameL.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ໃຫ້ທຶນ(ພາສາລາວ)',
            'donorNameE.required' => 'ກາລຸນາປ້ອນຊື່ຜູ້ໃຫ້ທອນ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            if (
                $request->action === 'edit'
            ) {
                try {
                    Donor::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->update([
                        'DonorSym' => $request->donorSym,
                        'CurrencyCD' => $request->currency,
                        'DonorNameL' => $request->donorNameL,
                        'DonorNameE' => $request->donorNameE,
                        'Stoped' => $request->donorStop !== null ? true : false,
                        'LastUser' => Auth::user()->name,
                        'PcName' => $request->getClientIp()
                    ]);
                    return redirect()->route('donors.index');
                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the donor.'])->withInput();
                }
            } else {
                try {

                    $maxDonorId = Donor::max('DonorId');
                    $maxDonorId = (int) $maxDonorId;

                    $newDonorId = $maxDonorId + 1;


                    $donor = new Donor();
                    $donor->DonorId =   $newDonorId;
                    $donor->DonorSym = $request->donorSym;
                    $donor->CurrencyCD = $request->currency;
                    $donor->DonorNameL = $request->donorNameL;
                    $donor->DonorNameE = $request->donorNameE;
                    $donor->Stoped = false;
                    $donor->Lastuser = Auth::user()->name;
                    $donor->PcName = $request->getClientIp();
                    $donor->save();

                    return redirect()->route('donors.index');

                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the donor.'])->withInput();
                }
            }
        }
    }

    public function destroy(Request $request)
    {
        try {

            confirmDelete('ແຈ້ງເຕືອນ!', 'ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
            Donor::where('Rec_Cnt', $request->query('Rec_Cnt'))->delete();

            return redirect()->route('donors.index');
            
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while deleting the donor.'])->withInput();
        }
    }

    public function donors()
    {
        $donors = Donor::where('stoped', 0)->get();
        return json_encode($donors);
    }
}
