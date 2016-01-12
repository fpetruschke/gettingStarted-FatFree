<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    11.01.16  -  15:51
 * @version 1.0
 */

class MainController extends Controller {

    function render() {
        // setting a new global variable
        $this->f3->set('name', '"Your name could be here"');

        // getting messages from the databse
        $messages = new Messages($this->db);
        // counting up the array keys will return the other message texts
        $msg = $messages->showAllJoined();

        // setting the global variable for using the values in the templates
        $this->f3->set('msg', $msg);

        // instantiating new template object
        $template = new Template();
        echo $template->render('layout.html');
    }

    function renderAbout() {
        // initialisation and definition of the path variable for the README
        $filePath = 'README.md';
        // read the file content
        $fileContent = $this->f3->read($filePath); // read file contents
        // render the content as a Mardown instance
        echo \Markdown::instance()->convert($fileContent);
    }

}