<?php
class Helper_Main
{
    /*
     * Clean request from xss-injections
     * @param request array
     * @return request array
     */
    public static function clean($request)
    {
        foreach ($request as &$value) {
            if (is_array($value)){
                $value = self::clean($value);
            } else {
                if(!get_magic_quotes_gpc()) {
                    $value = addslashes($value);
                }
                $value = strip_tags(htmlspecialchars(stripslashes($value)));
            }
        }
        return $request;
    }
    
    /*
     * Serialize array
     * @param arr array
     * @return arr array
     */    
    public static function serializeData($arr)
    {
        foreach ($arr as &$value) {
            if(is_array($value)){
                $value = serialize($value);
            }
        }
        return $arr;
    }

    /*
     * Unserialize array
     * @param arr array
     * @return arr array
     */    
    public static function unserializeData($arr)
    {
        foreach ($arr as &$value) {
                try{
                    $value = unserialize($value);
                }
                catch (Exception $e){
                    $value = $value;
                }
        }
        return $arr;
    }    

    /*
     * Convert an array of errors
     * @param arr array
     * @return errors array
     */    
    public static function errors($arr)
    {
        $errors = array();
        foreach ($arr as $key => $value) {
            if(is_array($value)){
                foreach ($value as $key1 => $val) {
                    $errors[$key1] = $val;
                }
            } else {
                $errors[$key] = $value;
            }

        }
        return $errors;
    }

    /*
     * Get value in post
     * @param key string
     * @return value string or FALSE bool
     */   
    public static function getPostValue($key)
    {
        $keys = explode('.', $key);
        switch (count($keys)):
            case '1':
                return !empty($_POST["$keys[0]"]) ? $_POST["$keys[0]"] : FALSE;
            break;
            case '2':
                return !empty($_POST["$keys[0]"]["$keys[1]"]) ? $_POST["$keys[0]"]["$keys[1]"] : FALSE;
            break;
            case '3':
                return !empty($_POST["$keys[0]"]["$keys[1]"]["$keys[2]"]) ? $_POST["$keys[0]"]["$keys[1]"]["$keys[2]"] : FALSE;
            break;
            case '4':
                return !empty($_POST["$keys[0]"]["$keys[1]"]["$keys[2]"]["$keys[3]"]) ? $_POST["$keys[0]"]["$keys[1]"]["$keys[2]"]["$keys[3]"] : FALSE;
            break;
        endswitch;
    }
    /*
     * Get value in array
     * @param key string
     * @param array
     * @return value string or FALSE bool
     */   
    public static function getValue($key, $array)
    {
        $keys = explode('.', $key);
        switch (count($keys)):
            case '1':
                return !empty($array["$keys[0]"]) ? $array["$keys[0]"] : FALSE;
            break;
            case '2':
                return !empty($array["$keys[0]"]["$keys[1]"]) ? $array["$keys[0]"]["$keys[1]"] : FALSE;
            break;
            case '3':
                return !empty($array["$keys[0]"]["$keys[1]"]["$keys[2]"]) ? $array["$keys[0]"]["$keys[1]"]["$keys[2]"] : FALSE;
            break;
            case '4':
                return !empty($array["$keys[0]"]["$keys[1]"]["$keys[2]"]["$keys[3]"]) ? $array["$keys[0]"]["$keys[1]"]["$keys[2]"]["$keys[3]"] : FALSE;
            break;
        endswitch;
    }
    
    public static function academicYear($year)
    {
        $year = strlen((string)$year) == 1 ? '0' . $year : $year;
        return $year;
    }


    /*
     * Convert string from numeric
     * @param numeric integer
     * @return string string
     */   
    public static function roundString($numeric)
    {
        $string = (string)$numeric;
        if(strlen($numeric) > 4) return substr($string, strlen($numeric) - 4);
        if(strlen($string) == 1){
            $string = '000'.$string;
        }elseif(strlen($string) == 2){
            $string = '00'.$string;
        }elseif(strlen($string) == 3){
            $string = '0'.$string;    
        }
        return $string;
    }
    
    public static function getClass($level, $name, $year)
    {
        $class = $level->template_classes->where('year_id', '=', $year)->where('name', '=', $name)->find();
        return !empty($class->id) ? $class->id : FALSE;
    }
    
    
    
    public static function getRatingType($record)
    {
        if(!is_null($record->percentage_ev)){
            return 'percentage';
        }
        if(!is_null($record->letter_ev)){
            return 'letter';
        }
        if(!is_null($record->comment_ev)){
            return 'comment';
        }
    }
    
    public static function getRating($record)
    {
        if(!is_null($record->percentage_ev)){
            return $record->percentage_ev;
        }
        if(!is_null($record->letter_ev)){
            return $record->letter_ev;
        }
        if(!is_null($record->comment_ev)){
            return $record->comment_ev;
        }
    }
    
    public static function convertYear($time)
    {
        return date("z", $time) < 253 ? date("Y", $time) : date("Y", $time) + 1; //253 - 11/12 September
    }    
    
    public static function getCurrentYear()
    {
        $time = time();
        return date("z", $time) < 253 ? date("Y", $time) : date("Y", $time) + 1; //253 - 11/12 September
    }

    public static function getRatingFromRecord($record)
    {
        if(!is_null($record->percentage_ev)){
            $rating = $record->percentage_ev . '%';
        }
        if(!is_null($record->letter_ev)){
            switch ($record->letter_ev):
                case '5': 
                    $rating = 'A';
                    break;
                case '4': 
                    $rating = 'B';
                    break;
                case '3': 
                    $rating = 'C';
                    break;
                case '2': 
                    $rating = 'D';
                    break;
                case '1': 
                    $rating = 'E';
                    break;
                case '0': 
                    $rating = 'F';
                    break;
            endswitch;
        }
        if(!is_null($record->comment_ev)){
            switch ($record->comment_ev):
                case '4': 
                    $rating = 'Excellent';
                    break;
                case '3': 
                    $rating = 'Very Good';
                    break;
                case '2': 
                    $rating = 'Good';
                    break;
                case '1': 
                    $rating = 'Satisfactory';
                    break;
                case '0': 
                    $rating = 'Poor';
                    break;
            endswitch;
        }
        return $rating;
    }
    
    public static function getObjectPeriod($period)
    {
        $period_object = (object)array('name' => '', 'count' => '', 'value' => (string)$period);
        switch ($period):
            case 5: 
                $period_object->name  = 'Custom 16';
                $period_object->count = 16;
                break;
            case 4: 
                $period_object->name  = 'Custom 8';
                $period_object->count = 8;
                break;
            case 3: 
                $period_object->name  = 'Quarter';
                $period_object->count = 4;
                break;
            case 2: 
                $period_object->name  = 'Term';
                $period_object->count = 3;
                break;
            case 1: 
                $period_object->name  = 'Semester';
                $period_object->count = 2;
                break;
        endswitch;
        
        return $period_object;
    }
    
    public static function getStatusForPromotion($student_id)
    {
        $period_obj = Helper_Main::getObjectPeriod(Model::factory('setting')->get_value('academic_period'));
        $student    = ORM::factory('student')->where('student_id', '=', $student_id)->find();
        $records    = ORM::factory('record_financial')->where('student_id', '=', $student_id)->where('period', '=', $period_obj->value)->where('year_id', '=', $student->end_year)->where('paid', '=', 1)->count_all();
        return ($period_obj->count - (int)$records) == 0 ? TRUE : FALSE;
    }
}