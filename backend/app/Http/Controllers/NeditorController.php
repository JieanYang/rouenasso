<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NeditorController extends Controller
{
    public function main() {
        include("Neditor/controller.php");
    }
}
