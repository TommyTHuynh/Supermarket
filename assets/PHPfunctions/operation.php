<?php

if ( isset($_POST['operation']) && $_POST['operation'] == 'insertion' ) {

    $table = !empty($_POST['table']) ? $_POST['table'] : '';
	
    switch ( $table ) {
        case 'store':

            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            unset($post['operation']);
            unset($post['table']);

            $errors = array();
            foreach ( $post as $key => $value ) {
                if ( !strlen(trim($value)) ) {
                    $errors[$key] = ucwords(str_replace('_',' ', $key)) . ' is required.';
                }
            }
            $validateStoreId = isUniqueValue( $table, 'StoreID', $post['StoreID'] );
            if ( ! $validateStoreId ) {
                $errors['StoreID'] = 'There is already a Store available with this ID';
            }

            if ( empty($errors) ) {
                insertData($table, $post);
            } else {
                $oldData = $post;
            }

            break;
        case 'supplier':

            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            unset($post['operation']);
            unset($post['table']);

            $errors = array();
            foreach ( $post as $key => $value ) {
                if ( !strlen(trim($value)) ) {
                    $errors[$key] = ucwords(str_replace('_',' ', $key)) . ' is required.';
                }
            }
            $validateStoreId = isUniqueValue( $table, 'CompanyID', $post['CompanyID'] );
            if ( ! $validateStoreId ) {
                $errors['CompanyID'] = 'There is already a Supplier available with this CompanyID';
            }

            if ( empty($errors) ) {
                insertData($table, $post);
            } else {
                $oldData = $post;
            }

            break;
        case 'product':

            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            unset($post['operation']);
            unset($post['table']);

            $errors = array();
            foreach ( $post as $key => $value ) {
                if ( !strlen(trim($value)) ) {
                    $errors[$key] = ucwords(str_replace('_',' ', $key)) . ' is required.';
                }
            }
            $validateStoreId = isUniqueValue( $table, 'BarCode', $post['BarCode'] );
            if ( ! $validateStoreId ) {
                $errors['BarCode'] = 'There is already a Product available with this BarCode';
            }

            if ( empty($errors) ) {
                insertData($table, $post);
            } else {
                $oldData = $post;
            }

            break;
        case 'employee':

            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            unset($post['operation']);
            unset($post['table']);

            $errors = array();
            foreach ( $post as $key => $value ) {
                if ( !strlen(trim($value)) ) {
                    $errors[$key] = ucwords(str_replace('_',' ', $key)) . ' is required.';
                }
            }
            $validateStoreId = isUniqueValue( $table, 'EName', $post['EName'] );
            if ( ! $validateStoreId ) {
                $errors['EName'] = 'There is already a Person available with this Name';
            }

            $personData = getSinglePerson($post['EName']);
            $post['EPhone'] = $personData['Phone'];

            if ( empty($errors) ) {
                insertData($table, $post);
            } else {
                $oldData = $post;
            }

            break;
    }

}

function insertData( $table, $data ) {
    $conn = pdo_connection();

    $columnString = implode(',', array_keys($data));
    $valueString = implode(',', array_fill(0, count($data), '?'));


    try {
        $stmt = $conn->prepare("INSERT INTO $table ({$columnString}) VALUES ({$valueString})");
        return $stmt->execute(array_values($data));
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function isUniqueValue( $table, $column, $value, $exceptValue = '' ) {
    $conn = pdo_connection();
    if ( $exceptValue ) {
        try {

            $stmt = $conn->prepare('SELECT count(*) as total FROM ' . $table . ' WHERE ' . $column . ' = :' . $column . ' AND ' . $column . ' NOT IN ('.$exceptValue.')' );
            $stmt->execute(array(
                ':'.$column => $value
            ));
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return $result->total > 0 ? FALSE : TRUE;

        } catch (PDOException $ex) {
            throw $ex;
        }
    } else {
        try {
            $stmt = $conn->prepare('SELECT count(*) as total FROM ' . $table . ' WHERE ' . $column . ' = :' . $column );
            $stmt->execute(array(
                ':'.$column => $value
            ));
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return $result->total > 0 ? FALSE : TRUE;

        } catch (PDOException $ex) {
            throw $ex;
        }
    }
}

function getStore() {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT * FROM store ORDER BY StoreID ASC');
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPerson() {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT p.* FROM person p LEFT OUTER JOIN employee e ON e.ENAME = p.Name WHERE e.ENAME IS NULL ORDER BY p.`Name` ASC');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSinglePerson( $name ) {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT * FROM person WHERE `Name` = ?');
    $stmt->execute(array($name));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}