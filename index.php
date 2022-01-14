<?php 

session_start();

require 'flight/Flight.php';

//conexion a la base de datos por pdo
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=flight_php','root',''));

//llave y metodo de encriptacion
define("key","flight-php");
define("cod","aes-128-ecb");


Flight::route('GET /register', function(){
    Flight::render('proyectos/register');
});

Flight::route('POST /register', function(){

    $user = Flight::request()->data->user;
    $name = Flight::request()->data->name;
    $email = Flight::request()->data->email;
    $password = openssl_encrypt(Flight::request()->data->password,cod,key);
    $txtNombre= Flight::request()->data->image;
    $txtImagen=Flight::request()->files['image'];
    $fecha=new DateTime();
    
    $nombreArchivo=($txtImagen['name']!='')?$fecha->getTimestamp()."_".$txtImagen['name']:"";
    $tmpImagen=$txtImagen['tmp_name'];

    //verificamos si el usuario o contraseña ya existen
    $sql="SELECT * FROM users WHERE user_user = ? OR email_user = ?;";
    $ejecutarSentencia= Flight::db()->prepare($sql);
    $ejecutarSentencia->bindParam(1,$user);
    $ejecutarSentencia->bindParam(2,$email);
    $ejecutarSentencia->execute();

    if($ejecutarSentencia -> fetch(PDO::FETCH_ASSOC)){
        $msg = '<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>El Usuario O El Correo Ya Existen</strong>
                    </div>';

        Flight::render('proyectos/register',array('msg'=>$msg));
    }else{
        $sql="INSERT INTO users (user_user,nom_user,email_user,pssw_user,img_user) VALUES (?,?,?,?,?);";
        $ejecutarSentencia= Flight::db()->prepare($sql);
        $ejecutarSentencia->bindParam(1,$user);
        $ejecutarSentencia->bindParam(2,$name);
        $ejecutarSentencia->bindParam(3,$email);
        $ejecutarSentencia->bindParam(4,$password);
        $ejecutarSentencia->bindParam(5,$nombreArchivo);
        $ejecutarSentencia->execute();

        if($ejecutarSentencia){
            if($tmpImagen!=""){
                move_uploaded_file($tmpImagen,"img-admin/".$nombreArchivo);
                Flight::redirect('/login');
            }
        }else{
            $msg = '<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>No Se Pudo Registrar El Usuario</strong>
                    </div>';

            Flight::render('proyectos/register',array('msg'=>$msg));
        }
    }
});



Flight::route('GET /login', function(){
    if(!isset($_SESSION['user'])){
        Flight::render('proyectos/login');
    }else{
        Flight::redirect('/');
    }
});

Flight::route('POST /login', function(){

    $user=Flight::request()->data->user;
    $password=openssl_encrypt(Flight::request()->data->password,cod,key);


    $sql="select cod_user, user_user, nom_user, img_user, email_user from users where user_user = ? and pssw_user = ?;";
    $ejecutarSentencia= Flight::db()->prepare($sql); 
    $ejecutarSentencia->bindParam(1,$user);
    $ejecutarSentencia->bindParam(2,$password);
    $ejecutarSentencia->execute();

    $datos = $ejecutarSentencia -> fetch(PDO::FETCH_ASSOC);
    //$numeroRegistros = $ejecutarSentencia -> rowCount();
                
    if($datos){
                    
        //se creala secion de usuraio
        $_SESSION['user'] = $datos;
        Flight::redirect('/');

    }else{

        $msg = '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Usuario o Contraseña Incorrectos</strong>
                </div>';
        
        Flight::render('proyectos/login',array('msg'=>$msg));
    }

});

Flight::route('/', function(){

    if(isset($_SESSION['user'])){

        $sql="SELECT * FROM proyectos";
        $ejecutarSentencia= Flight::db()->prepare($sql);
        $ejecutarSentencia->execute();
        $datosProyectos=$ejecutarSentencia->fetchAll();
        Flight::render('cabecera');
        Flight::render('proyectos/listar',array('proyectos'=>$datosProyectos));
        Flight::render('pie');
    }else{
        Flight::redirect('/login');
    }

});

Flight::route('GET /crear', function(){
    if(isset($_SESSION['user'])){
        Flight::render('cabecera');
        Flight::render('proyectos/crear');
        Flight::render('pie');
    }else{
        Flight::redirect('/login');
    }
});

