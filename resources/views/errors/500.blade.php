<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Error 500</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-dark.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ffm-brand.css') }}" rel="stylesheet">
    <style>
      html, body {
        background-color: #0B0F1A !important;
        color: #ffffff !important;
        font-family: 'Inter', system-ui, sans-serif !important;
        margin: 0;
        padding: 0;
        min-height: 100vh;
      }
      .wrap-center {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to bottom right, #0B0F1A, #1f2937, #0B0F1A);
      }
      .error-page h1 {
        font-family: 'Inter', system-ui, sans-serif !important;
        font-size: 120px;
        font-weight: 800;
        background: linear-gradient(to right, rgb(249, 115, 22), rgb(147, 51, 234));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 16px;
      }
      .error-page p {
        color: #9ca3af !important;
        font-size: 18px;
        font-weight: 400;
      }
    </style>
  </head>
  <body>
    <div class="wrap-center">
      <div class="container">
        <div class="row">
          <div class="col-md-12 error-page text-center">
            <h1>500</h1>
            <p class="mt-3 mb-5">Server Error</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>