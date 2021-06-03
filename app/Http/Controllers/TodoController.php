<?php

namespace App\Http\Controllers;

use App\Models\todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function Add(Request $request)
    {
        $data = $request -> all();
        $todo = new todo;
        $todo->date = $data['date'];
        $todo->todo = $data['todo'];
        $todo->status = 0;
        $todo->save();

        return $this -> Show();
    }

    public function Show() {
        $query = DB::table('todos')->latest()->get()->all();
        $data = '';
        foreach($query as $item) {
            $data .= '
            <div class="col-sm-3">
                <div class="card mb-2">
                    <div class="card-header text-center">'.$item->date.'</div>
                    <div class="card-body">'.$item->todo.'</div>';
                    if ($item->status == 0) {
                        $data .= '<div class="card-footer text-center"><button onclick="status('.$item->id.', '.$item->status.')" class="btn completed text-center customBtn">Completed</button>
                                <button onclick="deleteData('.$item->id.')" class="btn delete text-center btn-danger"><i class="fas fa-trash-alt"></i></button></div>';

                    }
                    else {
                        $data .= '<div class="card-footer text-center"><button onclick="status('.$item->id.', '.$item->status.')" class="btn notcompleted text-center btn-primary">Not Completed</button>
                                <button onclick="deleteData('.$item->id.')" class="btn delete text-center btn-danger"><i class="fas fa-trash-alt"></i></button></div>';
                    }
                $data .= '</div>
            </div>
            ';
        }
        echo $data;
    }
    
    public function ChangeStatus(Request $request)
    {
        $data = $request -> all();
        $id = $data['id'];
        $status = $data['status'];
        
        if ($status == 0) {
            $query = todo::where('id', $id)->update(['status' => 1]);
            return $this -> Show();
        }
        elseif ($status == 1) {
            $query = todo::where('id', $id)->update(['status' => 0]);
            return $this -> Show();
        }
        else {
            echo "Error";
        }

    }

    public function Delete(Request $request) {
        $data = $request -> all();
        $id = $data['id'];
        $query = todo::where('id', $id) -> delete();
        return $this -> Show();
    }

    public function DeleteCompleted(Request $request) {
        $data = $request -> all();
        $id = $data['id'];
        $query = todo::where('id', $id) -> delete();
        return $this -> ShowCompleted();
    }

    public function Completed() {
        return view('completed');

    }

    public function ShowCompleted() {
        $query = DB::table('todos')->where('status', 1)->latest()->get()->all();
        $data = '';
        foreach($query as $item) {
            $data .= '
            <div class="col-sm-3">
                <div class="card mb-2">
                    <div class="card-header text-center">'.$item->date.'</div>
                    <div class="card-body">'.$item->todo.'</div>
                    <div class="card-footer">
                        <button onclick="deleteData('.$item->id.')" class="btn btn-block delete text-center btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            </div>
            ';
        }
        echo $data;
    }
    
}
