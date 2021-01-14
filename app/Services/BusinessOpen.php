<?php


namespace App\Services;


class BusinessOpen
{
    // returns array of start and end time from string
    public static function fn1($in){
        if(\Str::contains($in,'–')){ $separator = '–'; }
        if(\Str::contains($in,'-')){ $separator = '-'; }
        [$starttime1,$endtime1] = explode($separator,$in);
        $dump = false;
        if(\Illuminate\Support\Str::containsAll($in,['am','pm'])){
            if($dump){ dump('contains both am and pm'); }
            [$starttime,$endtime] = explode($separator,$in);
            // check if first contains am and the second pm OR opposite.
            if(\Illuminate\Support\Str::contains($starttime,'am')) {
                $starttime = str_replace('am','',$starttime);
                if(\Illuminate\Support\Str::contains($starttime,':')) {
                    // time is like 7:15am-{}pm
                    $start = \Carbon\Carbon::createFromTimeString($starttime . " AM");
                    if($dump){      dump('Start Time is ' . $start->format('h:i a')); }
                }else{
                    // time is like 7am-{}pm
                    $start = \Carbon\Carbon::createFromTimeString($starttime . ":00 AM");
                    if($dump){    dump('Start Time is ' . $start->format('h:i a')); }
                }
                $endtime = str_replace('pm','',$endtime);
                if(\Illuminate\Support\Str::contains($endtime,':')) {
                    // time is like 7:15am-7:15pm
                    $end = \Carbon\Carbon::createFromTimeString($endtime . " PM");
                    if($dump){    dump('End Time is ' . $end->format('h:i a')); }
                }else{
                    // time is like 7am-7pm
                    $end = \Carbon\Carbon::createFromTimeString($endtime . ":00 PM");
                    if($dump){  dump('End Time is ' . $end->format('h:i a')); }
                }
                return [$start,$end];
            }
            else{
                //night time. time is like 8:15pm-5:15am
                $starttime = str_replace('pm','',$starttime);
                if(\Illuminate\Support\Str::contains($starttime,':')) {
                    // time is like 7:15am-{}pm
                    $start = \Carbon\Carbon::createFromTimeString($starttime . " PM");
                    if($dump){      dump('Start Time is ' . $start->format('h:i a')); }
                }else{
                    // time is like 7am-{}pm
                    $start = \Carbon\Carbon::createFromTimeString($starttime . ":00 PM");
                    if($dump){      dump('Start Time is ' . $start->format('h:i a')); }
                }
                $endtime = str_replace('am','',$endtime);
                if(\Illuminate\Support\Str::contains($endtime,':')) {
                    // time is like 7:15am-7:15pm
                    $end = \Carbon\Carbon::createFromTimeString($endtime . " AM");
                    if($dump){        dump('End Time is ' . $end->format('h:i a')); }
                }else{
                    // time is like 7am-7pm
                    $end = \Carbon\Carbon::createFromTimeString($endtime . ":00 AM");
                    if($dump){    dump('End Time is ' . $end->format('h:i a')); }
                }
                return [$start,$end];
            }
        }
        elseif(\Illuminate\Support\Str::contains($starttime1,['am']) && \Illuminate\Support\Str::contains($endtime1,['am']) ){
//            dd('this condition');
            $starttime = str_replace('am','',$starttime1);
            if(\Illuminate\Support\Str::contains($starttime,':')) {
                // time is like 7:15am-{}am
                $start = \Carbon\Carbon::createFromTimeString($starttime . " AM");
                if($dump){    dump('Start Time is ' . $start->format('h:i a')); }
            }else{
                // time is like 7am-{}am
                $start = \Carbon\Carbon::createFromTimeString($starttime . ":00 AM");
                if($dump){     dump('Start Time is ' . $start->format('h:i a')); }
            }
            $endtime = str_replace('am','',$endtime1);
            if(\Illuminate\Support\Str::contains($endtime,':')) {
                // time is like 7:15am-{}am
                $end = \Carbon\Carbon::createFromTimeString($endtime . " AM")->addDay();
                if($dump){   dump('End Time is ' . $end->format('h:i a')); }
            }else{
                // time is like 7am-{}am
                $end = \Carbon\Carbon::createFromTimeString($endtime . ":00 AM")->addDay();
                if($dump){    dump('End Time is ' . $end->format('h:i a')); }
            }
            return [$start,$end];
        }
        elseif(\Illuminate\Support\Str::contains($starttime1,['pm']) && \Illuminate\Support\Str::contains($endtime1,['pm']) ){
//            dd('that condition');
            $starttime = str_replace('pm','',$starttime1);
            if(\Illuminate\Support\Str::contains($starttime,':')) {
                // time is like 7:15am-{}am
                $start = \Carbon\Carbon::createFromTimeString($starttime . " PM");
                if($dump){    dump('Start Time is ' . $start->format('h:i a')); }
            }else{
                // time is like 7am-{}am
                $start = \Carbon\Carbon::createFromTimeString($starttime . ":00 PM");
                if($dump){     dump('Start Time is ' . $start->format('h:i a')); }
            }
            $endtime = str_replace('pm','',$endtime1);
            if(\Illuminate\Support\Str::contains($endtime,':')) {
                // time is like 7:15am-{}am
                $end = \Carbon\Carbon::createFromTimeString($endtime . " PM")->addDay();
                if($dump){   dump('End Time is ' . $end->format('h:i a')); }
            }else{
                // time is like 7am-{}am
                $end = \Carbon\Carbon::createFromTimeString($endtime . ":00 PM")->addDay();
                if($dump){    dump('End Time is ' . $end->format('h:i a')); }
            }
            return [$start,$end];
        }
        else{
            if(\Illuminate\Support\Str::contains($in,['am'])){
                if($dump){ dump('both are am'); }
                [$starttime,$endtime] = explode($separator,$in);
                if(\Illuminate\Support\Str::contains($starttime,':')) {
                    // time is like 7:15-{}am
                    $start = \Carbon\Carbon::createFromTimeString($starttime . " AM");
                    if($dump){     dump('Start Time is ' . $start->format('h:i a')); }
                }else{
                    // time is like 7-{}am
                    $start = \Carbon\Carbon::createFromTimeString($starttime . ":00 AM");
                    if($dump){     dump('Start Time is ' . $start->format('h:i a')); }
                }
                $endtime = str_replace('am','',$endtime);
                if(\Illuminate\Support\Str::contains($endtime,':')) {
                    // time is like 7:15-{}am
                    $end = \Carbon\Carbon::createFromTimeString($endtime . " AM");
                    if($dump){  dump('End Time is ' . $end->format('h:i a')); }
                }else{
                    // time is like 7-{}am
                    $end = \Carbon\Carbon::createFromTimeString($endtime . ":00 AM");
                    if($dump){ dump('End Time is ' . $end->format('h:i a')); }
                }
                return [$start,$end];
            }else{
                if($dump){   dump('both are pm'); }
                [$starttime,$endtime] = explode($separator,$in);
                if(\Illuminate\Support\Str::contains($starttime,':')) {
                    // time is like 7:15-{}pm
                    $start = \Carbon\Carbon::createFromTimeString($starttime . " PM");
                    if($dump){    dump('Start Time is ' . $start->format('h:i a')); }
                }else{
                    // time is like 7-{}pm
                    $start = \Carbon\Carbon::createFromTimeString($starttime . ":00 PM");
                    if($dump){     dump('Start Time is ' . $start->format('h:i a')); }
                }
                $endtime = str_replace('pm','',$endtime);
                if(\Illuminate\Support\Str::contains($endtime,':')) {
                    // time is like 7:15-{}pm
                    $end = \Carbon\Carbon::createFromTimeString($endtime . " PM");
                    if($dump){   dump('End Time is ' . $end->format('h:i a')); }
                }else{
                    // time is like 7-{}pm
                    $end = \Carbon\Carbon::createFromTimeString($endtime . ":00 PM");
                    if($dump){    dump('End Time is ' . $end->format('h:i a')); }
                }
                return [$start,$end];
            }
        }
    }

