<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TodoController extends Controller
{
    //index
    public function index()
    {
        $path = storage_path().'/framework/views/my_todo.json';
		$content = json_decode(file_get_contents($path), true);

		return view('index', ['type' => $content]);
    }

    //add todo item
    public function addItem(Request $request)
    {
        $name = $request->input('name');
		$date = date('Y/m/d');

		$path = storage_path().'/framework/views/my_todo.json';
		$content = json_decode(file_get_contents($path), true);

		$last_item = end($content);
		$last_item_id = (isset($last_item['id'])) ? $last_item['id'] : 0;

		$content[] = array("id" => ++$last_item_id, "title" => $name, "date" => $date);

		$new_content = json_encode($content, true);
		file_put_contents($path, $new_content);
		
        return redirect('/');
    }

    //delete todo item
    public function deleteItem($id = null)
    {
        $path = storage_path().'/framework/views/my_todo.json';
		$content = json_decode(file_get_contents($path), true);

		foreach ($content as $key => $value) {
			if ($value['id'] == $id) {
				unset($content[$key]);
			}
		}

		$new_content = json_encode($content, true);
		file_put_contents($path, $new_content);

		return redirect('/');
    }
}
