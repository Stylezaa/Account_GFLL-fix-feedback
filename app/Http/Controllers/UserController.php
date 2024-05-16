<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Menu;
use App\Models\MenuPermit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('users.index');
    }

    public function getAllUser()
    {
        $allUser = User::with('getLevel')->get();
        return json_encode($allUser);
    }

    public function getAllLevels()
    {
        $allLevel = Level::all();
        return json_encode($allLevel);
    }

    public function findMenuByMenuId(int $menuId)
    {
        $result = Menu::where('MenuId', 'like', $menuId . '%')->get();
        return json_encode($result);
    }

    public function createUser(Request $request)
    {

        $res = array();
        try {
            $user = User::create([
                'UserID' => $request['UserID'],
                'LevelID' => $request['LevelID'],
                'password' => Hash::make($request['UserPWD']),
                'ImplementCD' => '00',
                'ProvinceID' => $request['ProvinceID'] ?? null,
                'DistrictID' => $request['DistrictID'] ?? null,
                'VillageID' => $request['VillageID'] ?? null,
                'UserName' =>  $request['UserName'],
                'UserAdmin' =>  $request['UserID'] === 'Admin' ? 1 : 0, // or 1 based on your requirement
                'CanPost' => 1,
                'UserPWD' => '', // No password is provided in the SQL query, so it's left empty here. You may adjust this as needed.
                'LastUpdate' => now(), // or a specific datetime value
                'LastUser' => 'Admin',
                'PcName' => null, // The PC name is not provided in the SQL query, so it's left as null here. You may adjust this as needed.
                'created_at' => now(), // or a specific datetime value
                'updated_at' => now(), // or a specific datetime value
                'name' => $request['Name'] ? $request['Name'] : $request['UserName'],
                'email' => $request['Email'],
                'email_verified_at' => null,
                'remember_token' => null,
            ]);

            // $user = User::create([
            //     'UserID' => $request['UserID'],
            //     'LevelID' => $request['LevelID'],
            //     'password' => Hash::make($request['UserPWD']),
            //     'ImplementCD' => $this->findImplement($request),
            //     'ProvinceID' => $request['ProvinceID'] ?? null,
            //     'DistrictID' => $request['DistrictID'] ?? null,
            //     'VillageID' => $request['VillageID'] ?? null,
            //     'UserName' =>  $request['UserName'],
            //     'UserAdmin' => $request['UserID'] === 'Admin' ? 1 : 0, // or 1 based on your requirement
            //     'CanPost' => $request['CanPost'], // or 1 based on your requirement
            //     'UserPWD' => $request['UserPWD'],
            //     'LastUpdate' => now(), // or a specific datetime value
            //     'LastUser' => 'Admin',
            //     'PcName' => 'Bobby',
            // ]);
            if ($user) {
                $res = [
                    'is_success' => true,
                    'message' => 'success',
                ];
            }
        } catch (Exception $exception) {
            return $res = [
                'is_success' => false,
                'message' => $exception->getMessage(),
            ];
        }
        return json_encode($res);
    }

    public function permissionMenuToUser(Request  $request)
    {
        try {
            foreach ($request->data as $item) {
                $menuPermit = MenuPermit::where('UserID', $item['UserID'])
                    ->where('MenuID', $item['MenuID'])
                    ->first();

                if ($menuPermit) {
                    MenuPermit::where('UserID', $item['UserID'])
                        ->where('MenuID', $item['MenuID'])
                        ->update([
                            'MenuAction' => $item['MenuAction'],
                            'CanEdit' => $item['CanEdit'],
                            'CanSave' => $item['CanSave'],
                            'CanExport' => $item['CanExport'],
                            'CanDelete' => $item['CanDelete'],
                        ]);
                } else {
                    MenuPermit::create([
                        'UserID' => $item['UserID'],
                        'LevelID' => $item['LevelID'],
                        'MenuID' => $item['MenuID'],
                        'MenuAction' => $item['MenuAction'],
                        'CanEdit' => $item['CanEdit'],
                        'CanSave' => $item['CanSave'],
                        'CanExport' => $item['CanExport'],
                        'CanDelete' => $item['CanDelete'],
                    ]);
                }
            }
            return json_encode([
                'status' => 200,
                'message' => 'success',
            ]);
        } catch (Exception $exception) {
            return json_encode([
                'status' => 400,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function findImplement(Request $request)
    {
        if ($request['level'] === 'C') {
            return "00";
        } elseif ($request['level'] === 'P') {
            return $request['province'];
        } elseif ($request['level'] === 'D') {
            return $request['province'] . $request['district'];
        } else {
            return $request['province'] . $request['district'] . $request['village'];
        }
    }

    public function my_account_page()
    {
        return view('users.change_password');
    }


    public function change_password(Request $request)
    {

        if (
            $request->current_password &&
            $request->new_password &&
            $request->confirm_new_password &&
            $request->new_password === $request->confirm_new_password
        ) {

            $user = User::where('Rec_Cnt', Auth::user()->Rec_Cnt)->firstOrFail();

            if (Hash::check($request->current_password, Auth::user()->password)) {

                $user->password = Hash::make($request->new_password);
                $user->updated_at = now();
                $saved = $user->save();

                if ($saved) {

                    return Response::json(['status' => 200, 'message' => 'ok']);
                } else {

                    return Response::json(['status' => 400], 400);
                }
            } else {

                return Response::json(['status' => 400, 'message' => 'current_password_is_not_correct']);
            }
        } else {

            return Response::json(['status' => 400], 400);
        }
    }

    public function destroy($id)
    {
        $user = User::where('Rec_Cnt', $id)->firstOrFail();
        $user->delete();
        return json_encode(['status' => 200, 'message' => 'success']);
    }


    public function updateUser(Request $request)
    {

        $res = array();
        try {
            $user = User::where('UserID', $request['UserID'])->update([
                'UserID' => $request['UserID'],
                'LevelID' => $request['LevelID'],
                'ImplementCD' => '00',
                'ProvinceID' => $request['ProvinceID'] ?? null,
                'DistrictID' => $request['DistrictID'] ?? null,
                'VillageID' => $request['VillageID'] ?? null,
                'UserName' =>  $request['UserName'],
                'UserAdmin' =>  $request['UserID'] === 'Admin' ? 1 : 0, // or 1 based on your requirement
                'CanPost' =>  $request['CanPost'],
                'LastUpdate' => now(), // or a specific datetime value
                'LastUser' => 'Admin',
                'name' => $request['Name'] ? $request['Name'] : $request['UserName'],
                'email' => $request['Email'],
                'email_verified_at' => null,
                'remember_token' => null,
            ]);

            if ($user) {
                $res = [
                    'is_success' => true,
                    'message' => 'success',
                ];
            }
        } catch (Exception $exception) {
            return $res = [
                'is_success' => false,
                'message' => $exception->getMessage(),
            ];
        }
        return json_encode($res);
    }

    public function getPermissionMenuByUser($userId)
    {
        try {
            $result = MenuPermit::where('UserID', $userId)->get();
            return json_encode($result);
        } catch (Exception $exception) {
            return $res = [
                'status' => 400,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
