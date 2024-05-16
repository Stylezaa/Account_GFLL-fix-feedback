<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        // $editCategory;
        if ($request->query() && $request->query()['action'] === "edit") {
            $editCategory = Category::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->first();
            return view('category.index', compact('editCategory', 'categories'));
        } else {
            return view('category.index', compact('categories'));
        }
    }


    public function store(Request $request)
    {
        $rules = [
            'CategoryID' => 'required|min:1|max:10',
            'CategorySym' => 'required:min:1|max:10',
            'CategoryNameL' => 'required|min:1|max:180',
            'CategoryNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'CategoryID.required' => 'ກາລຸນາປ້ອນລະຫັດປະເພດລາຍຈ່າຍ',
            'CategorySym.required' => 'ກາລຸນາປ້ອນຊື່ຫຍໍ້ປະເພດລາຍຈ່າຍ',
            'CategoryNameL.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາລາວ)',
            'CategoryNameE.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            $cate = new Category();
            $cate->CategoryID = $request->CategoryID;
            $cate->CategorySym = $request->CategorySym;
            $cate->CategoryNameL = $request->CategoryNameL;
            $cate->CategoryNameE = $request->CategoryNameE;
            $cate->Stoped = false;
            $cate->Lastuser = Auth::user()->name;
            $cate->PcName = $request->getClientIp();
            $cate->save();
        }
        return redirect()->route('cate.index');
    }

    public function update(Request $request)
    {
        $rules = [
            'CategoryID' => 'required|min:1|max:10',
            'CategorySym' => 'required:min:1|max:10',
            'CategoryNameL' => 'required|min:1|max:180',
            'CategoryNameE' => 'required|min:1|max:180',
        ];
        $custom = [
            'CategoryID.required' => 'ກາລຸນາປ້ອນລະຫັດປະເພດລາຍຈ່າຍ',
            'CategorySym.required' => 'ກາລຸນາປ້ອນຊື່ຫຍໍ້ປະເພດລາຍຈ່າຍ',
            'CategoryNameL.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາລາວ)',
            'CategoryNameE.required' => 'ກາລຸນາປ້ອນຊື່ປະເພດລາຍຈ່າຍ(ພາສາອັງກິດ)',
        ];
        $validate = Validator::make($request->all(), $rules, $custom);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        } else {
            if (
                $request->action === 'edit'
            ) {
                try {
                    Category::where('Rec_Cnt', '=', $request->query()['Rec_Cnt'])->update([
                        'CategorySym' => $request->CategorySym,
                        'CategoryNameL' => $request->CategoryNameL,
                        'CategoryNameE' => $request->CategoryNameE,
                        'Stoped' => $request->CategoryStop !== null ? true : false,
                        'LastUser' => Auth::user()->name,
                        'PcName' => $request->getClientIp()
                    ]);

                    return redirect()->route('cate.index');
                } catch (\Exception $e) {
                    return back()->withErrors(['error' => 'An error occurred while saving the Category.'])->withInput();
                }
            } else {
                try {

                    $maxCategoryID = Category::max('CategoryID');
                    $maxCategoryID = (int) $maxCategoryID;
                    $newCategoryID = $maxCategoryID + 1;
   
                    $category = new Category();
                    $category->CategoryID = $newCategoryID >= 10 ? (string) $newCategoryID : '0' . (string) $newCategoryID;
                    $category->CategorySym = $request->CategorySym;
                    $category->CategoryNameL = $request->CategoryNameL;
                    $category->CategoryNameE = $request->CategoryNameE;
                    $category->Stoped = false;
                    $category->Lastuser = Auth::user()->name;
                    $category->PcName = $request->getClientIp();
                    $category->save();

                    return redirect()->route('cate.index');
                } catch (\Exception $e) {
                    // Handle other exceptions if needed
                    return back()->withErrors(['error' => 'An error occurred while saving the category.'])->withInput();
                }
            }
        }
    }

    public function destroy(Request $request)
    {
        try {

            confirmDelete('ແຈ້ງເຕືອນ!', 'ຕ້ອງການລົບແທ້ຫຼືບໍ່?');
            Category::where('Rec_Cnt', $request->query('Rec_Cnt'))->delete();
            return redirect()->route('cate.index');
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return back()->withErrors(['error' => 'An error occurred while deleting the Category.'])->withInput();
        }
    }

    public function categories()
    {
        $categories = Category::where('Stoped', '=', 0)->get();
        return json_encode($categories);
    }
}
