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
            if ( !empty($personData) ) {
                $post['EPhone'] = $personData['Phone'];
            } else {
                //create person
                insertData('person', array(
                    'Name' => $post['EName'],
                    'Phone' => $post['EPhone'],
                ));
            }



            if ( empty($errors) ) {
                insertData($table, $post);
            } else {
                $oldData = $post;
            }

            break;
            
        case 'customer':

            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            unset($post['operation']);
            unset($post['table']);

            $errors = array();
            foreach ( $post as $key => $value ) {
                if ( !strlen(trim($value)) ) {
                    $errors[$key] = ucwords(str_replace('_',' ', $key)) . ' is required.';
                }
            }
            $validateStoreId = isUniqueValue( $table, 'Cname', $post['Cname'] );
            if ( ! $validateStoreId ) {
                $errors['Cname'] = 'There is already a Person available with this Name';
            }

            $personData = getSinglePerson($post['Cname']);
            if ( !empty($personData) ) {
                $post['Cphone'] = $personData['Phone'];
            } else {
                //create person
                insertData('person', array(
                    'Name' => $post['Cname'],
                    'Phone' => $post['Cphone'],
                ));
            }



            if ( empty($errors) ) {
                insertData($table, $post);
            } else {
                $oldData = $post;
            }

            break;
    }

} else if ( isset($_POST['operation']) && $_POST['operation'] == 'update' ) {

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
            $validateStoreId = isUniqueValue( $table, 'StoreID', $post['StoreID'], $post['StoreID'] );
            if ( ! $validateStoreId ) {
                $errors['StoreID'] = 'There is already a Store available with this ID';
            }

            if ( empty($errors) ) {
                updateData($table, $post, array());
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
            $validateStoreId = isUniqueValue( $table, 'CompanyID', $post['CompanyID'], $post['CompanyID'] );
            if ( ! $validateStoreId ) {
                $errors['CompanyID'] = 'There is already a Supplier available with this CompanyID';
            }

            if ( empty($errors) ) {
                $update = $post;
                unset($update['CompanyID']);
                updateData($table, $update, array( 'CompanyID = :pK ', array('pK' => $post['CompanyID']) ));
                header('Location: /supplier.php');
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
            $validateStoreId = isUniqueValue( $table, 'BarCode', $post['BarCode'], $post['BarCode'] );
            if ( ! $validateStoreId ) {
                $errors['BarCode'] = 'There is already a Product available with this BarCode';
            }

            if ( empty($errors) ) {
                $update = $post;
                unset($update['BarCode']);
                updateData($table, $update, array(' BarCode = :pK ', array('pK' => $post['BarCode'])));
                header('Location: /product.php');
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
            $validateStoreId = isUniqueValue( $table, 'EName', $post['EName'], $post['EName'] );
            if ( ! $validateStoreId ) {
                $errors['EName'] = 'There is already a Person available with this Name';
            }

            $personData = getSinglePerson($post['EName']);
            if ( !empty($personData) ) {
                $post['EPhone'] = $personData['Phone'];
            } else {
                //create person
                insertData('person', array(
                    'Name' => $post['EName'],
                    'Phone' => $post['EPhone'],
                    'Address' => 'NA',
                ));
            }



            if ( empty($errors) ) {

                $update = $post;
                unset($update['EName']);

                updateData($table, $update, array( 'EName = :pK ', array('pK' => $post['EName']) ));
                header('Location: /employee.php');
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

function updateDataOld( $table, $data, array $where ) {
    $conn = pdo_connection();

    try {
        $query = "UPDATE {$table} SET ";
        foreach($data as $column => $arr_value_set) {
            $query .= $column . ' = :' . $column . ', ';
        }
        $query = rtrim($query, ', ');
        $query .= ' WHERE '. $where[0];

        $stmt = $conn->prepare($query);
        foreach($data as $column => $arr_value_set) {
            $stmt->bindParam(':' . $column, $arr_value_set, PDO::PARAM_STR);
            //echo ':' . $column . ' = '. $arr_value_set . ', ';
        }
        foreach($where[1] as $c => $v) {
            $stmt->bindParam(':' . $c, $v, PDO::PARAM_STR);
        }

        return $stmt->execute();
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function updateData( $table, $data, array $where ) {
    $conn = pdo_connection();

    $updates = array_filter($data, function ($value) {
        return null !== $value;
    });

    try {
        $query = 'UPDATE '.$table.' SET';
        $values = array();

        foreach ($updates as $name => $value) {
            $query .= ' '.$name.' = :'.$name.','; // the :$name part is the placeholder, e.g. :zip
            $values[':'.$name] = $value; // save the placeholder
        }
        $query = substr($query, 0, -1); // remove last , and add a ;
        $query .= ' WHERE '. $where[0];
        $values[':pK'] = $where[1]['pK'];

        $sth = $conn->prepare($query);
        $sth->execute($values);
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function isUniqueValue( $table, $column, $value, $exceptValue = '' ) {
    $conn = pdo_connection();

    if ( $exceptValue ) {
        try {
            $stmt = $conn->prepare('SELECT count(*) as total FROM ' . $table . ' WHERE ' . $column . ' = :' . $column . ' AND ' . $column . ' NOT IN (:expValue)' );
            $stmt->execute(array(
                ':'.$column => $value,
                ':expValue' => $exceptValue,
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

function checkValueIsAvailableInTable( $table, $column, $value ) {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT count(*) as `total` FROM '.$table.' WHERE ' . $column . ' = ?');
    $stmt->execute(array($value));

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result->total > 0;
}

function getSinglePerson( $name ) {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT * FROM person WHERE `Name` = ?');
    $stmt->execute(array($name));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getSupplier( $companyId ) {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT * FROM supplier WHERE `CompanyID` = ?');
    $stmt->execute(array($companyId));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getEmployee( $name ) {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT * FROM employee WHERE `EName` = ?');
    $stmt->execute(array($name));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getProduct( $barCode ) {
    $conn = pdo_connection();

    $stmt = $conn->prepare('SELECT * FROM product WHERE `BarCode` = ?');
    $stmt->execute(array($barCode));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
