<?php
    require_once("../config/conexion.php");
    require_once("../Models/Usuario.php");
    $usuario = new Usuario();

    require_once("../Models/Ticket.php");
    $ticket = new Ticket();
   
    // Switch para manejar diferentes operaciones según el valor de $_GET["op"]
    switch($_GET["op"]){
        // Caso para insertar un nuevo ticket
        case "insert":
            $ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["tick_titulo"],$_POST["ticket_descripcion"]);
        break;
        // Caso para actualizar el estado de un ticket a cerrado
        case "update_est_tick":
            $ticket->update_est_tick($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrado($_POST["tick_id"],$_POST["usu_id"]);
        break;
        // Caso para asignar un ticket a un usuario
        case "update_asig_tick":
            $ticket->update_asig_tick($_POST["tick_id"],$_POST["usu_asig"]);
            
        break;
        // Caso para listar los tickets por usuario
        case "listar_x_usu":
            $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data=array();
            foreach($datos as $row){
                $sub_array= array();
                $sub_array[]= $row["tick_id"];
                $sub_array[]= $row["cat_nom"];
                $sub_array[]= $row["tick_titulo"];
                if($row["tick_estado"]=="Abierto"){
                    $sub_array[]='<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[]='<span class="label label-pill label-danger">Cerrado</span>';
                }
                $sub_array[]= date("d/m/Y H:i:s",strtotime($row["fech_crea"]));
                
                if($row["fech_asig"]==null){
                    $sub_array[]='<span class="label label-pill label-default">sin asignar</span>';
                }else{

                    $sub_array[]= date("d/m/Y H:i:s",strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[]='<span class="label label-pill label-warning">sin asignar</span>';
                }else{

                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[]='<span class="label label-pill label-success">'.$row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[]='<button type="button" onClick="ver('.$row["tick_id"].');" id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[]=$sub_array;
            }
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
        // Caso para listar todos los tickets
        case "listar_ticket":
            $datos=$ticket->listar_ticket();
            $data=array();
            foreach($datos as $row){
                $sub_array= array();
                $sub_array[]= $row["tick_id"];
                $sub_array[]= $row["cat_nom"];
                $sub_array[]= $row["tick_titulo"];
                if($row["tick_estado"]=="Abierto"){
                    $sub_array[]='<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[]='<span class="label label-pill label-danger">Cerrado</span>';
                }
                $sub_array[]= date("d/m/Y H:i:s",strtotime($row["fech_crea"]));
                if($row["fech_asig"]==null){
                    $sub_array[]='<span class="label label-pill label-default">sin asignar</span>';
                }else{

                    $sub_array[]= date("d/m/Y H:i:s",strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[]='<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">sin asignar</span></a>';
                }else{

                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[]='<span class="label label-pill label-success">'.$row1["usu_nom"].'  '.$row1["usu_ape"].' </span>';
                    }
                }

                $sub_array[]='<button type="button" onClick="ver('.$row["tick_id"].');" id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[]=$sub_array;
            }
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
        
        case "listardetalle":
            $datos=$ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
            ?>
                <?php
                    foreach($datos as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y ",strtotime($row["fech_crea"])); ?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../Docs/<?php echo $row["rol_id"] ?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"> <?php echo $row['usu_nom'].' '.$row['usu_ape']; ?> </div>
                                        <div class="activity-line-item-user-status">
                                            <?php
                                                if($row['rol_id']==1){
                                                     echo 'Usuario';
                                                }else{
                                                    echo 'Analista de soporte';
                                                }
                                            ;
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time">
                                            <?php echo date("H:i:s ",strtotime($row["fech_crea"])); ?> 
                                        </div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["tickd_descripcion"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
        break;
        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["ticket_descripcion"] = $row["ticket_descripcion"];
    
                    if($row["tick_estado"]=="Abierto"){
                        $output["tick_estado"]='<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_estado"]='<span class="label label-pill label-danger">Cerrado</span>';
                    }
                    $output["tick_estado_txt"] = $row["tick_estado"];
                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                }
                echo json_encode($output);
            }   
        break;

        case "insertdetalle":
            $ticket->insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descripcion"]);
        break;

        case "TotalT";
            $datos=$ticket->get_total_ticket();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["Total"] = $row["Total"];
                }
                echo json_encode($output);
            }   
        break;

        case "TotalTC";
            $datos=$ticket->get_total_ticketC();    
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["Total"] = $row["Total"];
                }
                echo json_encode($output);
            }   
        break;

        case "TotalTA";
            $datos=$ticket->get_total_ticketA();    
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["Total"] = $row["Total"];
                }
                echo json_encode($output);
            }   
        break;

        case "grafico";
        $datos=$ticket->get_ticket_grafico();    
            echo json_encode($datos);
        
         break;

    }

?>