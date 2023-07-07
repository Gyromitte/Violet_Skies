<?php
    //Creando los datosssss
    $Username = $_POST['usu'];
    $Password = $_POST['pass'];
    
    //Conectando con el base de datos(cambiara despues)
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_HOST','localhost');
    define('DB_NAME','HotelDB');

    $con = new mysqli(DB_HOST,DB_USER,DB_NAME,DB_PASSWORD);

    if($con->connect_error){
        die('Error de conexion:'. $con->connect_error);
    }
    else{
        //Sacar del base de datos un query
		$Consulta = "select * from Usuarios where User = '".$Username."' and Contrasena = '".$Password."'";
		$Resultado = $con->query($Consulta);
		$thread = $con->thread_id;
		$con->kill($thread);
		$con->close();
        //Agarrar el numero de fila donde esta el usuario
		$NumResult = $Resultado->num_rows;
		if($NumResult > 0){
			while($Renglon = mysqli_fetch_array($Resultado)){
				session_start();
                //Entrar en su session
				$_SESSION['User'] = $Renglon['User'];
				$_SESSION['Contrasena'] = $Renglon['Contrasena'];
				header("location:index.html");
			}
		}
		else{ 
            echo"Tu nombre o contrasena esta equivocado";
			header("location:events.html");
		}
		
	}


?>