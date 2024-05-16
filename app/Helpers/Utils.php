<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\DateTime;

class Utils {

    /**
     * @throws \Exception
     */
    public static function laoDateFormat($date){
        return date_format(new DateTime($date),'d-m-Y');
    }

    public static function numberToText($number): string
    {
        $units = array('Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
        $tens = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');
        $teens = array('Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
        $thousands = array('', 'Thousand', 'Million', 'Billion');

        $text = '';

        if ($number == 0) {
            return $units[0];
        }

        $numDigits = strlen($number);
        $groupCount = ceil($numDigits / 3);
        $number = str_pad($number, $groupCount * 3, '0', STR_PAD_LEFT);

        for ($i = 0; $i < $groupCount; $i++) {
            $group = substr($number, $i * 3, 3);
            $hundreds = (int) $group[0];
            $tensPlace = (int) $group[1];
            $onesPlace = (int) $group[2];

            $textGroup = '';

            if ($hundreds > 0) {
                $textGroup .= $units[$hundreds] . ' Hundred';
            }

            if ($tensPlace > 0 || $onesPlace > 0) {
                if ($hundreds > 0) {
                    $textGroup .= ' and ';
                }

                if ($tensPlace == 1 && $onesPlace > 0) {
                    $textGroup .= $teens[$onesPlace - 1];
                } else {
                    if ($tensPlace > 0) {
                        $textGroup .= $tens[$tensPlace];
                    }
                    if ($onesPlace > 0) {
                        $textGroup .= ' ' . $units[$onesPlace];
                    }
                }
            }

            if ($textGroup !== '') {
                $textGroup .= ' ' . $thousands[$groupCount - $i - 1];
            }

            $text .= $textGroup . ' ';
        }

        return trim($text);
    }

    public static function findUserLevel(){
        return Auth::user()->LevelID;
    }

    public static function findImplementByLevel(){
        $level = Auth::user()->LevelID;
        $implementCode = null;
        if ($level === 'V'){
            $implementCode = Auth::user()->VillageID;
        }else if($level === 'D'){
            $implementCode = Auth::user()->DistrictID;
        }else if($level === 'P'){
            $implementCode = Auth::user()->ProvinceID;
        }else{
            $implementCode = "00";
        }
        return $implementCode;
    }

    public static function findFirstDateByString($date, string $selection = 'first'): string
    {
        $selectDate = strtotime($date.'-01');
        $returnDate = null;
        if ($selection === 'first'){
            $returnDate = date('Y-m-01',$selectDate);
        }else{
            $returnDate = date('Y-m-t',$selectDate);
        }
        return $returnDate;
    }

    public static function convertArrayToString(Array $data){
        $returnData;
        foreach ($data as $key => $item){
            $returnData .= '$item'.',';
        }
        $lenght = strlen($returnData);
        return substr($returnData,0,$lenght - 1);
    }


}
