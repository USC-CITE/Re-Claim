<?php 
/**
    * Layer: Controller
    * Purpose: Handle HTTP requests and responses
    * Rules: No direct DB queries or HTML markup
*/

namespace App\Controllers;

use App\Helpers\Mailer;
use PDOException;
use Exception;

class ContactController{
    public static function showContactPage(){
        require __DIR__ . "/../Views/mainpages/contact.php";
    }
}
?>