<?php
  require_once('models/ModelBoards.php');
  class BoardController extends Controller {

    public function index() {  
      $id_user = Auth::id();
      $filteredBoards = DB::table('boards')
                          ->where('id_user', $id_user)
                          ->orWhere('share', $id_user)
                          ->get();
      
      return view('boards/index', [
          'boards' => $filteredBoards,
          'title' => 'Boards List',
          'login' => Auth::check(),
          'id_user' => $id_user
      ]);
      
  }

  
  

    public function show($id) {
      $boards = DB::table('boards')->find($id);
      return view('tas/task',
        ['boards'=>$boards,
         'title'=>'Boards Detail',
         'show'=>true,'create'=>false,'edit'=>false,
		 'login'=>Auth::check()]);
    }

    public function create() {
      if (!Auth::check()) return redirect('/login');
      $id_user = Auth::id();
      $users = DB::table('users')->get(); 
      $boardData = ['name_bds' => '', 'id_user' => $id_user,'share' => ''];
      return view('boards/details', [
          'title' => 'Boards Create',
          'boards' => $boardData,
          'users' => $users, // Pasar los usuarios a la vista
          'courses' => false,
          'show' => false,
          'create' => true,
          'edit' => false,
          'login' => Auth::check()
      ]);
  }
  
  public function store($param1 = NULL) {
    if (!Auth::check()) return redirect('/login');
    $id_user = Auth::id();
    $name_bds = Input::get('name_bds');
    $share = Input::get('share'); // Obtener el ID del usuario seleccionado
    $boardData = ['name_bds' => $name_bds, 'id_user' => $id_user, 'share' => $share];
    DB::table('boards')->insert($boardData);
    return redirect('/boards');
}


  
  

    public function edit($id) {
	  if (!Auth::check()) return redirect('/login');
      $boards = DB::table('boards')->find($id);
      return view('boards/details',
        ['boards'=>$boards,
         'title'=>'Boards Edit','courses'=>false,
         'show'=>false,'create'=>false,'edit'=>true,
		 'login'=>Auth::check()]);
    }

    public function update($_,$id = NULL) {
	  if (!Auth::check()) return redirect('/login');
      $name_bds = Input::get('name_bds');
      $boards = ['name_bds'=>$name_bds];
      DB::table('boards')->update($id,$boards);
      return redirect('/boards');
    }

    public function destroy($id) {
	  if (!Auth::check()) return redirect('/login');
      DB::table('boards')->delete($id);
      return redirect('/boards');
    }

    public function search() {
      // Verificar si se ha enviado un término de búsqueda
      if (isset($_GET['search'])) {
          $searchTerm = $_GET['search'];
  
          // Realizar la búsqueda en la base de datos por nombre si el término no está vacío
          if (!empty($searchTerm)) {
              // Preparar la consulta SQL con el operador LIKE y los comodines %
              $query = "SELECT * FROM boards WHERE name_bds LIKE :searchTerm";
              $values = ['searchTerm' => '%' . $searchTerm . '%'];
  
              // Depurar la consulta SQL generada
              var_dump($query);
              var_dump($values);
  
              // Ejecutar la consulta utilizando la función select de tu framework PHPFramex
              $filteredBoards = DB::select($query, $values);
              
              // Depurar los resultados de la consulta
              var_dump($filteredBoards);
              
              // Devolver la vista con los resultados filtrados
              return view('boards.index', [
                  'boards' => $filteredBoards,
                  'title' => 'Boards List',
                  'login' => Auth::check()
              ]);
          }
      }
  
      // Si no se proporciona un término de búsqueda, redirigir a la página principal de tableros
      return redirect('/boards');
  }
  
  


  }
?>