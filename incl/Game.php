<?php

namespace Igor\Game2019;

class Game
{
    
    /**
         * Class constructor.
         *
         */
    public function __construct()
    {
        session_start();
    }
    
    /**
         * Main function of program.  Deal with json or output template.
         *
         * @return void
         */
    public function doOutput() {
    
        if ( !empty($_POST['data']) ) {
            $obj = json_decode($_POST["data"]);
            $respObj = array();
            switch ( $obj->fn ) {
                case 'start_game' : 
                    $respObj = $this->doStart();
                break;
                case 'make_quess' : 
                    if ( !empty($obj->number) ) {
                        $respObj = $this->doMakeQuess( (int)$obj->number );
                    }
                    
                break;
            }
            echo json_encode($respObj);
            exit();
        }
        
        $html =  $this->readTemplate("main.htm");

        include_once( "lang/en.php");
        foreach ( $lang as $key => $value ) {
            $html  = str_replace("%".$key."%", $value, $html );
        }

        echo $html;
    }
    
    /**
         * Reads template file.
         *
         * @param string $fileName Name of template file.
         * @return string
         */
    public function readTemplate($fileName) {
        $myfile = fopen("tpl" . DS . $fileName, "r") or die("Unable to open file!");
        $html =  fread($myfile,filesize("tpl" . DS . $fileName));
        
        fclose($myfile);
        
        return $html;
    }
    
    /**
         * Start the game. Save random number to session.
         *
         * @return array
         */
    private function doStart() {
        session_unset();
        $_SESSION['the_number'] = rand(1, 1000);
        return array('status' => 'ok');
    }
    
    /**
         * Compare user number with number in session
         *
         * @param int $theNumber
         * @return array
         */
    private function doMakeQuess($theNumber) {
        // !! TODO: check session variables. Retun error if problem
        
        $answer = 0; 
        if ( $theNumber !== $_SESSION['the_number'] ) {
            $answer = $theNumber > $_SESSION['the_number'] ? 1 : -1;
        }
         return array('status' => 'ok', 'answer' => $answer );
    }
    
}