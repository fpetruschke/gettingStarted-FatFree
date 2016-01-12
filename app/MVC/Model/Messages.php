<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    12.01.16  -  09:30
 * @version 1.0
 */

class Messages extends DB\SQL\Mapper {

    public function __construct(DB\SQL $db) {
        parent::__construct($db, 'gettingStarted.messages');
    }

    public function showAll() {
        $this->load();
        return $this->query;
    }

    public function showAllJoined() {
        $return = $this->db->exec(
            'SELECT m.id, t.shorttitle, t.title, m.message FROM gettingStarted.messages m
              JOIN gettingStarted.message_types t ON t.id
              WHERE t.id = m.type'
        );
        return $return;
    }

    /**
     * Get's a message by its ID
     * @param $id
     * @return array
     */
    public function getById($id) {
        $this->load(array('id=?', $id));
        return $this->query;
    }

    /**
     *  Stores POST values into database
     */
    public function add() {
        $this->copyFrom('POST');
        $this->save();
    }

    /**
     * Updates a db entry at the specific id with the sent POST data
     * @param $id
     */
    public function edit($id) {
        $this->load(array('id=?', $id));
        $this->copyFrom('POST');
        $this->update();
    }

    /**
     * Drops the data with given id from database
     * @param $id
     */
    public function delete($id) {
        $this->load(array('id=?', $id));
        $this->erase();
    }

}