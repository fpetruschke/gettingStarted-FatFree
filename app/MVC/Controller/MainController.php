<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    11.01.16  -  15:51
 * @version 1.0
 */

class MainController extends Controller {

    function render($f3) {
        // setting a new global variable
        $f3->set('name', '"Your name could be here"');
        // instantiating new template object
        $template = new Template();
        echo $template->render('layout.html');
    }

    function renderAbout($f3) {
        // initialisation and definition of the path variable for the README
        $filePath = 'README.md';
        // read the file content
        $fileContent = $f3->read($filePath); // read file contents
        // render the content as a Mardown instance
        echo \Markdown::instance()->convert($fileContent);
    }

}