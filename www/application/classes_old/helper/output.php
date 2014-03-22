<?php
class Helper_Output
{
    protected static $_css     = array();
    protected static $_js      = array();
    protected static $_errors  = array();

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
            foreach (self::$_css as $key => $value) {
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
            foreach (self::$_js as $key => $value) {
                $http = substr($value, 0, 4);
                if($http == 'http') {
                    echo '<script type="text/javascript" src="'. $value .'" /></script>';
                } else {
                    echo '<script type="text/javascript" src="'. URL::base( ) . $value .'.js" ></script>';
                }
            }
        }
    }
}
