<?php

    include_once ROOT . '/models/Index.php';
    class IndexController
    {
        public function actionIndex()
        {
            $tasks = array();
            $tasks = Index::getTasks();

            include_once ROOT . '/views/index.php';
        }


    }

?>