<?php

    include_once ROOT . '/models/Index.php';

    class TaskController
    {
        public function actionAdd()
        {

            $params = array();
            $params = [
                'name' => htmlspecialchars($_POST['name']),
                'email' => $_POST['email'],
                'message' => htmlspecialchars($_POST['message'])
            ];

            $addTask = Index::addTask($params);
            echo $addTask;
        }

        public function actionCheck()
        {
            $params = [
                'id' => $_POST['id'],
                'end' => $_POST['end']
            ];

            $checkTask = Index::checkTask($params);
            echo $checkTask;
        }

        public function actionUpdate()
        {
            $params = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'message' => $_POST['message']
            ];

            $updateTask = Index::updateTask($params);
            echo $updateTask;
        }

        public function actionIndex()
        {
            echo 'product index';
            return true;
        }
    }

?>