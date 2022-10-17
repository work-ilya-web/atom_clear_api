<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Swagger UI</title>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/swagger/swagger-ui.css') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/swagger/favicon-32x32.png') ?> sizes=" 32x32" />
  <link rel="icon" type="image/png" href="<?= base_url('assets/swagger/favicon-16x16.png') ?> sizes=" 16x16" />
  <style>
    html {
      box-sizing: border-box;
      overflow: -moz-scrollbars-vertical;
      overflow-y: scroll;
    }

    *,
    *:before,
    *:after {
      box-sizing: inherit;
    }

    body {
      margin: 0;
      background: #fafafa;
    }
    .form-token{
        padding: 10px;
        background-color: #333;
    }
    .form-token__text{
        width: calc(100% - 150px);
        margin: 0;
        border: 2px solid #62a03f;
        border-radius: 4px 0 0 4px;
        outline: none;
        padding: 8px;
    }
    .form-token__btn {
        font-size: 16px;
        font-weight: 700;
        padding: 8px 30px;
        border: none;
        border-radius: 0 4px 4px 0;
        background: #62a03f;
        font-family: sans-serif;
        color: #fff;
        margin-left: -4px;
        position: relative;
        top: 1px;
        height: 35.5px;
        width: 150px;
    }
    .swagger-ui .auth-wrapper {
        display: none;
    }
  </style>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>

<body>
    <form class="form-token" action="/Swagger" method="get">
        <input name="token"  type="text" value="<?= @$_GET['token']?>" class="form-token__text" placeholder="token для авторизации">
        <input type="submit" name="send" value="Authorize" class="form-token__btn">
    </form>
  <div id="swagger-ui"></div>
  <div class="swagger-ui ">
      <div class="information-container wrapper">
          <p>Данные правила работают со всеми энд поинтами для Получение списка записей</p>
          <section class="block col-12">
              <ul>
                <li>сортировка по параметрам <i>{"order":[{"id":"desc"},{"tgl_upload":"asc"}]}</i></i></li>
                <li>поиск по параметру <i>{"search":[{"id_kategori":1}]}</i></i></li>
                <li>поиск по диапазону <i>{"search":[{"tgl_upload":{"start":"2016-01-01", "end":"2020-01-01"} }]}</i></li>
                <li>поиск по параметру like <i>{"search":[{"judul":"membangun|"}]}</i> or {"search":[{"judul":"|membangun|"}]}</i> </li>
                <li>поиск по get параметру <i>{base_url}/artikels?search[id_kategori]=1</i></li>
                <li>сортировка по get параметру <i>{base_url}/artikels?order[id]=desc&order[tgl_upload]=asc</i></li>
                <li>поиск и сортировка по get параметрам <i>{base_url}/artikels?search[id_kategori]=1&order[id]=desc&order[tgl_upload]=asc</i></li>
                <li>пагинация <i>{base_url}/artikels?page=1&limit=10</i></li>
                <li>И поиск и сортировка и пагинация <i>{base_url}/artikels?search[id_kategori]=1&order[id]=desc&order[tgl_upload]=asc&page=1&limit=10</i></li>
                <li>поиск с использованием оператора между, если мы хотим фильтровать данные на основе диапазона дат и т. д. <i>{base_url}/artikels?search[tgl_upload][start]=2016-01-01&search[tgl_upload][end]=2020-01-01</i></li>
                <li>поиск по ключевому слову <i>{base_url}/artikels?search[judul]=membangun|</i> или {base_url}/artikels?search[judul]=|membangun|</i> будет использовать like для поиска</li>
              </ul>
        </section>
      </div>
  </div>


  <script src="<?= base_url('assets/swagger/swagger-ui-bundle.js') ?>"> </script>
  <script src="<?= base_url('assets/swagger/swagger-ui-standalone-preset.js') ?>"> </script>
  <script>
    window.onload = function() {
      // Begin Swagger UI call region
      const ui = SwaggerUIBundle({
        url: "<?= base_url('assets/api.yaml') ?>",
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        requestInterceptor: (req) => {
            console.log(req);
            req.headers.Authorization = "Bearer <?= @$_GET['token']?>"
            return req
        },
        plugins: [
          SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout"
      })
      // End Swagger UI call region



      window.ui = ui


    }

</script>
</body>

</html>
