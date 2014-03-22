<?php
class Helper_Output
{
    protected static $_css     = array();
    protected static $_js      = array();
    protected static $_errors  = array();
    protected static $_custom_js = array();

    public static function factory() 
    {
        return new Helper_Output();
    }

    /*
     * Set link for .css file
     * @param name .css file
     * @return self
     */
    public function link_css($css)
    {
        self::$_css[] = $css;
        return $this;
    }
    
    /*
     * Set link for .js file
     * @param name .js file
     * @return self
     */
    public function link_js($js)
    {
        self::$_js[] = $js;
        return $this;
    }
    
    /*
     * Render links for .css files
     * @return links .css files
     */
    public static function renderCss()
    {
        if(!empty(self::$_css)) {
            $media_array = self::$_css;
//            $min_media = Minify::factory('css')->minify($media_array);
            $min_media = $media_array;
            foreach ($min_media as $key => $value) 
            {
                $http = substr($value, 0, 4);
                if($http == 'http') {
                    echo '<link rel="stylesheet" type="text/css" href="'. $value .'" />';
                } else {
                    echo '<link rel="stylesheet" type="text/css" href="'. URL::base( ) . $value .'.css" />';
                }
            }
        }
    }
    
    /*
     * Render links for .js files
     * @return links .js files
     */
    public static function renderJS()
    {
        if(!empty(self::$_js)) {
            $media_array = self::$_js;
            $min_media = Minify::factory('js')->minify($media_array);
            foreach ($min_media as $key => $value) {
                $http = substr($value, 0, 4);
                if($http == 'http') {
                    echo '<script type="text/javascript" src="'. $value .'" /></script>';
                } else {
                    echo '<script type="text/javascript" src="'. URL::base( ) . $value .'.js" ></script>';
                }
            }
        }
    }
    
    public static function setRenderCustomJs($value)
    {
        self::$_custom_js[] = $value;
    }
    
    public static function renderCustomJs()
    {
        if(Valid::not_empty(self::$_custom_js))
        foreach (self::$_custom_js as $value) 
        {
            echo '<script type="text/javascript" src="'. URL::base( ) . $value .'.js" ></script>';
        }
    }

    public static function set_empty_space($number)
    {
        $result = '';
        for ($i = 0; $i < $number; $i++) {
            $result = $result.'&nbsp;';
        }
        return $result;
    }
}