Flight::route('POST /crear', function(){
    if(isset($_SESSION['user'])){
        $txtNombre= Flight::request()->data->txtNombre;
        $txtquantity= Flight::request()->data->txtquantity;
        $txtprice= Flight::request()->data->txtprice;
        $txtImagen=Flight::request()->files['txtImagen'];
        $fecha=new DateTime();
        $nombreArchivo=($txtImagen['name']!='')?$fecha->getTimestamp()."_".$txtImagen['name']:"";
        $tmpImagen=$txtImagen['tmp_name'];

        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"img/".$nombreArchivo);
        }

        $archivo=$nombreArchivo;
        $sql="INSERT INTO proyectos (nombre,quantity,price,imagen) VALUES (?,?,?,?);";
        $ejecutarSentencia= Flight::db()->prepare($sql);
        $ejecutarSentencia->bindParam(1,$txtNombre);
        $ejecutarSentencia->bindParam(2,$txtquantity);
        $ejecutarSentencia->bindParam(3,$txtprice);
        $ejecutarSentencia->bindParam(4,$archivo);
        $ejecutarSentencia->execute();
        Flight::redirect('/');
    }else{
        Flight::redirect('/login');
    }
});

Flight::route('GET /editar', function(){
    if(isset($_SESSION['user'])){
        $txtID=Flight::request()->query['txtID'];
        $sql="SELECT * FROM proyectos WHERE id=?";
        $ejecutarSentencia= Flight::db()->prepare($sql);
        $ejecutarSentencia->bindParam(1,$txtID);
        $ejecutarSentencia->execute();
        $datos=$ejecutarSentencia->fetch(PDO::FETCH_ASSOC);
        Flight::render('cabecera');
        Flight::render('proyectos/editar',array('proyecto'=>$datos));
        Flight::render('pie');
    }else{
        Flight::redirect('/login');
    }
});

Flight::route('POST /editar', function(){
    
    $txtID=Flight::request()->data->txtID;
    $txtquantity= Flight::request()->data->txtquantity;
    $txtprice= Flight::request()->data->txtprice;
    $txtNombre=Flight::request()->data->txtNombre;
    $txtImagen=Flight::request()->files['txtImagen'];
    if( isset($txtImagen) ){
        $fecha=new DateTime();
        $nombreArchivo=($txtImagen['name']!='')?$fecha->getTimestamp()."_".$txtImagen['name']:"";
        $tmpImagen=$txtImagen['tmp_name'];
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"img/".$nombreArchivo);
            $sql="SELECT * FROM proyectos WHERE id=?";
            $ejecutarSentencia= Flight::db()->prepare($sql);
            $ejecutarSentencia->bindParam(1,$txtID);
            $ejecutarSentencia->execute();
            $proyecto=$ejecutarSentencia->fetch(PDO::FETCH_ASSOC);
            if( isset($proyecto['imagen']) ){
                if( file_exists( "img/".$proyecto['imagen'] ) ){
                    unlink("img/".$proyecto['imagen']);
                }

            }
            $sql="UPDATE proyectos SET imagen=? WHERE id=?";
            $ejecutarSentencia= Flight::db()->prepare($sql);
            $ejecutarSentencia->bindParam(1,$nombreArchivo);
            $ejecutarSentencia->bindParam(2,$txtID);
            $ejecutarSentencia->execute();
        }

    }

    $sql="UPDATE proyectos SET nombre=?, quantity=?, price=? WHERE id=?";
    $ejecutarSentencia= Flight::db()->prepare($sql);
    $ejecutarSentencia->bindParam(1,$txtNombre);
    $ejecutarSentencia->bindParam(2,$txtquantity);
    $ejecutarSentencia->bindParam(3,$txtprice);
    $ejecutarSentencia->bindParam(4,$txtID);
    $ejecutarSentencia->execute();
    Flight::redirect('/');
});

Flight::route('POST /borrar', function(){
    $txtID=Flight::request()->data->txtID;
    $sql="SELECT * FROM proyectos WHERE id=?";
    $ejecutarSentencia= Flight::db()->prepare($sql);
    $ejecutarSentencia->bindParam(1,$txtID);
    $ejecutarSentencia->execute();
    $proyecto=$ejecutarSentencia->fetch(PDO::FETCH_ASSOC);

    if( isset($proyecto['imagen']) ){
        if( file_exists( "img/".$proyecto['imagen'] ) ){
            unlink("img/".$proyecto['imagen']);
        }

    }
    $sql="DELETE FROM proyectos WHERE id=?";
    $ejecutarSentencia= Flight::db()->prepare($sql);
    $ejecutarSentencia->bindParam(1,$txtID);
    $ejecutarSentencia->execute();
    Flight::redirect('/');
});

Flight::route('GET /exit', function(){
    unset($_SESSION['user']);
    Flight::redirect('/login');
});
//error 404
Flight::map('notFound', function(){
    if(isset($_SESSION['user'])){
        Flight::render('cabecera');
        Flight::render('proyectos/404');
        Flight::render('pie');
    }else{
        Flight::redirect('/login');
    }
});

Flight::start();
?>