    public static function translateToAmPmString($in){
        switch ($in){
            case "8": $out = "8am"; break;
            case "8h": $out = "8:30am"; break;
            case "9": $out = "9am"; break;
            case "9h": $out = "9:30am"; break;
            case "10": $out = "10am"; break;
            case "10h": $out = "10:30am"; break;
            case "11": $out = "11am"; break;
            case "11h": $out = "11:30am"; break;
            case "12": $out = "12pm"; break;
            case "12h": $out = "12:30pm"; break;
            case "13": $out = "1pm"; break;
            case "13h": $out = "1:30pm"; break;
            case "14": $out = "2pm"; break;
            case "14h": $out = "2:30pm"; break;
            case "15": $out = "3pm"; break;
            case "15h": $out = "3:30pm"; break;
            case "16": $out = "4pm"; break;
            case "16h": $out = "4:30pm"; break;
            case "17": $out = "5pm"; break;
            case "17h": $out = "5:30pm"; break;
            case "18": $out = "6pm"; break;
            case "18h": $out = "6:30pm"; break;
            case "19": $out = "7pm"; break;
            case "19h": $out = "7:30pm"; break;
            case "20": $out = "8pm"; break;
            case "20h": $out = "8:30pm"; break;
            case "21": $out = "9pm"; break;
            case "21h": $out = "9:30pm"; break;
            case "22": $out = "10pm"; break;
            case "22h": $out = "10:30pm"; break;
            case "23": $out = "11pm"; break;
            case "23h": $out = "11:30pm"; break;
            case "0": $out = "00"; break;
            case "0h": $out = "00:30"; break;
            case "1": $out = "1am"; break;
            case "1h": $out = "1:30am"; break;
            case "2": $out = "2am"; break;
            case "2h": $out = "2:30am"; break;
            case "3": $out = "3am"; break;
            case "3h": $out = "3:30am"; break;
            case "4": $out = "4am"; break;
            case "4h": $out = "4:30am"; break;
            case "5": $out = "5am"; break;
            case "5h": $out = "5:30am"; break;
            case "6": $out = "6am"; break;
            case "6h": $out = "6:30am"; break;
            case "7": $out = "7am"; break;
            case "7h": $out = "7:30am"; break;
        }
        return $out;
    }

    // takes start and close translatedStrings and returns - string
    public static function valueToAssign($mondaystart,$mondayclose){
        $start = BusinessOpen::translateToAmPmString($mondaystart);
        $end = BusinessOpen::translateToAmPmString($mondayclose);
        $valuetoassign = $start . '-' . $end;
        if(\Str::contains($start,'am') && \Str::contains($end,'am') && ((int)$mondayclose > (int)$mondaystart  ) ){
            $valuetoassign =  str_replace('am','',$start). '-' . $end;
        }
        if(\Str::contains($start,'pm') && \Str::contains($end,'pm') && ((int)$mondayclose > (int)$mondaystart  ) ){
            $valuetoassign =  str_replace('pm','',$start). '-' . $end;
        }
        return $valuetoassign;
    }

    public static function finalValueToAssign($day,$daystart,$dayclose){
        switch ($day) {
            case 'open24':
                $valuetoassign = "Open 24 Hours";
                break;
            case 'closed':
                $valuetoassign = "Closed";
                break;
            case 'custom':
                $valuetoassign = BusinessOpen::valueToAssign($daystart,$dayclose); break;
        }
        return $valuetoassign;
    }
}
