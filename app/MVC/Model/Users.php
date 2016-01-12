<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    12.01.16  -  09:30
 * @version 1.0
 */

class Users extends DB\SQL\Mapper {

    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'gettingStarted.users');
    }

    public function getByName($name) {
        $this->load(array('username=?', $name));
    }

}