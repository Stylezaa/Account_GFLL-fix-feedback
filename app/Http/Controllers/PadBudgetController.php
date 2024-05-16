<?php

namespace App\Http\Controllers;

use App\Helpers\GetLang;
use App\Helpers\Utils;
use App\Models\Reports\ReportsPadBudgetModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PadBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        return view('pad-budget.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return false|string
     */
    public function loadPadBudgetData(Request $request)
    {
        $queryData = DB::select($this->getQuery($request));

        if ($queryData === null || count($queryData) === 0) {
            return json_encode(array("data" => [], "message" => "ບໍ່ພົບຂໍ້ມູນ"));
        } else {
            return json_encode(array("data" => $queryData, "message" => "FOUND DATA"));
        }
    }

    private function getQuery(Request $request): string
    {
        $implementCd = Utils::findImplementByLevel();
        $lang = GetLang::getLang();
        $queryData = "SELECT A.ActivityID, A.CategoryID, A.BSPCat_ID, A.ActivityName" . $lang . " AS ActivityName,
                        ISNULL(P.AmountLAK, 0) AS AmountLAK,
                            ISNULL(P.Rate, $request->rate) AS Rate, ISNULL(P.AmountUSD, 0) AS
                                AmountUSD, P.RecordCnt
                                    FROM KSPAD_ACT_CAT AS P RIGHT OUTER JOIN KSActivities AS A ON P.ActivityID = A.ActivityID
                                        WHERE (A.LevelID= '$request->level') AND (A.ImplementCD= $implementCd)
                                                ORDER BY A.ActivityID, A.CategoryID, A.BSPCat_ID";

        return $queryData;
    }

    public function savePadBudget(Request $request)
    {
        DB::beginTransaction();
        $lang = GetLang::getLang();
        try {
            $implementCd = Utils::findImplementByLevel();
            $userIp = $request->ip();
            $userPc = gethostbyaddr($userIp);
            $userName = Auth::user()->name;
            $data = $request->data;
            $postRequest = $request->postRequest;


            for ($i = 0; $i < count($data); $i++) {
                try {
                    DB::select('exec ST_ADD_KSPAD_Budget ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
                        $postRequest['level'],
                        $implementCd,
                        strlen($postRequest['province']) == 0 ? null : $postRequest['province'],
                        strlen($postRequest['district']) == 0 ? null : $postRequest['district'],
                        strlen($postRequest['village']) == 0 ? null : $postRequest['village'],
                        trim($data[$i]['ActivityID']),
                        (double)$data[$i]['AmountUSD'],
                        (double)$data[$i]['Rate'],
                        (double)$data[$i]['AmountLAK'],
                        $userName,
                        $userPc
                    ]);
                    Log::info('DB insert success Pad Budget', ['data' => $data[$i]]);
                } catch (\Exception $e) {
                    Log::error('DB insert error  Pad Budget: ' . $e->getMessage(), ['data' => $data[$i]]);
                }
            }

            DB::commit();
            $msg = $lang == 'L' ? 'ການບັນທຶກສຳເລັດແລ້ວ.' : 'Save Completed.';
            return response()->json(['message' => $msg, 'isSuccess' => true]);

        } catch (\Exception $exception) {
            DB::rollback();
            $msg = $lang == 'L' ? 'ມີບັນຫາໃນການບັນທຶກ: ' . $exception->getMessage() : 'Error occurred during saving: ' . $exception->getMessage();
            return response()->json(['error' => $msg,'isSuccess' => false]);
        }
    }

    public function preViewPadBudgetData(Request  $request){
        $lang = strtoupper(GetLang::getLang());
        $implement = Utils::findImplementByLevel();
        $queryData = DB::select("SELECT * FROM dbo.RPTPADBUDGET('C','$implement',null,null,null,'$lang','RPTPAD')");


        $groupedData = [];

        $groupNames = [
            'ComponentID' => [],
        ];

        foreach ($queryData as $entry) {


            $componentId = $entry->ComponentID;
            $subComponentId = $entry->SubComponentID;
            $groupActId =  $entry->GroupActID;
            $activityId =  $entry->ActivityID;



            if (!array_key_exists($componentId, $groupedData)) {
                $groupedData[$componentId] = [];
            }

            if (!array_key_exists($subComponentId, $groupedData[$componentId])) {
                $groupedData[$componentId][$subComponentId] = [];
            }

            if (!array_key_exists($groupActId, $groupedData[$componentId][$subComponentId])) {
                $groupedData[$componentId][$subComponentId][$groupActId] = [];
            }

            $groupedData[$componentId][$subComponentId][$groupActId][] = $activityId;
            $groupedData[$componentId][$subComponentId][$groupActId][$activityId] = $entry;




        }


        return view('pad-budget.preview',compact('queryData'));
    }


}
