<DOCTYPE HTML>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Пример страницы</title>
        </head>
        <body>
            <header>
                <p>Это шапка тестовой страницы</p>
            </header>
            <div>
                <p>Это тело тестовой страницы</p>
            </div>
            <div>
                <form name = "reg" method = "POST" action="/src/sql.php"> 
                    <p>Никнейм:<input type = "text" name = "nick"></P>
                    <p>ФИО:<input type = "text" name = "name"></P>
                    <p>email:<input type = "text" name = "email"></P>
                    <p>Дата рождения:<input type = "date" name = "data"></P>
                    <p>Город:<input type = "text" name = "city"></P>
                    <input type = submit value = "Готово" name = "done">
                </form>
            </div>
            <footer>
                <p>Это подвал тестовой страницы</p>
            </footer>
        </body>     
    </html>
