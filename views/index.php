<?php
if ($_POST) {
    exit;
}
?>

<html>
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="/public/style.css" rel="stylesheet">
    </head>


    <body>

    <? if (!$_COOKIE['user']) : ?>
        <div class="text-center btn-auth">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-auth">
              Вход для администратора
            </button>
        </div>
    <? endif; ?>

    <? if ($_COOKIE['user']) : ?>
        <div class="text-center btn-logout">
            <button type="button" class="btn btn-primary">
             Выход
            </button>
        </div>
    <? endif; ?>

    <div class="text-center btn-task">
        <button class="addTask btn btn-light"  data-toggle="modal" data-target="#addTask">Создать задачу</button>
    </div>
        <div class="sorts">
            <a href="/?sortBy=name&order=ASC">Сортировать по имени по увеличению</a>
            <a href="/?sortBy=name&order=DESC">Сортировать по имени по убыванию</a>
            <a href="/?sortBy=email&order=ASC">Сортировать по почте по увеличению</a>
            <a href="/?sortBy=email&order=DESC">Сортировать по почте по убыванию</a>
            <a href="/?sortBy=end&order=ASC">Сортировать по статусу по увеличению</a>
            <a href="/?sortBy=end&order=DESC">Сортировать по статусу по убыванию</a>
        </div>
        <div class="container text-center task-list">
            <? $tasksCount = count($tasks);
               $tasksPages = ceil($tasksCount / 3);

               if (isset($_GET['sortBy']))
               {
                $sort = array_column($tasks, $_GET['sortBy']);
                if ($_GET['order'] == 'ASC')
                    array_multisort($sort, SORT_ASC, $tasks);
                else
                    array_multisort($sort, SORT_DESC, $tasks);
               }


               if (isset($_GET['offset'])) {
                $i = $_GET['offset'] - 3;
               }
               else {
               $i = 0;
               }
            ?>
            <? for($k = $i; $k < count($tasks); $k++): ?>
            <div class="card task-item" style="width: 18rem;" id="<? echo $tasks[$i]['id']; ?>">
              <div class="card-body">
                <? if ($_COOKIE['user']) : ?>
                    <button class="edit-task btn btn-warning btn-sm">Редактировать</button>
                    <button class="update-task btn btn-success btn-sm">Редактировать</button>
                    <br>
                    <br>
                <? endif; ?>
                <h5 class="card-title task-item"><? echo $tasks[$i]['name']; ?></h5>
                <input type="text" class="visible task-name-new form-control" value="<? echo $tasks[$i]['name']; ?>">
                <p class="card-text task-item"><? echo $tasks[$i]['email']; ?></p>
                <input type="text" class="visible task-email-new form-control" value="<? echo $tasks[$i]['email']; ?>">
                <p class="task-item">
                    <? echo $tasks[$i]['message']; ?>
                </p>
                <input type="text" class="visible form-control task-message-new" value="<? echo $tasks[$i]['message']; ?>">
                <? if ($tasks[$i]['edit'] == 1 ) : ?>
                    <label class="badge badge-primary">Отредактировано администратором</label>
                    <br>
                <? endif; ?>
                <? if ($tasks[$i]['end'] == 1 ) : ?>
                    <label class="badge badge-success">Выполнено</label>
                    <br>
                <? endif; ?>
                <? if ($_COOKIE['user']) : ?>
                    <? if ($tasks[$i]['end'] == 0): ?>
                        <input type="checkbox" class="check-task" >
                    <? else : ?>
                        <input type="checkbox" class="check-task" checked>
                    <? endif; ?>
                <? endif; ?>
              </div>
            </div>

            <?
                $i++;
                if (isset($_GET['offset'])) {
                    if ($i == $_GET['offset']) break;
                }
                else {
                    if ($i == 3) break;
                }

                endfor;
             ?>

            <div class="pagination">
                <? if (! isset($_GET['sortBy'])) : ?>
                 <? for($j = 1; $j < $tasksPages + 1; $j++) : ?>
                     <a href="/?offset=<? echo $j*3; ?>"><? echo $j; ?></a>
                 <?
                     endfor;
                     endif;
                 ?>

                 <? if (isset($_GET['sortBy'])) : ?>
                  <? for($j = 1; $j < $tasksPages + 1; $j++) : ?>
                      <a href="/?offset=<? echo $j*3; ?>&sortBy=<? echo $_GET['sortBy']; ?>&order=<? echo $_GET['order']; ?>"><? echo $j; ?></a>
                  <?
                      endfor;
                      endif;
                  ?>
             </div>
        </div>


        <div class="modal fade" id="modal-auth" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Вход для администратора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type='text' class="form-control user-name" placeholder="Логин">
                <br>
                <input type='password' class="form-control user-pass">
                <br>
                <div class="user-err text-center text-danger"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary auth-request">Войти</button>
              </div>
            </div>
          </div>
        </div>



        <div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создать задачу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input class="form-control task-name" placeholder="Имя" type="text">
                <br>
                <input class="form-control task-email" placeholder="Email" type="email">
                <br>
                <input class="form-control task-message" placeholder="Текст задачи" type="text">
                <br>
                <div class="text-center text-danger task-err"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-add-task">Создать задачу</button>
              </div>
            </div>
          </div>
        </div>


        <script
          src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
          crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="/public/main.js"></script>
    </body>
</html>