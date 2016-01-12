<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    11.01.16  -  15:51
 * @version 1.0
 */

class Controller {

    /**
     * @var Object  The F3 object
     */
    protected $f3;

    /**
     * @var Object  The database object
     */
    protected $db;

    function __construct() {

        // setting the f3 instance and make it useable
        $f3 = Base::instance();
        $this->f3 = $f3;

        // setting the db connection and make it useable
        $db = new DB\SQL(
            $f3->get('devdb'),
            $f3->get('devdbusername'),
            $f3->get('devdbpassword'),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
        );
        $this->db = $db;

    }

    // function is called before every single routing!
    function beforeroute() {

    }

    // function is called after every single routing!
    function afterroute() {

    }

}