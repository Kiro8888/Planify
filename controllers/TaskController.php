<?php
  // file: controllers/TaskController.php
  require_once('models/ModelTasks.php');

  class TaskController extends Controller {

    public function index() {  
      $board_id = $_GET['board_id']; 
      $tasks = DB::table('tasks')->where('board_id', $board_id)->get();
      $board = DB::table('boards')->find($board_id);
      return view('task/index', [
          'tasks' => $tasks,
          'board' => $board,
          'title' => 'Tasks List',
          'login' => Auth::check()
      ]);
    }

    public function create() {
      $board_id = $_GET['board_id']; 
      $board = DB::table('boards')->find($board_id);
      if (!Auth::check()) return redirect('/login');
      $tasks = ['author'=>'','state'=>'',
                 'date_start'=>'','date_end'=>''
                 ,'note'=>'','name'=>''
                 ,'board_id'=>$board_id];
      return view('task/create', [
          'title' => 'Crear Tareas',
          'tasks' => $tasks,
          'courses' => false,
          'show' => false,
          'create' => true,
          'edit' => false,
          'login' => Auth::check()
      ]);
    }
    public function store($param1 = null) {
      if (!Auth::check()) {
          return redirect('/login');
      }
      $author = Input::get('author');
      $state = Input::get('state');
      $date_start = Input::get('date_start');
      $date_end = Input::get('date_end');
      $note = Input::get('note');
      $name = Input::get('name');
      $board_id = Input::get('board_id'); 
      $taskData = [
          'author' => $author,
          'state' => $state,
          'date_start' => $date_start,
          'date_end' => $date_end,
          'note' => $note,
          'name' => $name,
          'board_id' => $board_id
      ];
      DB::table('tasks')->insert($taskData);
      return redirect('/tasks?board_id=' . $board_id); 
  }
  public function destroy($id) {
    $board_id = $_GET['board_id'];
    $board = DB::table('boards')->find($board_id);
    if (!Auth::check()) return redirect('/login');
    DB::table('tasks')->delete($id);
    $previousUrl = $_SERVER['HTTP_REFERER'];
    return redirect($previousUrl);
}

    public function show($id) {
      $tasks = DB::table('tasks')->find($id);
      return view('task/create',
        ['tasks'=>$tasks,
         'title'=>'Tasks Detail',
         'show'=>true,'create'=>false,'edit'=>false,
		 'login'=>Auth::check()]);
    }
    public function edit($id) {
      if (!Auth::check()) return redirect('/login');
        $task = DB::table('tasks')->find($id);
        return view('task/edit',
          ['task'=>$task,
           'title'=>'Task Edit','courses'=>false,
           'show'=>false,'create'=>false,'edit'=>true,
       'login'=>Auth::check()]);
      }
  
      public function update($_,$id  = null) {
      if (!Auth::check()) return redirect('/login');
      $author = Input::get('author');
      $state = Input::get('state');
      $date_start = Input::get('date_start');
      $date_end = Input::get('date_end');
      $note = Input::get('note');
      $name = Input::get('name');
      $board_id =  Input::get('board_id');
        $task = ['author'=>$author,'state'=>$state,
                 'date_start'=>$date_start,'date_end'=>$date_end,
                 'note'=>$note,'name'=>$name,'board_id'=>$board_id     
                ];
        DB::table('tasks')->update($id,$task);
        return redirect('/tasks?board_id=' . $board_id); 
      }

  }
?>
