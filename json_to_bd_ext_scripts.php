<?
require_once 'db_config.php';
header('Content-Type: text/html; charset=utf-8');
// var_dump($charset);
    // var_dump($_REQUEST); 
    // var_dump($_POST); 

if ($_POST) {



    // $arrayJson = json_decode($audit_JSON, true);
    // $arrayJson = json_decode($_POST, true);
    $arrayJson = $_POST;


    function quote($str)
    {
        return sprintf("'%s'", $str);
    }
    function pdoSet($items, $arKeys)
    {
        $items = $items; //весь массив аудита
        $arKeys = $arKeys; //ключи полученного массива. 1 ключ ssl изменен на ssl_isset. Данные поля соответствуют полям в БД
        $arField = array();

        foreach ($items as $key => $field) {

            if (is_array($field)) {
                $field = implode('; ', $field);
            }
            $arField[] = $field; //переводим к общему массиву, в котором будут только строки.
        }

        // $sql = "INSERT INTO audit (" . implode(', ', $arKeys) . ") VALUES ('" . implode("', '", $arField) . ")"; //строка полей
        $sql = "UPDATE audit (" . implode(', ', $arKeys) . ") VALUES (" . implode(", ", array_map('quote', $arField)) . ")"; //строка полей
    
        return $sql;
    }

    $indexLastRow = $arrayJson["indexitem"];
    unset($arrayJson["indexitem"]);//удаляем элемент с ID последней записи
    foreach (array_keys($arrayJson) as $keys) {
        if ($keys == 'ssl') {
            $keys = 'ssl_isset'; //нельзя было сохранить название поля SSL -типа зарезервированное поле
        }
        $arKeys[] = $keys;
    }



    // echo $_GET['array_audit'];


    try {
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $sql = pdoSet($arrayJson, $arKeys);
        // var_dump($sql);
        // $stm = $pdo->prepare($sql);
       
        $affectedRowsNumber = $pdo->exec($sql);
        if ($pdo->lastInsertId()){
            $id = $pdo->lastInsertId();
        } else {
            $id = 'не найдено';
        }
        //  echo ' <script>array_audit.indexitem = "' . $id . '"</script> ';
         echo  $id;
        // echo "В таблицу audit добавлено строк: $affectedRowsNumber";
        
    } catch (PDOException $e) {
        die('Проблемы: ' . $e->getMessage());
    }
}
