$(document).ready(function () {

    function getCook(cookiename)
    {
        // Get name followed by anything except a semicolon
        var cookiestring=RegExp(cookiename+"=[^;]+").exec(document.cookie);
        // Return everything after the equal sign, or an empty string if the cookie name not found
        return decodeURIComponent(!!cookiestring ? cookiestring.toString().replace(/^[^=]+./,"") : "");
    }

    // get user info by auth
    $('.auth-request').on('click', function () {
       let user = $('.user-name').val();
       let pass = $('.user-pass').val();

       if ( (user === '') || (pass === ''))
       {
           $('.user-err').text('Все поля необходимо заполнить!');
       }
       else
       {
           $('.user-err').text('');

           if ( (user != 'admin') || (pass != '123') )
           {
               $('.user-err').text('Неправильные реквизиты доступа');
           }
           else
           {
               document.cookie = "user=" + user + ";path=/";
               location.reload();
           }
       }
    });

    // logout
    $('.btn-logout').on('click', function () {
       document.cookie = "user=";
       location.reload();
    });

    // add task validate

    function validateEmail(email)
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    $('.btn-add-task').on('click', function () {
       let name = $('.task-name').val();
       let email = $('.task-email').val();
       let message = $('.task-message').val();

       if ( (name === '') || (email === '') || (message === '') )
       {
           $('.task-err').text('Ошибка валидации');
       }
       else {
           $('.task-err').text('');

           if (!validateEmail(email))
           {
               $('.task-err').text('Email невалиден');
           }
           else
           {
               $('.task-err').text('');

               $.ajax({
                   type: 'POST',
                   url: '/addTask',
                   data: 'name=' + name + '&email=' + email + '&message=' + message,
                   success: function(data) {
                       console.log(data);
                       if (data == 'added')
                       {
                           alert('Задача успешно добавлена');
                           location.reload();
                       }
                   }
               });
           }
       }

    });

    // change status of a task

    $('.check-task').on('change', function () {
       let taskID = $(this).parents('.task-item').attr('id');
       let taskStatus = $(this).is(':checked');
       if (taskStatus === true) taskStatus = 1;
       if (taskStatus === false) taskStatus = 0;

        $.ajax({
            type: 'POST',
            url: '/checkTask',
            data: 'id=' + taskID + '&end=' + taskStatus,
            success: function(data) {
                if (data == 'checked')
                {
                    location.reload();
                }
            }
        })
    });

    // edit a task client
    $('.edit-task').on('click', function () {
       if (getCook('user')) {
           let taskID = $(this).parents('.task-item').attr('id');
           $(this).siblings('.task-item').css('display', 'none');
           $(this).siblings('.visible').css('display', 'block');
           $(this).css('display', 'none');
           $(this).siblings('.update-task').css('display', 'inline');
       }
       else {
           alert('Необходимо авторизоваться');
       }
    });

    // edit a task server
    $(document).on('click', '.update-task', function () {
        let taskID = $(this).parents('.task-item').attr('id');
        let taskName = $(this).siblings('.task-name').val();
        let taskEmail = $(this).siblings('.task-email').val();
        let taskMessage = $(this).siblings('.task-message').val();

        $.ajax({
            type: 'POST',
            url: '/updateTask',
            data: 'id=' + taskID + '&name=' + taskName + '&email=' + taskEmail + '&message=' + taskMessage,
            success: function(data) {
                if (data == 'updated')
                {
                    location.reload();
                }
            }
        })
    });





});