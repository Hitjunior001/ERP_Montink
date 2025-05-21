<!DOCTYPE html>
<html>
<head>
    <title>ERP - Montink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <style>
        :root {
            --dark-bg: #1a1a1a;
            --rose: #ff4d88;
            --green: #4cd137;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        header {
            background-color: var(--dark-bg);
            padding: 15px 30px;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        header nav h1 {
            font-size: 24px;
            color: var(--rose);
            margin: 0;
        }
        .nav{
            display: flex;
            justify-content: space-around;
        }

        footer {
            margin-top: 40px;
            padding: 15px 30px;
            background-color: var(--dark-bg);
            color: var(--green);
            border-top: 2px solid var(--rose);
            text-align: center;
            font-size: 14px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        a {
            color: white;
            text-decoration: none;
            margin: 5px;
            
        }

        a:hover {
            color: var(--green);
        }

        :root {
            --dark-bg: #1a1a1a;
            --rose: #ff4d88;
            --green: #4cd137;
        }

        .btn-custom {
            background-color: var(--rose);
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: var(--green);
            color: #000;
        }

        .btn-outline-rose {
            border: 1px solid var(--rose);
            color: var(--rose);
            background-color: transparent;
        }

        .btn-outline-rose:hover {
            background-color: var(--rose);
            color: white;
        }

        table.table-dark td, table.table-dark th {
            vertical-align: middle;
        }
    </style>
</head>
<header>
  <nav class="navbar navbar-expand-lg" style="background-color: var(--dark-bg); box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
    <div class="container-fluid">
      <a class="navbar-brand text-white fw-bold" href="<?= site_url('index.php/products'); ?>" style="color: var(--rose) !important;">
        ERP - Montink
      </a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= site_url('index.php/products/insert_product'); ?>">Criar Produto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= site_url('index.php/products/insert_product_variation'); ?>">Criar Variação</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= site_url('index.php/products'); ?>">Listar Produtos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= site_url('index.php/variations'); ?>">Listar Variações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= site_url('index.php/coupons'); ?>">Cupons</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
