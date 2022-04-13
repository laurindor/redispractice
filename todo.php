
Material
Temari tema 5
Publicado: 3 feb
Tema 6: Php i Redis
Tema 6: Php i Redis
Material
Temari tema 6
Publicado: 3 feb
Material
Client de Redis
Publicado: 18:17
Material
Com configurar el plugin de Redis en Xampp per a windows
Publicado: 18:44
Material
Com configurar l'extensió de Redis per a Mac i Linux
Publicado: 18:44
Material
Recursos
Publicado: 19:07

index.php
PHP

redis_chat.zip
Archivo comprimido

todo.php
PHP
<?PHP
//Variables base
$list = "Tasques";
$itemAdd = isset($_REQUEST["itemAdd"]) ? $_REQUEST["itemAdd"] : "";
$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";
//Crearem una instancia de Redis
$redis = new Redis();

//Conectarem a un servidor Redis
$redis->connect("127.0.0.1",6379);
$redis->select(4);
//realitzar funcions del crud
function create($redis,$list,$itemAdd){
    $redis->rpush($list,$itemAdd);
   // return $redis;
}
function edit($redis,$list,$id,$item){
    $redis->lset($list,$id,$item);
}
function delete($redis,$list,$id){
    $item = $redis->lget($list,$id);
    $redis->lrem($list,$item,1);
}
//menu principal
$tipus = isset($_REQUEST["t"]) ? $_REQUEST["t"] : null; 
switch($tipus){
    case "create":
        echo "<form action='?t=createok' method='post'>Indica el nom de la tasca:<br><input type='text' name='itemAdd'><br><br><input type='submit'></form>";
    break;
    case "createok":
        create($redis,$list,$itemAdd);
        echo("Item creat correctament.<br><a href='todo.php'>Tornar</a>");
    break;
    case "edit":
        $lArray = $redis->lrange($list, 0 , -1);//Carreguem el llistat
        echo "<form action='?t=editok&id=" . $id ."' method='post'>Indica el nou nom de la tasca:<br><input type='text' name='itemAdd' placeholder='".$lArray[$id]."'><br><br><input type='submit'></form>";
    break;
    case "editok":
        edit($redis,$list,$id,$itemAdd);
        echo("Item modificat correctament.<br><a href='todo.php'>Tornar</a>");
    break;
    case "delete":
        delete($redis,$list,$id);
        echo("Item borrat correctament.<br><a href='todo.php'>Tornar</a>");
    break;
    default:
        echo("Llista de tasques <a href='?t=create'>Afegir una tasca</a><br><br>");
        $lArray = $redis->lrange($list, 0 , -1);
        for($i = 0; $i < count($lArray); $i++){
            echo($i . ". " . $lArray[$i] . "<a href='?t=edit&id=" . $i . "'>Editar</a> <a href='?t=delete&id=" . $i . "'>Borrar</a><br>");
        }
}
?>