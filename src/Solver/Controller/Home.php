<?php

namespace Solver\Controller;

use Solver\Controller;

class Home extends Controller {

    public function view( $request ) {

        $books = \DB::get('select * from books');
        $this->view->assign('books', $books);

        include  $this->view->getPath() . '/home/view.html';

    }

    public function import_xml( $request ) {

        include  $this->view->getPath() . '/home/import_xml.html';

        try {
            if ( isset($_FILES) && !empty($_FILES) ) {

                $xml=simplexml_load_file($_FILES['file_upload']['name']) or die("Error: Cannot create object");
            
                foreach( $xml->children() as $item ) {
            
                    $book_id = \DB::get("select book_id from books order by book_id DESC limit 1");
                    $book_id = pg_fetch_all($book_id)[0]["book_id"];
                    $book_id = intval($book_id) + 1;
            
            
                    $checkForExistRecord = \DB::get("select * from books where book_author = '" . $item->author . "' and book_name = '" . $item->name ."'");
                    if ( isset($checkForExistRecord) && !is_array(pg_fetch_all($checkForExistRecord)) ) {
                        $sql = "INSERT INTO books (book_id, book_author, book_name) VALUES ('$book_id', '$item->author', '$item->name')";
                        \DB::get($sql);
                    }             
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }     
    }

    public function search( $request ) {

        if ( $request->isPost() ) {
            $books = \DB::get("select * from books where book_author LIKE '%" . $_POST['search'] . "%' OR book_name LIKE '%" . $_POST['search'] . "%'");
            $this->view->assign('books', $books);

            include  $this->view->getPath() . '/home/view.html';
        }

    }

}