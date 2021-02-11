<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ckeditor
{

    protected $CI;
    public $data = array();

    function loadCk($th = TRUE, $id)
    {
        $CI = &get_instance();
        $CI->load->helper('ckeditor');
        if ($th == TRUE) {
            //Ckeditor's configuration
            return $CI->data['ckeditor'] = array(
                //ID of the textarea that will be replaced
                'id' => $id,
                'path' => 'assets/ckeditor',
                //Optionnal values
                'config' => array(
                    'toolbar' => "Full", //Using the Full toolbar
                    'width' => "100%", //Setting a custom width
                    'height' => '100px', //Setting a custom height
                     

                ),
                //Replacing styles from the "Styles tool"
                'styles' => array(
                    //Creating a new style named "style 1"
                    'style 1' => array(
                        'name' => 'Blue Title',
                        'element' => 'h2',
                        'styles' => array(
                            'color' => 'Blue',
                            'font-weight' => 'bold'
                        )
                    ),
                    //Creating a new style named "style 2"
                    'style 2' => array(
                        'name' => 'Red Title',
                        'element' => 'h2',
                        'styles' => array(
                            'color' => 'Red',
                            'font-weight' => 'bold',
                            'text-decoration' => 'underline'
                        )
                    )
                )
            );
        } else {


            return $CI->data['ckeditor_2'] = array(
                //ID of the textarea that will be replaced
                'id' => $id,
                'path' => 'assets/ckeditor',
                //Optionnal values
                'config' => array(
                    'width' => "550px", //Setting a custom width
                    'height' => '100px', //Setting a custom height
                    'toolbar' => array( //Setting a custom toolbar
                        array('Bold', 'Italic'),
                        array('Underline', 'Strike', 'FontSize'),
                        array('Smiley'),
                        '/'
                    )
                ),
                //Replacing styles from the "Styles tool"
                'styles' => array(
                    //Creating a new style named "style 1"
                    'style 3' => array(
                        'name' => 'Green Title',
                        'element' => 'h3',
                        'styles' => array(
                            'color' => 'Green',
                            'font-weight' => 'bold'
                        )
                    )
                )
            );
        }
    }
}
