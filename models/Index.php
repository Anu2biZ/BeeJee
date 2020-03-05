<?
    class Index {

        public static function getTasks()
        {
            $db = Db::getConnection();

            $tasks = array();
            $result = $db->query("SELECT * FROM tasks");

            $i = 0;
            while($row = $result->fetch())
            {
                $tasks[$i]['id'] = $row['id'];
                $tasks[$i]['name'] = $row['name'];
                $tasks[$i]['email'] = $row['email'];
                $tasks[$i]['message'] = $row['message'];
                $tasks[$i]['edit'] = $row['edit'];
                $tasks[$i]['end'] = $row['end'];
                $i++;
            }

            return $tasks;
        }

        public static function addTask($params)
        {
           $db = Db::getConnection();
           $query = "INSERT INTO `tasks` (`name`, `email`, `message`, `edit`, `end`) VALUES (:name, :email, :message, '0', '0')";
           $prepareParams = [
               ':name' => $params['name'],
               ':email' => $params['email'],
               ':message' => $params['message']
           ];

           try
           {
               $res = $db->prepare($query);
               if (! $res->execute($prepareParams))
               {
                print_r($db->errorInfo());
               }
               else
               {
                return 'added';
               }
           }
           catch(Exception $e)
           {
            var_dump($e->getMessage());
           }
        }

        public static function checkTask($params)
        {
           $db = Db::getConnection();
           $query = "UPDATE `tasks` SET end = :end WHERE id = :id";
           $prepareParams = [
               ':id' => $params['id'],
               ':end' => (int)$params['end']
           ];

           try
           {
               $res = $db->prepare($query);
               if (! $res->execute($prepareParams))
               {
                print_r($db->errorInfo());
               }
               else
               {
                return 'checked';
               }
           }
           catch(Exception $e)
           {
            var_dump($e->getMessage());
           }
        }

        public static function updateTask($params)
        {
           $db = Db::getConnection();
           $query = "UPDATE `tasks` SET edit = 1, name = :name, email = :email, message = :message WHERE id = :id";
           $prepareParams = [
               ':id' => $params['id'],
               ':name' => $params['name'],
               ':email' => $params['email'],
               ':message' => $params['message']
           ];

           try
           {
               $res = $db->prepare($query);
               if (! $res->execute($prepareParams))
               {
                print_r($db->errorInfo());
               }
               else
               {
                return 'updated';
               }
           }
           catch(Exception $e)
           {
            var_dump($e->getMessage());
           }
        }

    }


?>