<?php
//-------- CATEGORIES --------//


/**
 * GET all todos
 */
$app->get('/todo', function () use ($app, $mysqli, $response) {
  // Return all todos
  if ($result = $mysqli->query("SELECT * FROM todos")) {
    $response['success'] = TRUE;
    $response['data'] = Array();
    while($row = $result->fetch_object()) {
      $response['data'][] = $row;
    }
  } else {
    $response['error'] = $mysqli->error;
  }

  $app->response->setBody(json_encode($response));
});

/**
 * GET a single todo by id
 */
$app->get('/todo/:id', function ($id) use ($app, $mysqli, $response) {
    $id = $mysqli->real_escape_string($id);

    // Return todo identified by $id
    if ($result = $mysqli->query("SELECT * FROM todos WHERE id = '$id'")) {
        if($row = $result->fetch_object()) {
            $response['success'] = TRUE;
            $response['data'] = $row;
        } else {
            $response['error'] = "no todo found matching id $id";
        }
    } else {
        $response['error'] = $mysqli->error;
    }

    $app->response->setBody(json_encode($response));
});

/**
 * Add a todo
 */
$app->post('/todo', function () use ($app, $mysqli, $response) {
    $body = json_decode($app->request->getBody());

    $name = $mysqli->real_escape_string($body->name);
    $status = $mysqli->real_escape_string($body->status);

    // Insert todo
    if ($mysqli->query("INSERT INTO todos (name, status) VALUES('$name', '$status');")) {
        $response['success'] = TRUE;
        $response['action'] = 'todo inserted';
        $response['id'] = $mysqli->insert_id;
        CommonMethods::logAction($mysqli, "TODO added", "$name");
    } else {
        $response['error'] = $mysqli->error;
        CommonMethods::logAction($mysqli, "TODO $name could not be added", $mysqli->error);
    }

    $app->response->setBody(json_encode($response));
});

/**
 * Update a todo
 */
$app->put('/todo/:id', function ($id) use ($app, $mysqli, $response) {
    $id = $mysqli->real_escape_string($id);
    $body = json_decode($app->request->getBody());

    $name = $mysqli->real_escape_string($body->name);
    $status = $mysqli->real_escape_string($body->status);

    $todo = $mysqli->query("SELECT * FROM todos WHERE id = '$id'")->fetch_object();
    if ($todo) {
        // Update todo identified by $id
        if ($mysqli->query("UPDATE todos SET name = '$name', status = '$status' WHERE id = '$id';")) {
            $response['success'] = TRUE;
            $response['action'] = 'todo updated';
        } else {
            $response['error'] = $mysqli->error;
        }
    } else {
        $response['error'] = "no todo found matching id $id";
    }

    $app->response->setBody(json_encode($response));
});

/**
 * DELETE a todo
 */
$app->delete('/todo/:id', function ($id) use ($app, $mysqli, $response) {
    $id = $mysqli->real_escape_string($id);

    $todo = $mysqli->query("SELECT * FROM todos WHERE id = '$id'")->fetch_object();
    if ($todo) {
        // Delete todo identified by $id
        if ($mysqli->query("DELETE FROM todos WHERE id = '$id';")) {
            $response['success'] = TRUE;
            $response['action'] = 'todo deleted';
            CommonMethods::logAction($mysqli, "TODO deleted", "$id");
        } else {
            $response['error'] = $mysqli->error;
            CommonMethods::logAction($mysqli, "TODO $id could not be deleted", $mysqli->error);
        }
    } else {
        $response['error'] = "no todo found matching id $id";
    }
    $app->response->setBody(json_encode($response));
});
