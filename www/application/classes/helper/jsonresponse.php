<?php 
class Helper_Jsonresponse
{
    protected static $text   = "success";
    protected static $errors =  array();
    protected static $data   =  array();

    /*
     * Set error in error array
     * @param error type string
     */
    public static function addError($error) 
    {
        self::$errors[] = $error;

    }
    
    /*
     * Set text
     * @param text type string
     */
    public static function addText($text) 
    {
        self::$text = $text;
    }
    
    /*
     * Set data in data array
     * @param data type array
     */
    public static function addData($data) 
    {
        self::$data = $data;
    }
    
    /*
     * Render json data
     * @return json array
     */
    public static function render()
    {
        header('Content-type: application/json');
        echo json_encode(array(
                        'text' 	 => self::$text,
                        'errors' => self::$errors,
                        'data'	 => self::$data
                ));
        die();
    }

    /*
     * Render json data
     * @param result string
     * @param errors array
     * @param data array
     * @return json array
     */
    public static function render_json($result, $errors = null, $data = null)
    {
        header('Content-type: application/json');
        echo json_encode(array(
            'text'   => $result,
            'errors' => $errors,
            'data'   => $data
        ));
        die;
    }
}